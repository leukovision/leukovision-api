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
            Schema::create('analysis_histories', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->bigIncrements('history_id');
                $table->unsignedBigInteger('patient_id');
                $table->foreign('patient_id')
                      ->references('patient_id')
                      ->on('patients') 
                      ->onDelete('cascade');
                $table->string('diagnosis');
                $table->string('tingkat_keyakinan');
                $table->integer('jumlah_sel');
                $table->integer('sel_abnormal');
                $table->string('rata_rata_keyakinan');
                $table->text('rekomendasi_medis');
                $table->timestamp('timestamp');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analysis_histories');
    }
};
