<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'priority', 'deadline', 'status', 'user_id'];

    public function user()
    {
        dd($this->user_id);
        return $this->belongsTo(User::class);
    }
}
