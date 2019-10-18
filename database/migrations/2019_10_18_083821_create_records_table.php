<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('genre_id');    // use SAME SIZE as id: unsignedInteger() creates an error!
            $table->string('artist');
            $table->string('artist_mbid', 36)->nullable();
            $table->string('title');
            $table->string('title_mbid', 36)->nullable();
            $table->string('cover')->nullable();
            $table->float('price', 5, 2)->default(19.99);
            $table->unsignedInteger('stock')->default(1);
            $table->timestamps();

            // Foreign key relation
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade')->onUpdate('cascade');
            });

            // Insert some records
            DB::table('records')->insert(
                [
                    [
                        'genre_id' => 1,
                        'created_at' => now(),
                        'stock' => 1,
                        'artist' => 'Queen',
                        'artist_mbid' => '0383dadf-2a4e-4d10-a46a-e9e041da8eb3',
                        'title' => 'Greatest Hits',
                        'title_mbid' => 'fcb78d0d-8067-4b93-ae58-1e4347e20216',
                        'cover' => null
                    ],

                ]
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
