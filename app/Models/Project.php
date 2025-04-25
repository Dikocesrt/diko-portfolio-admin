<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'image', 'description', 'date', 'type', 'is_star', 'experience_id', 'project_category_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }

    public function documentations()
    {
        return $this->hasMany(Documentation::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'project_skills');
    }
}
