<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'account';
    protected $primaryKey = 'id_account';

    protected $fillable = [
        'username', 'email', 'password', 'role'
    ];

    
    public function member()
    {
        return $this->hasOne(Member::class, 'id_account', 'id_account');
    }
}
