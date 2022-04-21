<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\Api\BorrowerapiController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::get('students', 'ApiController@getAllStudents');
//Route::get('students/{id}', 'ApiController@getStudent');
//Route::get('borrower', 'BorrowerapiController@addBorrower');
//Route::put('students/{id}', 'ApiController@updateStudent');
//Route::delete('students/{id}','ApiController@deleteStudent');
//Route::post("borrower",[BorrowerapiController::class, "addBorrower"]);
//Route::get("borrower",[BorrowerapiController::class, "addBorrower"]);
//
//Route::group([
//    'middleware' => 'api',
//    'prefix' => 'auth'
//
//], function ($router) {
//    Route::post('/login', [AuthController::class, 'login']);
//    Route::post('/register', [AuthController::class, 'register']);
//    Route::post('/logout', [AuthController::class, 'logout']);
//    Route::post('/refresh', [AuthController::class, 'refresh']);
//    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
//});
//Route::prefix("v1")->group(function(){
//    Route::post('/login',[AuthController::class,'login']);
//});
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
});
Route::middleware('auth:api')->group( function () {
    //Route::get('/products', [ProductController::class,'index']);
    //Route::resource('products', ProductController::class);
    Route::post("borrower",[BorrowerapiController::class, "addBorrower"]);
});