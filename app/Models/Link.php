<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'title',
    'url',
  ];

  public static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->link_id = "abc";
    });
  }
}
