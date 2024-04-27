<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hidehalo\Nanoid\Client as Nanoid;

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
      $nanoid = new Nanoid();
      $model->link_id = $nanoid->formattedId($alphabet = '0123456789ABCDEFGHJKMNPQRSTVWXYZ', $size = 10);
    });
  }
}
