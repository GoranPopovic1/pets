<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('city')->nullable()->after('provider_id');
            $table->string('phone')->nullable()->after('city');
            $table->unsignedBigInteger('image_id')->nullable()->after('phone');

            $table->foreign('image_id')->references('id')->on('user_images')->onDelete('cascade');
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
            $table->dropForeign('users_image_id_foreign');

            $table->dropColumn('city');
            $table->dropColumn('phone');
            $table->dropColumn('image_id');
        });
    }
}
