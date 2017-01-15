<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
	use SoftDeletes;

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
        'lab_id',
    ];

    public function lab()
    {
        return $this->belongsTo('LabEquipment\Lab');
    }
}
