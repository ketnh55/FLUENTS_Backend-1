<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SNSInfo extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'statistic';
    protected $hidden = ['_id', 'exception'];
    protected $casts = [
        'social_type' => 'string'
    ];
}
