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
        Schema::create('email_otp', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('otp');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<< HEAD
        //
=======
>>>>>>> ad9be8370c217a710a1493ea79b6f74d2742d600
        Schema::dropIfExists('email_otp');
    }
};
