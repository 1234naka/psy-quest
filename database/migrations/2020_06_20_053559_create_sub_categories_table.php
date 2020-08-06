<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SubCategories', function (Blueprint $table) {
            $table->id();
            $table->string('SubCategory');
            $table->unsignedBigInteger('Category_id');
            $table->timestamps();
            $table->foreign('Category_id')
                ->references('id')
                ->on('Categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SubCategories');
    }
}
