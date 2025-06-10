<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table      = 'transactions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_kelas',
        'total_transaksi',
        'id_pelanggan',
        'tanggal_transaksi',
        'order_id',
        'payment_method',
        'ended_date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_pelanggan', 'id_member');
    }

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'ended_date'        => 'datetime',
    ];

    public $timestamps = true;
}
