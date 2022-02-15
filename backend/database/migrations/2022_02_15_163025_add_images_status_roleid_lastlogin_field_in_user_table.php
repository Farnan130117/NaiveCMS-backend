<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('image')->nullable()->after('password');
            $table->enum('status', array('active', 'freeze'))->nullable()->after('image');
            $table->string('role_id')->nullable()->after('status');
            $table->dateTime('last_login')->nullable()->after('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('image');
            $table->dropColumn('status');
            $table->dropColumn('role_id');
            $table->dropColumn('last_login');
        });
    }
};
