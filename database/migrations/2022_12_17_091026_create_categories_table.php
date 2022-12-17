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
        Schema::create('categories', function (Blueprint $table) {
            // `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY
            $table->id();
            // `name` VARCHAR(255) NOT NULL
            $table->string('name', 255);
            // `image_path` VARCHAR(255) NULL
            $table->string('image_path')->nullable();
            // `parent_id` BIGINT UNSIGNED NULL
            $table->unsignedBigInteger('parent_id')->nullable();
            // `slug` VARCHAR(255) NOT NULL + UNIQUE
            $table->string('slug')->unique();
            // `created_at` TIMESTAMP NULL
            // `updated_at` TIMESTAMP NULL
            $table->timestamps();

            // Define Foreign Key for "parent_id"
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('categories')
                  ->nullOnDelete(); // set null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
