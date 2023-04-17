<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('c_id')->unsigned();
            $table->string('name');
            $table->string('description');
            $table->double('price');
            $table->double('sale_price');
            $table->integer('qty');
            $table->double('discount')->default(0.0);
            $table->string('image1');
            $table->string('image2');
            $table->string('image3');
            $table->foreign('c_id')->references('id')->on('category')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
