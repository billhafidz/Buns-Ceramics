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
        'harga_subs'
    ];
}
