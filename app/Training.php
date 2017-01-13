<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    //
}
