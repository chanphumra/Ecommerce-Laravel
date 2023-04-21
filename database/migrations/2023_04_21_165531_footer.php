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
        Schema::create('footer', function (Blueprint $table){
            $table->id();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('text1')->nullable();
            $table->string('text2')->nullable();
            $table->string('text3')->nullable();
            $table->string('text4')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer');
    }
};
