<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LogicException;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'author'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d.m.Y',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['participants:id,firstname,lastname,username'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'pivot'
    ];

    public function participants()
    {
        return $this->belongsToMany(User::class);
    }

    public function hasParticipant(int $userId) {
        return $this->participants()
                    ->where('user_id', $userId)
                    ->exists();
    }

    public function register(int $userId) {
        if($this->hasParticipant($userId)) {
            throw new LogicException("The user has already been registered.");
        }

        return $this->participants()->attach($userId);
    }

    public function remove(int $userId) {
        if(!$this->hasParticipant($userId)) {
            throw new LogicException("The user has not been registered.");
        }

        return $this->participants()->detach($userId);
    }
}
