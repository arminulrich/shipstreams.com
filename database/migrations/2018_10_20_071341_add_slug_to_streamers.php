<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugToStreamers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('streamers', function (Blueprint $table) {
            $table->string('slug')->nullable();
        });

        foreach (\App\Models\Streamer::all() as $streamer) {
            $streamer->slug = $streamer->twitch_username;
            $streamer->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('streamers', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
