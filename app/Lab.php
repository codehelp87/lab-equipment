<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Lab extends Model
{
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'model_no']; 
}
