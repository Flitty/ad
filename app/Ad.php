<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'ads';
    protected $fillable = ['user_id', 'title', 'author_name', 'description'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
