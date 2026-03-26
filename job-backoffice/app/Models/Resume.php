<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\JobApplication;
class Resume extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'resumes';

    protected $fillable = [
        'fileName',
        'fileUri',
        'contactDetails',
        'summary',
        'skills',
        'experience',
        'education',
        'userId',

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

    public function jobApplications(){
        return $this->hasMany(JobApplication::class,'resumeId','id');
    }
}


