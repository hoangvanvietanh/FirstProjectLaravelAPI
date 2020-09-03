<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('register', 'API\RegisterController@register');
Route::post('login', 'API\RegisterController@login');

Route::middleware('auth:api')->group( function () {
    Route::get('users', 'API\UsersController@user_login');
    Route::post('userupdate/{id}', 'API\UsersController@update');
    Route::get('posts', 'API\PostsController@list_posts');
    Route::post('createpost', 'API\PostsController@store');
    Route::delete('deletepost/{id}', 'API\PostsController@destroy');
    Route::get('roles', 'API\PermissionController@role_list');
    Route::post('roles', 'API\PermissionController@role_store');
    Route::get('permissions', 'API\PermissionController@permission_list');
    Route::post('permissions', 'API\PermissionController@permission_store');
    Route::post('rolepermissions/{role}', 'API\PermissionController@role_has_permissions');
    Route::post('assignuserrole/{role}', 'API\PermissionController@assign_user_to_role');
});

//Route::fallback(function(){
//    return response()->json(['message' => 'Not Found.'], 404);
//})->name('api.fallback.404');
