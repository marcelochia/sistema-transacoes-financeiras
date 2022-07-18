<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('usuarios')->insert([
            'name' => 'Admin',
            'email' => 'admin@email.com.br',
            'password' => password_hash('123999', PASSWORD_BCRYPT),
            'admin' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
