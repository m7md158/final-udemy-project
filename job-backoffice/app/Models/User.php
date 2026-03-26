<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Resume;
use App\Models\JobApplication;
use App\Models\Company;
class User extends Authenticatable 
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = ['name', 'email', 'password','role'];
    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['deleted_at'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
        ];
    }
    public function resumes(){
        return $this->hasMany(Resume::class,'userId','id');
    }
    public function jobApplications(){
        return $this->hasMany(JobApplication::class,'userId','id');
    }
    public function company(){
        return $this->hasOne(Company::class,'ownerId','id');
    }
}
