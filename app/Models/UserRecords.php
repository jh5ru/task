<?php

namespace App\Models;

use App\Observers\UserRecordsObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserRecords extends Model
{
    use HasFactory;


    protected $observers = [
        User::class => [UserRecordsObserver::class],
    ];

    public $timestamps = [
        'recording_at'
    ];

    protected $fillable = [
        'recording_at',
        'firstname',
        'lastname',
        'email',
        'user_id',
        'service',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
