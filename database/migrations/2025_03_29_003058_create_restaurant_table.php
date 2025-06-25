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
        Schema::create('restaurant', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->unique();
            $table->string('perfil_img',100)->nullable();
            $table->string('capa_img',0)->nullable();
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->string('phone', 25)->unique();
            $table->string('email',80)->unique();
            $table->boolean('active')->default(true);
            $table->foreignId('address_id')->constrained('address');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant');
    }
};
