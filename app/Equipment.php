<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Equipment extends Model
{
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'model_no', 
        'maker', 
        'max_reservation_time', 
        'price_per_unit_time', 
        'availability',
        'equipment_photo',
    ];
}
