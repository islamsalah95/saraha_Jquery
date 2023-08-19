<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReplayController;
use App\Http\Controllers\MessageController;


Route::middleware('guest')->group(function () {
    Route::get('/message/create/{user}', [MessageController::class, 'create'])->name('message.create');
    Route::post('/message/store', [MessageController::class, 'store'])->name('message.store');

});




Route::middleware('auth')->group(function () {
    Route::resource('message', MessageController::class)->except(['create','store','destroy']); 
    Route::delete('/message/destroy/{message}', [MessageController::class, 'destroy'])->name('message.destroy');

    Route::resource('replays', ReplayController::class);





//HTTP          URI	                           Action	Route_Name
// GET	        /resource	                   index	resource.index
// GET	        /resource/create	           create	resource.create
// POST	        /resource	                   store	resource.store
// GET	        /resource/{resource}           show 	resource.show
// GET	        /resource/{resource}/edit	   edit	    resource.edit
// PUT/PATCH	/resource/{resource}           update	resource.update
// DELETE	    /resource/{resource}	       destroy	resource.destroy



  
});
