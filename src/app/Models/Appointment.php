<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentFactory> */
    use HasFactory;
    protected $fillable = ['user_id','specialist_id', 'service_id', 'start_datetime','end_datetime'];
//    public static DateTime $startDateTime = new DateTime('09:00:00');
//    public static DateTime $endDateTime = new DateTime('18:00:00');
//    public static $slots = [];

//    private function createSlots(int $stepInMinutes)
//    {
//	    $dt = self::$startDatetime; 
//	    while($dt <= self::$endDatetime){

//	    $mins = new DateInterval("PT{$stepInMinutes}M")
//	    $dt->add(mins);

//	    }
//    }

//    private function addSlot(DateTime $time, int $stepInMinutes) : DateTime
//    {
//	    $mins = new DateInterval("PT{$stepInMinutes}M")
//	    return $time->add(mins);
//
//    }
    public function specialists() : BelongsTo
    {
	    return $this->belongsTo(Specialist::class);
    }
    public function services() : BelongsTo
    {
	    return $this->belongsTo(Service::class);
    }
    public function users() : BelongsTo
    {
	    return $this->belongsTo(User::class);
    }
}
