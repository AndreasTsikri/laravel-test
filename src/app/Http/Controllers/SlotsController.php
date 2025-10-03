<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\SlotsService;

class SlotsController extends Controller
{
	protected $slotsService;
	public function __construct( SlotsService $sService)
	{
		$this->slotsService = $sService;
	}
	
//	public function getAvailableSlots($specialistId,/*$serviceId*/) : JsonResponse
	//public function index(Request $request) : JsonResponse
	public function index(Request $request) : JsonResponse
	{
		$validated = $request->validate(
			[
				'specialistId'=> 'required|string|exists:specialists,id',
				//'service_id'=>'required|integer|exists:specialists,id',
				'date'=>'nullable|date|date_format:Y-m-d'
			]);


//		$avSlots = $slotsService->getAvailableSlots($specialistId,'1/10/2025',5);
		$avSlots = $this->slotsService->getAvailableSlots(
			$validated['specialistId'],
			$validated['date'] ?? "2025-10-10",
			5);
		$resp = $avSlots == null ? 
			response()->json([
				'message'=> "Specialist does not eist"],404): response()->json([
			'message'=> 'Booked OK!',
			'av slots' => $avSlots
				],201);
		return $resp;
	}
}
