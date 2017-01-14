<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	 use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    //
    protected $fillable = ['title', 'content'];

    public function notifiedUsers()
    {
    	return $this->hasMany('LabEquipment\NotifiedUser');
    }
}
