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
        Schema::create('pet_posts', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer('coordinate_x');
            $table->integer('coordinate_y');
            $table->string('breed');
            $table->string('type');
            $table->text('additional_info')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets_posts');
    }
};
