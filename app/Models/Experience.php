<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experience extends Model
{
    use HasFactory, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name', 'image', 'company', 'location', 'location_type',
        'month_start', 'month_end', 'year_start', 'year_end', 'description',
        'position', 'employment_type', 'is_star', 'experience_category_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function experienceCategory()
    {
        return $this->belongsTo(ExperienceCategory::class, 'experience_category_id');
    }

    public function awards()
    {
        return $this->hasMany(Award::class, 'experiences_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'experience_skills');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
