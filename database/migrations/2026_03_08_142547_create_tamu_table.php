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
        Schema::create('tamu', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tamu')->unique();
            $table->string('nama_tamu');
            $table->string('no_wa');
            $table->enum('status_broadcast', ['pending', 'success', 'failed'])->nullable();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamp('broadcast_at')->nullable();
            $table->text('broadcast_error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tamu');
    }
};
