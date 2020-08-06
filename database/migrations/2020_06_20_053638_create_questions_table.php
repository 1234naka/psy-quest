<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Questions', function (Blueprint $table) {
            $table->id();
            $table->string('Question');
            $table->unsignedBigInteger('SubCategory_id');
            $table->timestamps();
            $table->foreign('SubCategory_id')
                ->references('id')
                ->on('SubCategories')
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
        Schema::dropIfExists('Questions');
    }
}
