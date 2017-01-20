<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equipments';
    
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
        'time_unit'
    ];

    public function lab()
    {
        return $this->belongsTo('LabEquipment\Lab');
    }

    public function scopeFindAll($query)
    {
        return $query
            ->orderBy('id', 'desc')
            ->get();
    }

    public function scopeFindOneByIdWithTrashed($query, $id)
    {
        return $query
            ->where('id', $id)
            ->withTrashed()
            ->first();
    }

    public function scopeFindOneById($query, $userId)
    {
        return $query
            ->where('id', $id)
            ->first();
    }
}
