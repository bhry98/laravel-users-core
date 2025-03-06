<?php

namespace Bhry98\LaravelUsersCore\Services;

use Bhry98\LaravelUsersCore\Models\UsersCoreExtraColumnsModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreUsersVerifyModel;
use Bhry98\LaravelUsersCore\Notifications\SendResetPasswordOtpViaEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UsersCoreUsersService
{
    public function registerNormalUser(array $data)
    {
        // check if normal user exists
        $normalUserType = UsersCoreTypesService::getNormalUserType();
        // if normal user type not found return null
        throw_if(!$normalUserType, "No user type [normal] found");
        // add normal user in database
        $data['type_id'] = $normalUserType->id;
        $data['country_id'] = UsersCoreLocationsService::getCountryDetails($data['country_id'])?->id;
        $data['governorate_id'] = UsersCoreLocationsService::getGovernorateDetails($data['governorate_id'])?->id;
        $data['city_id'] = UsersCoreLocationsService::getCityDetails($data['city_id'])?->id;
        $user = UsersCoreUsersModel::create($data);
        if ($user) {
            // if added successfully add log [info] and return user
            Log::info("User registered successfully with id {$user->id}", ['user' => $user]);
            return $user;
        } else {
            // if added successfully add log [error] and return user
            Log::error("User registered field");
            return null;
        }
    }

    public function createNewVerifyCode(UsersCoreUsersModel $user)
    {

        UsersCoreUsersVerifyModel::where([
            "user_id" => $user?->id,
        ])->update([]);
        $record = UsersCoreUsersVerifyModel::create([
            "verify_code" => rand(126457, 968748),
            "user_id" => $user?->id,
            "expired_at" => now(config(key: 'app.timezone'))->addMinutes(value: 10),
        ]);
        if ($record) {
            // if added successfully add log [info] and return user
            Log::info(message: "User {$user->code} request a new verify code successfuly with id {$record->id}", context: ['user' => $user, 'record' => $record]);
            return $record;
        } else {
            // if added successfully add log [error] and return user
            Log::error(message: "User {$user->code} request a new verify code field");
            return null;
        }
    }

    public function verifyOtp(string $user_email, int $otp): bool
    {
        $user = UsersCoreUsersModel::where('email', $user_email)->first();
        $record = UsersCoreUsersVerifyModel::where([
            "verify_code" => $otp,
            "user_id" => $user?->id,
        ])->first();
        $is_past = Carbon::parse($record->expired_at)->isPast();
        if ($record && !$is_past) {
            return $record->update(['expired_at' => now(config(key: 'app.timezone'))->subMinute()]);
        } else {
            return false;
        }
    }

    public function registerByType(array $data)
    {
        // check if normal user exists
        $userType = UsersCoreTypesService::getByCode(code: $data['type_code']);
        // if normal user type not found return null
        throw_if(!$userType, "No user type found");
        // add normal user in database
        $data['type_id'] = $userType->id;
        $data['country_id'] = UsersCoreLocationsService::getCountryDetails($data['country_id'])?->id;
        $data['governorate_id'] = UsersCoreLocationsService::getGovernorateDetails($data['governorate_id'])?->id;
        $data['city_id'] = UsersCoreLocationsService::getCityDetails($data['city_id'])?->id;
        $user = UsersCoreUsersModel::create($data);
        if ($user) {
            // if added successfully add log [info] and return user
            Log::info("User registered successfully with id {$user->id}", ['user' => $user]);
            return $user;
        } else {
            // if added successfully add log [error] and return user
            Log::error("User registered field");
            return null;
        }
    }

    public function loginViaUser(UsersCoreUsersModel|\Illuminate\Contracts\Auth\Authenticatable $user): string
    {
        Auth::guard(name: config(key: "bhry98-users-core.guard"))->loginUsingId($user->id);
        $tokenResult = $user->createToken($user->code);
        return $tokenResult->plainTextToken;
    }

    public function loginViaEmail(string $user_email): string
    {
        $user = UsersCoreUsersModel::where('email', $user_email)->first();
        Auth::guard(name: config(key: "bhry98-users-core.guard"))->loginUsingId($user->id);
        $tokenResult = $user->createToken($user->code);
        return $tokenResult->plainTextToken;
    }

    static public function getAuthUser(array|null $relations = null): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        $authUser = Auth::user();
        $user = UsersCoreUsersModel::where('code', $authUser?->code);
        if ($user && $relations) {
            $user->with($relations);
        }
        return $user->first();
    }

    public function loginViaUsernameAndPassword(array $data): string|null
    {
        if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            $user = self::getAuthUser();
            Log::info("User login successfully with id {$user?->id}", ['user' => $user]);
            return self::loginViaUser($user);
        } else {
            Log::error("User login failed", ['credential' => $data]);
            return null;
        }
    }

    public function loginViaPhoneAndPassword(array $data): string|null
    {
        if (Auth::attempt(['phone_number' => $data['phone_number'], 'password' => $data['password']])) {

            $user = self::getAuthUser();
            Log::info("User login successfully with id {$user?->id}", ['user' => $user]);
            return self::loginViaUser($user);
        } else {
            Log::error("User login failed", ['credential' => $data]);
            return null;
        }
    }

    public function logout(): bool
    {
        Log::info("User logged out successfully", ['user' => Auth::user()]);
        Auth::user()?->currentAccessToken()->delete();
        Auth::forgetUser();
        return !auth()->check();
    }

    public function updateProfile(array $data): bool
    {
        $user = self::getAuthUser();
        $update = $user->update($data);
        if ($update) {
            // if added successfully add log [info] and return user
            Log::info("User updated his profile successfully with id {$user->id}", ['user' => $user, "update" => $data]);
        } else {
            // if added successfully add log [error] and return user
            Log::error("User updated his profile field", ['user' => $user, "update" => $data]);
        }
        return $update;
    }

    public function sendOtpViaEmail(string $user_email)
    {
        $user = UsersCoreUsersModel::where('email', $user_email)->first();
        if (!$user) return null;
        $otp = self::createNewVerifyCode($user);
        Log::info("User created otp successfully", ['user' => $user, "otp" => $otp]);
        Config::set('mail.mailers.smtp', config("bhry98-users-core.smtp"));
        Mail::mailer("smtp")->to($user->email)->send(new SendResetPasswordOtpViaEmail($otp, $user));
        return $otp;
    }

    public function updateAuthUserPassword($new_password): bool
    {
        $user = self::getAuthUser();
        $user->password = $new_password;
        return $user->save();
    }

}
