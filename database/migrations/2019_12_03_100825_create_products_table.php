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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('pcode')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('phone', 20)->nullable(); // or $table->bigInteger('phone')->nullable();
            $table->string('bkash')->nullable();
            $table->text('long_description')->nullable();
            $table->integer('rprice')->nullable();
            $table->integer('sprice')->nullable();
            $table->integer('appprice')->nullable();
            $table->integer('qty')->nullable();
            $table->string('video')->nullable();
            $table->string('img1')->nullable();
            $table->string('product_video')->nullable();
            $table->date('pdate')->nullable();
            $table->string('status')->nullable();
            $table->integer('sts')->nullable();     
            $table->unsignedBigInteger('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
};
