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
        Schema::create('basics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('contact_no');
            $table->string('phone');
            $table->string('bkas');
            $table->string('logo');
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->text('footer_details')->nullable();
            $table->string('delivery_cost1');
            $table->string('delivery_cost2');
            $table->longText('inside_details')->nullable();
            $table->longText('outside_details')->nullable();
            $table->longText('header_code')->nullable();
            $table->longText('footer_code')->nullable();
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
        Schema::dropIfExists('basics');
    }
};
