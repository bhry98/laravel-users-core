<?php

use Bhry98\LaravelUsersCore\Models\{
    UsersCoreExtraColumnsModel,
    UsersCoreTypesModel
};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::create(
            table: UsersCoreExtraColumnsModel::TABLE_NAME,
            callback: function (Blueprint $table) {
                $table->id();
                $table->uuid(column: 'code')->unique();
                $table->foreignId(column: 'type_id')
                    ->references(column: 'id')
                    ->on(table: UsersCoreTypesModel::TABLE_NAME)
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
                $table->string(column: 'defualt_input_name', length: 50);
                $table->json(column: 'input_names')->nullable();
                $table->json(column: 'validation')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists(table: UsersCoreExtraColumnsModel::TABLE_NAME);
        Schema::enableForeignKeyConstraints();
    }
};
