<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnReference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Categories', function (Blueprint $table) {
            $table->string('reference')->after('explain');
            $table->string('result_explain')->after('reference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Categories', function (Blueprint $table) {
            $table->dropColumn('reference');
            $table->dropColumn('result_explain');
        });
    }
}
