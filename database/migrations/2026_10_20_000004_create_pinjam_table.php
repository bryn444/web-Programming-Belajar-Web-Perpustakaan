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
        Schema::create('pinjam', function (Blueprint $table) {
            $table->id();
            $table->string('no_pinjam')->unique();
            $table->timestamp('tgl_pinjam');
            $table->string('id_booking');
            $table->foreignId('id_user')->constrained('users');
            $table->decimal('total_denda', 10, 2)->default(0);
            $table->string('id_petugas_pinjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjam');
    }
};
