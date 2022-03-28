<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfileSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_setting_id');
            $table->tinyInteger('name')->default(0);
            $table->tinyInteger('auction_played')->default(0);
            $table->tinyInteger('auction_won')->default(0);
            $table->tinyInteger('items_liked')->default(0);
            $table->tinyInteger('items_won')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profile_settings');
    }
}
