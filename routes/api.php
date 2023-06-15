<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\EntryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/forgotpassword',[AuthController::class,'ForgotPassword']); 
Route::post('/resetpassword',[AuthController::class,'ResetPassword']); 




Route::group(['middleware' => ['auth:sanctum']], function(){
    
    Route::post('/update',[AuthController::class,'update']);
    Route::post('/logout',[AuthController::class,'logout']);

    
    Route::get('/fetch_all_contest',[ContestController::class,'index']);
    Route::get('/fetch_all_live_contest',[ContestController::class,'fetchLiveContest']);

    Route::get('/fetch_participants',[ParticipantController::class,'getParticipantsByContestId']);
    Route::get('/fetch_entries',[EntryController::class,'getEntiresByContestId']);
        
    Route::post('/create',[ContestController::class,'createBasic']);
    Route::post('/create_entry',[ContestController::class,'createEntry']);
    Route::post('/create_details',[ContestController::class,'createDetails']);
    Route::post('/create_selection',[ContestController::class,'createSelection']);
    Route::post('/create_prizes',[ContestController::class,'createPrizes']);

    Route::get('/fetch_all_my_live_contest',[ContestController::class,'fetchLiveContestByUserId']);
    Route::get('/number_of_my_live_contest',[ContestController::class,'countLiveContestByUserId']);
    Route::get('/search/{name}',[ContestController::class,'search']);
    Route::get('/fetch_my_contest',[ContestController::class,'fetchContestById']);
    Route::post('/update_contest',[ContestController::class,'update']);


});
