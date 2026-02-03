<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessCode extends Model
{
    protected $fillable = ['code', 'status', 'expires_at', 'user_id', 'recruiter_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
