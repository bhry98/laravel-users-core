<?php

use Bhry98\LaravelUsersCore\Models\{
    UsersCoreCountriesModel,
    UsersCoreCitiesModel,
    UsersCoreGovernoratesModel
};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::create(
            table: UsersCoreCitiesModel::TABLE_NAME,
            callback: function (Blueprint $table) {
                $table->id();
                $table->uuid(column: 'code')->index()->unique();
                $table->string(column: 'name', length: 50);
                $table->string(column: 'local_name', length: 50);
                $table->foreignId(column: 'country_id')
                    ->references(column: 'id')
                    ->on(table: UsersCoreCountriesModel::TABLE_NAME)
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
                $table->foreignId(column: 'governorate_id')
                    ->references(column: 'id')
                    ->on(table: UsersCoreGovernoratesModel::TABLE_NAME)
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
                $table->softDeletes();
                $table->timestamps();
            });
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists(table: UsersCoreCountriesModel::TABLE_NAME);
        Schema::enableForeignKeyConstraints();
    }
};
