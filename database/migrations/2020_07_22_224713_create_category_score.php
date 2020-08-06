<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Category_score', function (Blueprint $table) {
            $table->id();
            $table->float('Category_score', 2, 1);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('Category_id');
            $table->timestamps();
            $table->foreign('Category_id')
                ->references('id')
                ->on('Categories')
                ->onDelete('cascade');
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
        }); 

        Schema::create('SubCategory_score', function (Blueprint $table) {
            $table->id();
            $table->float('SubCategory_score', 2, 1);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('SubCategory_id');
            $table->timestamps();
            $table->foreign('SubCategory_id')
                ->references('id')
                ->on('SubCategories')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('Category_score');
        Schema::dropIfExists('SubCategory_score');
    }
}
