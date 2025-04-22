<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use HasFactory, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['id', 'name', 'image', 'color', 'category', 'is_star'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skills');
    }

    public function experiences()
    {
        return $this->belongsToMany(Experience::class, 'experience_skills');
    }
}
