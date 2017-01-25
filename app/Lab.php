<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lab extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'model_no',
    ];

    public function labUser()
    {
    	return $this->belongsTo('LabEquipment\LabUser');
    }

    public function equipments()
    {
    	return $this->hasMany('LabEquipment\Equipment');
    }

    public function scopeFindAll($query)
    {
        return $query
            ->orderBy('id', 'desc')
            ->get();
    }

    public function scopeFindOneById($query, $id)
    {
        return $query
            ->where('id', $id)
            ->first();
    }
}