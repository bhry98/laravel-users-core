<?php

namespace Bhry98\LaravelUsersCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Bhry98\LaravelUsersCore\Http\Requests\auth\LoginRequest;
use Bhry98\LaravelUsersCore\Http\Requests\auth\RegistrationUserByTypeRequest;
use Bhry98\LaravelUsersCore\Http\Requests\auth\RegistrationUserRequest;
use Bhry98\LaravelUsersCore\Http\Requests\auth\ResetPasswordRequest;
use Bhry98\LaravelUsersCore\Http\Requests\auth\UpdatePasswordRequest;
use Bhry98\LaravelUsersCore\Http\Requests\auth\VerifyOtpRequest;
use Bhry98\LaravelUsersCore\Http\Resources\UserResource;
use Bhry98\LaravelUsersCore\Services\UsersCoreUsersService;
use Illuminate\Support\Facades\DB;

class UsersAuthController extends Controller
{
    function registration(RegistrationUserRequest $request, UsersCoreUsersService $usersCoreServices): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = $usersCoreServices->registerNormalUser($request->validated());
            if ($user) {
                $token = $usersCoreServices->loginViaUser($user);
                DB::commit();
                return bhry98_response_success_with_data([
                    'access_type' => 'Bearer',
                    'access_token' => $token,
                    "user" => UserResource::make($user),
                ]);
            } else {
                DB::rollBack();
                return bhry98_response_success_without_data();
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }

    function registrationByType(RegistrationUserByTypeRequest $request, UsersCoreUsersService $usersCoreServices): \Illuminate\Http\JsonResponse
    {
//        return bhry98_response_success_with_data([$request->validated()]);
        try {
            DB::beginTransaction();
            $user = $usersCoreServices->registerByType($request->validated());
            if ($user) {
                $token = $usersCoreServices->loginViaUser($user);
                DB::commit();
                return bhry98_response_success_with_data([
                    'access_type' => 'Bearer',
                    'access_token' => $token,
                    "user" => UserResource::make($user),
                ]);
            } else {
                DB::rollBack();
                return bhry98_response_success_without_data();
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }

    function login(LoginRequest $request, UsersCoreUsersService $usersCoreServices): \Illuminate\Http\JsonResponse
    {
        try {
            $loginWay = config(key: "bhry98-users-core.login_via");
            $token = match ($loginWay) {
                "email" => "email",
                "phone" => $usersCoreServices->loginViaPhoneAndPassword($request->validated()),
                default => $usersCoreServices->loginViaUsernameAndPassword($request->validated()),
            };
            if (is_null($token)) return bhry98_response_validation_error(['password' => __('validation.exists', ["attribute" => "password"])], __("bhry98::responses.login-failed"));
            return bhry98_response_success_with_data([
                'access_type' => 'Bearer',
                'access_token' => $token,
                "user" => UserResource::make($usersCoreServices->getAuthUser()),
            ]);
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }

    function logout(UsersCoreUsersService $usersCoreServices): \Illuminate\Http\JsonResponse
    {
        try {
            if ($usersCoreServices->logout()) {
                return bhry98_response_success_with_data(message: __("bhry98::responses.logout-success"));
            } else {
                return bhry98_response_success_without_data(message: __("bhry98::responses.logout-failed"));
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }

    function resetPassword(ResetPasswordRequest $request, UsersCoreUsersService $usersCoreServices): \Illuminate\Http\JsonResponse
    {
        try {
            $resetPasswordWay = config(key: "bhry98-users-core.reset_password_via");
            $resetCode = match ($resetPasswordWay) {
                "email" => $usersCoreServices->sendOtpViaEmail($request->email),
                default => $usersCoreServices->sendOtpViaEmail($request->email),
            };
            if ($resetCode) {
                return bhry98_response_success_with_data(message: __("bhry98::responses.reset-code-send-success"));
            } else {
                return bhry98_response_success_without_data(message: __("bhry98::responses.reset-code-send-failed"));
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }

    function verifyOtp(VerifyOtpRequest $request, UsersCoreUsersService $usersCoreServices): \Illuminate\Http\JsonResponse
    {
        try {
            $verifyCode = $usersCoreServices->verifyOtp($request->email, $request->otp);
            if ($verifyCode) {
                $token = $usersCoreServices->loginViaEmail($request->email);
                return bhry98_response_success_with_data(data: ['token'=>$token], message: __("bhry98::responses.verify-otp-success"));
            } else {
                return bhry98_response_success_without_data(message: __("bhry98::responses.verify-otp-failed"));
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }

    function updatePassword(UpdatePasswordRequest $request, UsersCoreUsersService $usersCoreServices): \Illuminate\Http\JsonResponse
    {
        try {
            $updatePassword = $usersCoreServices->updateAuthUserPassword($request->password);
            if ($updatePassword) {
                $usersCoreServices->logout();
                return bhry98_response_success_with_data( message: __("bhry98::responses.password-updated-success"));
            } else {
                return bhry98_response_success_without_data(message: __("bhry98::responses.password-updated-failed"));
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
