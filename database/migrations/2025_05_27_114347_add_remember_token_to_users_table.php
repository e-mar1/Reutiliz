<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // database/migrations/xxxx_xx_xx_xxxxxx_add_remember_token_to_users_table.php
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->rememberToken()->after('password')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });
    }
};
