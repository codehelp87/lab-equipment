<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    //
}
