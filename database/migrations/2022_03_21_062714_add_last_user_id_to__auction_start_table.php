<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastUserIdToAuctionStartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auction_starts', function (Blueprint $table) {
            $table->integer('last_user_id')->nullable()->after('auction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auction_starts', function (Blueprint $table) {
            $table->dropColumn('last_user_id');
        });
    }
}
