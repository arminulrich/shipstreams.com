<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainChannelToStreamers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('streamers', function (Blueprint $table) {
            $table->string('streamer_main_channel')->default('twitch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('streamers', function (Blueprint $table) {
            $table->dropColumn('streamer_main_channel');
        });
    }
}
