<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    protected $fillable = [
         'patient_id', 'doctor_id', 'price', 'date', 'start_time', 'end_time', 'symptoms','urgency_level','payed','scheduled','room_name'
    ];

    public function doctor() {
        return $this->belongsTo('App\Doctor','doctor_id');
    }

    public function patient() {
        return $this->belongsTo('App\Patient','patient_id');
    }
}
