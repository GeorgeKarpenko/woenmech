<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * STATUS=[
     *  0 => страницы типа новосте
     *  1 => страницы меню и подразделов
     *  2 => сложные страницы подразделов
     *  4 => статьи
     *  4 => аудио
     * ]
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->bigIncrements('id');
            $table->string('name',100);
            $table->string('audio',190)->nullable();
            $table->string('img',190)->nullable();
            $table->string('imgText',190)->nullable();
            $table->string('path',100);
            $table->longText('text')->nullable();
            $table->jsonb('imgLeft')->nullable();
            $table->jsonb('imgRight')->nullable();
            $table->integer('priority')->nullable();
            $table->integer('status');
            $table->bigInteger('page_id')->default(0);
            $table->string('author',190)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE pages ADD FULLTEXT search(name, text)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function($table) {
            $table->dropIndex('search');
        });
        Schema::dropIfExists('pages');
    }
}
