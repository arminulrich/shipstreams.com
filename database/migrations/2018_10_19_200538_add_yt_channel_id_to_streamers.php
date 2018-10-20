<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYtChannelIdToStreamers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('streamers', function (Blueprint $table) {
            $table
                ->string('youtube_channel_id')
                ->nullable()
                ->after('id');
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
            $table->dropColumn('youtube_channel_id');
        });
    }
}
