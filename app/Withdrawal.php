<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = ['user_id', 'withdrawal_status', 'withdrawal_ticket', 'sub_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function getRouteKeyName()
    {
        return 'withdrawal_ticket';
    }
}
