<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected static function booted()
    {
        static::addGlobalScope('isAdmin', function (Builder $builder) {
            $builder->where('is_admin', 1);
        });
    }
}
