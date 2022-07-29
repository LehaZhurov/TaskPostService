<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Posts\Models\Post;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voices', function (Blueprint $table) {
            $table->id();
            $table->integer('voices');
            $table->foreignIdFor(Post::class);//
            $table->integer('user_id');
            $table->timestampsTz();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('voices');
    }
};
