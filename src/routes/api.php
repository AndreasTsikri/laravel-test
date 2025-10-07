
<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlotsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;

//Route::get('/slots', [SlotsController:class,'getAvailableSlots']);
//Route::get('/slots/{tid}',function(string $tid){return "works OK as well with {$tid}!!";} );
//Route::resource('/slots/specialist/{specialistId}/date/{date}',[SlotsController::class,'getAvailableSlots'] );
//Route::get('/specialists/{specialistId}/date/{date}',[SlotsController::class,'index'] );
//Route::get('/slots',function(){return "works OK!!";} );
//Route::get('/slots',[SlotsController::class,'index'] );

//Route::post('/appointments',[AppointmentController::class,'create'];
//Route::delete('/appointments/{appointment}',[AppointmentController::class,'destroy'];

//register user to db and creates a random token
Route::post('/register',[AuthController::class,'register']);

Route::get('/slots',[SlotsController::class,'index'] );

Route::controller(AppointmentController::class)->group(function(){
	Route::post('/appointments/{appointment}','store');
	Route::delete('/appointments/{appointment}','destroy');
});//->middleware("customAuthenticated");
