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
        Schema::create('pinjam_detail', function (Blueprint $table) {
            $table->id();
            $table->string('no_pinjam');
            $table->foreign('no_pinjam')->references('no_pinjam')->on('pinjam');
            $table->foreignId('id_buku')->constrained('buku');
            $table->timestamp('tgl_kembali')->nullable();
            $table->timestamp('tgl_pengembalian')->nullable();
            $table->enum('status', ['Pinjam', 'Kembali']);
            $table->decimal('denda', 10, 2);
            $table->integer('lama_pinjam');
            $table->string('id_petugas_kembali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjam_detail');
    }
};
