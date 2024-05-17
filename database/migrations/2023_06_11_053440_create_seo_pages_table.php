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
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('published_time')->nullable();
            $table->string('modified_time')->nullable();
            $table->string('expiration_time')->nullable();
            $table->string('author')->nullable();
            $table->string('section')->nullable();
            $table->string('canonical')->nullable();
            $table->string('og_locale')->nullable();
            $table->string('og_url')->nullable();
            $table->string('og_type')->nullable();
            $table->string('image')->nullable();
            $table->string('image_url')->nullable();
            $table->string('link_img_size')->nullable();
            $table->string('image_height')->nullable();
            $table->string('image_width')->nullable();
            $table->string('twitter_side')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('seo_pages');
    }
};
