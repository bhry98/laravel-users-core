<?php

use Bhry98\LaravelUsersCore\Models\UsersCoreTypesModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::create(
            table: UsersCoreTypesModel::TABLE_NAME,
            callback: function (Blueprint $table) {
                $table->id();
                $table->uuid(column: 'code')->unique();
                $table->string(column: 'default_name', length: 50);
                $table->json(column: 'names')->nullable();
                $table->boolean(column: 'api_access')->default(value: true);
                $table->boolean(column: 'can_delete')->default(value: false);
                $table->softDeletes();
                $table->timestamps();
            });
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists(table: UsersCoreTypesModel::TABLE_NAME);
        Schema::enableForeignKeyConstraints();
    }
};
