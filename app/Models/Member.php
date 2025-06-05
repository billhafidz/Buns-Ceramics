<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members'; // Specify the table name

    protected $primaryKey = 'id_member'; // Specify the primary key

    protected $fillable = [
        'nama_member',
        'alamat_member',
        'no_telp',
        'email_member',
        'id_account',
        'day',
    ];

    // Define the relationship with the Transaction model

    protected $nullable = ['day'];
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_pelanggan', 'id_member');
    }

    // Define the relationship with the Account model if needed
    public function account()
    {
        return $this->belongsTo(Account::class, 'id_account', 'id_account');
    }
}
