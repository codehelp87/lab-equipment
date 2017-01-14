<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'date_of_training_session',
        'location',
        'booking_id',
     ];
    
    public function user()
    {
        return $this->belongs('LabEquipment\User');
    }
    
    public function booking()
    {
    	return $this->belongsTo('LabEquipment\Booking');
    }
}
