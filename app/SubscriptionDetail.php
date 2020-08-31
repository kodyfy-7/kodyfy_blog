<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionDetail extends Model
{
    protected $fillable = ['subscription_id', 'task', 'point', 'post_id', 'who_id', 'who_sub_id'];
}

