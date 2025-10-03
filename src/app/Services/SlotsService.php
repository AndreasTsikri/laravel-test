<?php
namespace App\Services;

use App\Models\Specialist;
use App\Models\Appointment;
use Carbon\Carbon;
class SlotsService{
	//protected $specialistId;
	//public __construct($specialistId){
	//	$this->$specialistId = $specialistId;
	//}

	public function getAvailableSlots($specialistId,$date,$slotsDuration) : ?array{

		if(!Specialist::where('id',$specialistId)->exists())
			return null;
		return $this->getAvSlots($specialistId,$date,$slotsDuration);
}

	public function getAvSlots($specialistId,$date,$serviceDuration) : array
	{
		//define local functions
		$areOverlap = function ($start1,$end1,$start2,$end2){
			if($end2 < $start1) return false;
			if($start2 > $end1) return false;
			if($start2 <= $end1 && $start2 >= $start1)
				return true;
		};
		//Get Specialist working hours
		$startWorkDt = Carbon::parse($date . '09:00:00');
		$endWorkDt   = Carbon::parse($date . '18:00:00');
		//Get Specialist appointments
		$appointments = Appointment::where('specialist_id',$specialistId)
			//->whereDate('start_datetime',$date)
			->orderBy('start_datetime')
			->get();
		//Start searching all slots in a pace of 5 mins
		//So next_dt = prev_dt + 5 mins_dt for all times until next_dt > end_working_dt
		//check if (next_dt + serviceDuration) overlaps with appointment, if not insert it to the availableSlots array! 
		$slot = $startWorkDt->copy();
		$endSlot = $startWorkDt->copy()->addMinutes($serviceDuration);
		$availableSlots = [];
		while($endSlot <= $endWorkDt)
		{
			$isAvailable = true;
			foreach($appointments as $ap)
				$isAvailable = !$areOverlap($slot,$endSlot,$ap->start_datetime,$ap->end_datetime);

			if($isAvailable)
				$availableSlots[] = $slot->format('H:i');

			$slot->addMinutes($serviceDuration);
			$endSlot->addMinutes($serviceDuration);
		}
		return $availableSlots;
	}

}
