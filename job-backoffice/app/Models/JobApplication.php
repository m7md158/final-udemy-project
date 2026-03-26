<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\JobVacancy;
use App\Models\User;

class JobApplication extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'job_applications';

    protected $fillable = [
        'status',
        'aiGeneratedScore',
        'aiGeneratedFeedback',
        'jobVacancyId',
        'userId',
        'resumeId',
    ];

    protected $dates = ['deleted_at'];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }
    public function user(){
        return $this->belongsTo(User::class,'userId','id');
    }

    public function jobVacancy(){
        return $this->belongsTo(JobVacancy::class,'jobId','id');
    }

    public function resume(){
        return $this->belongsTo(Resume::class,'resumeId','id');
    }
}
