<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienceSkill extends Model
{
    use HasFactory, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['skill_id', 'experience_id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
}
