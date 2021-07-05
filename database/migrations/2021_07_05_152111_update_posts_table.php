<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //1 creare colonna per inserire fk
            $table->unsignedBigInteger('category_id')->nullable()->after('id');

            //2 imposto colonna come fk
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                //imposta come nulla la fk nel caso la tabella di collegamento sia eliminata.
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //1 elimina impostazione fk
            $table->dropForeign(['category_id']);

            //2 elimina la colonna che ospitava fk
            $table->dropColumn('category_id');
        });
    }
}
