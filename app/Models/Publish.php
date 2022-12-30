<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publish extends Model
{
    use HasFactory;

    protected $fillable = [
        'visibility',
        'resume_id',
        'theme_id',
        'url',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function resume(){
        return $this->belongsTo(Resume::class);
    }

    public function theme(){
            return $this->belongsTo(Theme::class);
        }
}
