<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'reward_aed', 'instagram_url', 'type', 'is_active'];

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }
}
