<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];
    //
    protected $fillable = ['title', 'content'];

    public function notifiedUsers()
    {
    	return $this->hasMany('LabEquipment\NotifiedUser');
    }

    public function scopeFindAll($query)
    {
    	return $query
    	    ->orderBy('id', 'DESC')
    	    ->get();
    }
}
