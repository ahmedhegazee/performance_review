<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'uuid',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_admin',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['role'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
    /**
     * Returns the role of user.
     * @return string.
     */
    public function getRoleAttribute()
    {
        return $this->attributes['is_admin'] ? 'admin' : 'employee';
    }
    public function scopeFilter(Builder $query, $request)
    {
        return $query->when($request->has('email'), function ($query) use ($request) {
            $query->where('email', $request->email);
        })
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where('name', 'like', "%$request->name%");
            })
            ->when($request->has('is_admin'), function ($query) use ($request) {
                $query->where('is_admin', $request->is_admin);
            });
    }
    /**
     *
     *  review requests relation
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviewRequests()
    {
        return $this->belongsToMany(User::class, 'review_requests', 'reviewer_id', 'reviewed_id')
            ->withTimestamps()
            ->withPivot([
                'id',
                'is_done',
                'created_by',
            ])
            ->using(ReviewRequest::class);
    }

    public function feedbacks()
    {
        return $this->hasManyThrough(ReviewFeedback::class, ReviewRequest::class, 'reviewed_id', 'review_request_id');
    }
}