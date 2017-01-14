<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotifiedUser extends Model
{
    //
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'status',
        'user_id',
        'notification_id',
    ];

    public function notification()
    {
    	return $this->belongsTo('LabEquipment\Notification');
    }

    public function user()
    {
    	return $this->belongsTo('LabEquipment\User');
    }
}
