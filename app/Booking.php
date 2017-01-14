<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Booking extends Model
{
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    //
    protected $fillable = [
        'session',
        'user_id',
        'lab_id',
        'equipment_id',
    ];
    
    public function user()
    {
    	return $this->belongs('LabEquipment\User');
    }

    public function training()
    {
    	return $this->hasOne('LabEquipment\Training');
    }
}
