<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    //
}
