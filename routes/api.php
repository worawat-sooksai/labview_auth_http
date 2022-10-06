<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/example',function (Request $request){
    return json_encode(user::select('name','email','updated_at')->orderBy('updated_at','desc')->get());
})
->middleware('auth:sanctum')
;
Route::post('/processToken',function(Request $request){   
    
    if(Auth::attempt(['email' => $request->email, 'password' =>  $request->password])){ 
        $user = Auth::user();
        $token = $user->createToken('labview_token')->plainTextToken;            
       

        return json_encode(['token' => $token,'user' => ['name' => Auth::user()->name,'id' => "".Auth::user()->id]]);
    } 
    else{ 
        return json_encode(['token' => "null",'user' => ['name' => "null",'id' => "null"]]);
    }    

});
