<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hidehalo\Nanoid\Client;

class Patient extends Model
{
    use HasFactory;

    protected $primaryKey = 'patient_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'age',
        'gender',
        'address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate ID otomatis dengan awalan pt_
        static::creating(function ($patient) {
            $client = new Client();
            $nanoid = $client->generateId(size: 12);
            $patient->patient_id = 'pt_' . $nanoid;
        });
    }
}
