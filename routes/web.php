<?php

//$perms = \App\Models\Permission::with('roles')->get();
//foreach ($perms as $perm) {
//    echo $perm->name  .": ". '<br>';
//    echo '<pre>';
//    foreach ($perm->roles as $role) {
//        echo '                 ' . $role->name  ."". '<br>';
//    }
//    echo '</pre>';
//    echo '<br>';
//}
//dd();

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
	return redirect('/login');
});
Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');

