<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

          // Insert some genres
    // Insert some genres
        DB::table('genres')->insert(
            [
                ['name' => 'pop/rock',      'created_at' => now()],
                ['name' => 'punk',          'created_at' => now()],
                ['name' => 'industrial',    'created_at' => now()],
                ['name' => 'hardrock',      'created_at' => now()],
                ['name' => 'new wave',      'created_at' => now()],
                ['name' => 'dance',         'created_at' => now()],
                ['name' => 'reggae',        'created_at' => now()],
                ['name' => 'jazz',          'created_at' => now()],
                ['name' => 'dubstep',       'created_at' => now()],
                ['name' => 'blues',         'created_at' => now()],
                ['name' => 'indie rock',    'created_at' => now()],
                ['name' => 'noise',         'created_at' => now()],
                ['name' => 'electro',       'created_at' => now()],
                ['name' => 'techno',        'created_at' => now()],
                ['name' => 'folk',          'created_at' => now()],
                ['name' => 'hip hop',       'created_at' => now()],
                ['name' => 'soul',          'created_at' => now()],
                ['name' => '_genre1',          'created_at' => now()],
                ['name' => '_genre2',          'created_at' => now()],
                ['name' => '_genre3',          'created_at' => now()],
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
        Schema::dropIfExists('genres');
    }
}
