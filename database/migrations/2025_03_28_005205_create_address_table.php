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
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('address_name', 80)->unique();
            $table->string('number', 10);
            $table->string('complement', 50)->nullable();
            $table->string('district', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 40)->countries()->nullable();
            $table->string('cep', 10);
            $table->string('quatrain');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};
