<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //

    public function post()
    {
        return $this->belongsTo('App\Post','post_id','id');
    }

    public function job()
    {
        return $this->belongsTo('App\Job','job_id','id');
    }
}


