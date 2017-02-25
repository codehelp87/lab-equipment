<?php

namespace LabEquipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'equipment_id',
        'time_slot',
        'booking_date',
        'session',
        'time_slot_id',
        'status',
        'timezone_flag',
        'cancelled_time_slot',
        'lab_id',
    ];

    /**
     * Always json_decode time_slot so they are usable
     */
    public function getCancelledTimeslotAttribute($value)
    {
        return json_decode($value);

        // you could always make sure you get an array returned also
        // return json_decode($value, true);
    }

    /**
     * Always json_encode the time_slot when saving to the database
     */
    public function setCancelledTimeslotAttribute($value)
    {
        $this->attributes['cancelled_time_slot'] = json_encode($value);
    }

    /**
     * Always json_decode time_slot so they are usable
     */
    public function getTimeslotAttribute($value)
    {
        return json_decode($value);

        // you could always make sure you get an array returned also
        // return json_decode($value, true);
    }

    /**
     * Always json_encode the time_slot when saving to the database
     */
    public function setTimeslotAttribute($value)
    {
        $this->attributes['time_slot'] = json_encode($value);
    }

    /**
     * Always json_decode time_slot so they are usable
     */
    public function getTimeslotIdAttribute($value)
    {
        return json_decode($value);

        // you could always make sure you get an array returned also
        // return json_decode($value, true);
    }

    /**
     * Always json_encode the time_slot when saving to the database
     */
    public function setTimeslotIdAttribute($value)
    {
        $this->attributes['time_slot_id'] = json_encode($value);
    }
    
    public function user()
    {
    	return $this->belongsTo('LabEquipment\User');
    }

    public function training()
    {
    	return $this->hasOne('LabEquipment\Training');
    }

    public function equipment()
    {
        return $this->belongsTo('LabEquipment\Equipment');
    }

    public function lab()
    {
        return $this->belongsTo('LabEquipment\Lab');
    }

    public function scopeFindBy($query, array $params)
    {
        return $query
            ->where($params)
            ->get();
    }

    public function scopeFindOneByEquipment($query, $id)
    {
        return $query
            ->where('user_id', $id)
            ->where('status', 1)
            ->where('time_slot_id', '!=', NULL)
            ->orderBy('id', 'DESC')
            ->distinct()
            ->get();
    }

    public function scopeFindOneByEquipmentUser($query, $id, $labId)
    {
        return $query
            ->where('equipment_id', $id)
            ->where('lab_id', $labId)
            ->where('status', '>=', 1)
            ->orderBy('id', 'DESC')
            ->distinct()
            ->get();
    }

    public function scopeFindOneByUserAndEquipment($query, $id, $userId)
    {
        return $query
            ->where('equipment_id', $id)
            ->where('user_id', $userId)
            ->where('status', 1)
            ->get();
    }

    public function scopeFindTotalLabUsage($query, $id, $userId)
    {
        return $query
            ->orderBy('id', 'DESC')
            ->where('equipment_id', $id)
            ->where('user_id', $userId)
            ->where('cancelled_time_slot', '!=', NULL)
            ->where('status','>=', 1)
            ->get();
    }

    public function scopeFindOneById($query, $id)
    {
        return $query
            ->where('id', $id)
            ->first();
    }

    public function scopeFindOneByStudent($query, $userId)
    {
        return $query
            ->where('user_id', $userId)
            ->first();
    }

    public function scopeFindUserLab($query, $userId)
    {
        return $query->where('user_id', $userId)
            ->where('time_slot_id', '=', NULL)
            ->where('status', 1)
            ->first();
    }
}
