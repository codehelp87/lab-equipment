<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	 use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    //
}
