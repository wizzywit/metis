<?php

namespace App;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\doctorPasswordResetNotification;

class Doctor extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = 'doctor';

    protected $fillable = [
        'name', 'email', 'patient_id', 'speciality', 'qualification', 'phone', 'passport', 'password', 'hospital','sex','verified'
    ];

    public function patients()
    {
        return $this->hasMany('App\Patient','patient_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token){
        $this->notify(new doctorPasswordResetNotification($token));
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
