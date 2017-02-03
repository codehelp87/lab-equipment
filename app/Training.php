<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'date_of_training_session',
        'location',
        'user_id',
        'equipment_id',
        'status',
     ];
    
    public function user()
    {
        return $this->belongsTo('LabEquipment\User');
    }

    public function equipment()
    {
        return $this->belongsTo('LabEquipment\Equipment');
    }

    public function scopeGetTrainedEquipments($query, $userId)
    {
        return $query
            ->orderBy('id', 'DESC')
            ->where('user_id', $userId)
            ->get();
    }

}
