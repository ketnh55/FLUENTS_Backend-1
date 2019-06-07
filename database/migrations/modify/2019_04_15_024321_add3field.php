<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add3field extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('interest', function (Blueprint $table) {
            $table->dateTime('created_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        Schema::table('user_interest', function (Blueprint $table) {
            $table->dateTime('created_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('user_interest', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('removed_at');
            $table->dropColumn('updated_at');
        });

        Schema::table('interest', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('removed_at');
            $table->dropColumn('updated_at');
        });
    }
}
