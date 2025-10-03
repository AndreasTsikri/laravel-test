
<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlotsController;

//Route::get('/slots', [SlotsController:class,'getAvailableSlots']);
//Route::get('/slots/{tid}',function(string $tid){return "works OK as well with {$tid}!!";} );
//Route::resource('/slots/specialist/{specialistId}/date/{date}',[SlotsController::class,'getAvailableSlots'] );
//Route::get('/specialists/{specialistId}/date/{date}',[SlotsController::class,'index'] );
//Route::get('/slots',function(){return "works OK!!";} );
Route::get('/slots',[SlotsController::class,'index'] );
