<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
  protected $fillable = [
      'title', 'slug', 'body',
  ];
  public function user()
  {
    return $this->belongsTo('App\Models\User');
  }
}
