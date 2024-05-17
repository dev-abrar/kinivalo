<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_page_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('hotdeals')->nullable();
            $table->string('section_name_1')->nullable();
            $table->bigInteger('section_ctg_1')->nullable();
            $table->boolean('section_1')->nullable();
            $table->string('section_name_2')->nullable();
            $table->bigInteger('section_ctg_2')->nullable();
            $table->boolean('section_2')->nullable();
            $table->string('section_name_3')->nullable();
            $table->bigInteger('section_ctg_3')->nullable();
            $table->boolean('section_3')->nullable();
            $table->string('section_name_4')->nullable();
            $table->bigInteger('section_ctg_4')->nullable();
            $table->boolean('section_4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_page_sections');
    }
};
