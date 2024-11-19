<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hidehalo\Nanoid\Client;

class AnalysisHistory extends Model
{
    use HasFactory;

    protected $primaryKey = 'history_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'patient_id',
        'diagnosis',
        'tingkat_keyakinan',
        'jumlah_sel',
        'sel_abnormal',
        'rata_rata_keyakinan',
        'rekomendasi_medis',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate ID otomatis dengan awalan ah_
        static::creating(function ($analysisHistory) {
            $client = new Client();
            $nanoid = $client->generateId(size: 12);
            $analysisHistory->history_id = 'ah_' . $nanoid;
        });
    }

    /**
     * Relasi ke model Patient.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }
}
