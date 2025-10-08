<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Specialist;
use App\Services\SlotsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
class AppointmentController extends Controller
{
	//protected AppointmentService $apService;
	//public function __construct(AppointmentService $as){
	//	$this->apService = $as;
	//}
	//protected SlotsService $slotsService;
	//public function __construct(SlotsService $ss){
	//	$this->slotsService = $ss;
	//}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
	    $user = $request->user();
	    $appoints = Appointment::where('user_id',$user->id)
		    ->with(['specialist','service'])
		    ->orderBy('start_datetime','desc')
		    ->get();
	    return response()->json(['appointments'=>$appoints]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,SlotsService $slotsService)
    {
        $user = $request->user();
        $validated = $request->validate([
            'specialist_id' => 'required|integer|exists:specialists,id',
            'service_id' => 'required|integer|exists:services,id',
            'start_datetime' => 'required|date|date_format:Y-m-d H:i:s|after:now'
            //'client_phone' => 'nullable|string|max:20',
            //'notes' => 'nullable|string|max:500',
	]);
	$service = Service::find($validated['service_id']);

        $slots = $slotsService->getAvailableSlots(
            $validated['specialist_id'],
            $validated['start_datetime'],
	    $service->duration,
	    true  
	);

	$st = Carbon::parse($validated['start_datetime']);
	if(!in_array($st->toTimeString('minute'),$slots)){
		$strSlots = json_encode($slots);
		return response()-> json([
		'message' => "this slot is not in the availables!",
		'available slots' => $strSlots,
		'service duration' => $service->duration,
		],422);
	}
	$et = $st->copy()->addMinutes($service->duration);

        // Create appointment
        $appointment = Appointment::create([
            'user_id' => $user->id,
            'specialist_id' => $validated['specialist_id'],
            'service_id' => $validated['service_id'],
            'start_datetime' => $validated['start_datetime'],
            'end_datetime' => $et->format('Y-m-d H:i:s'),
            //'client_name' => $user->username,
            //'client_email' => $user->email,
            //'client_phone' => $validated['client_phone'] ?? null,
            //'notes' => $validated['notes'] ?? null,
            //'status' => 'confirmed',
        ]);

        // Clear cache
        //$this->slotService->clearCache($validated['specialist_id'], $date);

        // Load relationships
        //$appointment->load(['specialist', 'service']);

        return response()->json([
            'message' => 'Appointment booked successfully',
            'appointment' => $appointment,]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $validated = $request->validate([
		'appointment_id' => 'required|integer|exists:appoimtments,id'];
	$app = Appointment::find(validated['appointment_id'];
	if($app == null){

		return json(
			['message'=> 'Appointment does not exist, please specify correct appointment_id'],404
		);
	}
	if($app->user_id !== $req->user->id){
		return response()->json([
                'message' => 'Unauthorized. You can only cancel your own appointments.'
            ], 403);
	}
	// Store details for cache clearing
       // $specialistId = $appointmentModel->specialist_id;
       // $date = $appointmentStart->format('Y-m-d');

	$app->delete();
	//clear cache
	//this->slotService->clearCache($specialistId,$date);
	return response()->json([
		'message'=> 'Appointment cancelled successfully!'
	],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req)
    {
        //
    }
}
