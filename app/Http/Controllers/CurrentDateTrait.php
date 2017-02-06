<?php

namespace LabEquipment\Http\Controllers;

use Carbon\Carbon;
use DateTimeZone;

trait CurrentDateTrait
{
	public function getNow() 
	{
		return Carbon::now(new DateTimeZone('Africa/Lagos'));
	    //return Carbon::now(new DateTimeZone('Asia/Seoul'));
	}
}