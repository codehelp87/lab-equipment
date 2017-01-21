<?php

namespace LabEquipment;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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
    ];

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
