<?php

use Bhry98\LaravelUsersCore\Models\{
    UsersCoreSessionsModel,
    UsersCoreUsersModel
};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::create(
            table: UsersCoreSessionsModel::TABLE_NAME,
            callback: function (Blueprint $table) {
                $table->id();
                $table->foreignId(column: 'user_id')
                    ->nullable()
                    ->index()
                    ->references(column: 'id')
                    ->on(table: UsersCoreUsersModel::class)
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
                $table->string(column: 'ip_address', length: 45)->nullable();
                $table->text(column: 'user_agent')->nullable();
                $table->longText(column: 'payload');
                $table->integer(column: 'last_activity')->index();
            });
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists(table: UsersCoreSessionsModel::TABLE_NAME);
        Schema::enableForeignKeyConstraints();
    }
};
