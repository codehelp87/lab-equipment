<?php

namespace LabEquipment;

use LabEquipment\Notifications\MyOwnResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthContract;

class User extends Authenticatable implements AuthContract
{
    use Notifiable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'student_id',
        'office_location',
        'phone',
        'status',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyOwnResetPassword($token));
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function bookings()
    {
        return $this->hasMany('LabEquipment\Booking');
    }

    public function trainings()
    {
        return $this->hasMany('LabEquipment\Training');
    }

    public function notifications()
    {
        return $this->hasMany('LabEquipment\NotifiedUser');
    }

    public function role()
    {
        return $this->hasOne('LabEquipment\Role');
    }

    public function labUser()
    {
        return $this->hasMany('LabEquipment\LabUser');
    }

    public function scopeFindOneByEmail($query, $email)
    {
        return $query
            ->where('email', strtolower($email))
            ->first();
    }

    public function scopeFindAllWithTrashed($query)
    {
        return $query
            ->orderBy('id', 'desc')
            ->withTrashed()
            ->get();
    }

    public function scopeFindAll($query)
    {
        return $query
            ->orderBy('id', 'desc')
            ->get();
    }

    public function scopeFindAllAdmin($query)
    {
        return $query
            ->where('role_id', 2)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function scopeFindOneByIdWithTrashed($query, $userId)
    {
        return $query
            ->where('id', $userId)
            ->withTrashed()
            ->first();
    }

    public function scopeFindOneById($query, $userId)
    {
        return $query
            ->where('id', $userId)
            ->first();
    }
}
