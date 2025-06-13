<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langganan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_langganan';

    protected $fillable = [
        'pilihan_subs',
        'penjelasan_subs',
        'benefit_subs',
        'harga_subs',
        'gambar_subs',
        'status'
    ];

    protected $casts = [
        'benefit_subs' => 'array',
    ];

    // Accessor untuk URL gambar lengkap
    public function getGambarSubsUrlAttribute()
    {
        return $this->gambar_subs 
            ? asset('storage/langganan_images/'.$this->gambar_subs)
            : null;
    }
}
