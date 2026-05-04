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
        Schema::create('contacts', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('name', 150)->index();
            $table->string('email_address', 150)->index();
            $table->string('contact', 50)->index();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['email_address', 'deleted_at']);
            $table->unique(['contact', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
