<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

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
