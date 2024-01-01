<?php


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\AppController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\EmbedController;
use App\Http\Controllers\FlowController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MixController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SchemaController;
use App\Http\Controllers\SchemaFieldController;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\SimpleController;
use App\Http\Controllers\UserController;

use App\Models\Flow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Flow::routes();

Route::prefix('@')->group(function(){
    Flow::routes('app');
});


Route::get('/', function () {
    return view('welcome');
});



Route::prefix('_x')->name('x.')->group(function () {
    if (!Storage::exists(public_path('/assets')))   Artisan::call('storage:link');
    if (!Schema::hasTable('migrations')) {
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
    Route::get('medi/{medi}/open', [MediaController::class, 'open'])->name('medi.open');
    Auth::routes(['register' => false]);
  
   
    Route::middleware(['auth', 'auth.root'])->group(function () {
        //Workplace
        Route::get('/', function(){
            return redirect(route('x.app.index'));
            //return view('x.wp.index');
        })->name('wp');

        //////
        Route::resource('embed', EmbedController::class);

        Route::get('app/fetch',[ AppController::class,'fetch'])->name('app.fetch');
        Route::resource('app', AppController::class);

        Route::get('flow/fetch',[ FlowController::class,'fetch'])->name('flow.fetch');
        Route::get('api',[ FlowController::class,'api'])->name('flow.api');    
        Route::resource('flow', FlowController::class);

        Route::get('command/fetch',[ CommandController::class,'fetch'])->name('command.fetch');
        Route::get('ui',[ CommandController::class,'ui'])->name('command.ui');    
        Route::resource('command', CommandController::class);
        
        Route::get('schema/fetch',[ SchemaController::class,'fetch'])->name('schema.fetch');
        Route::resource('schema', SchemaController::class);
        Route::resource('schema.field', SchemaFieldController::class)->shallow();
        Route::resource('schema.mix', MixController::class);
        
        //Unit
        Route::get('simple/fetch',[ SimpleController::class,'fetch'])->name('simple.fetch');
        Route::get('media',[ SimpleController::class,'media'])->name('simple.media');
        Route::get('content',[ SimpleController::class,'content'])->name('simple.content');
        Route::resource('simple', SimpleController::class);
       
        Route::resource('medi', MediaController::class)->only('show','edit','update');
        Route::resource('content', ContentController::class)->only('edit','update');
        Route::post('content/{content}/addmedia', [ContentController::class, 'addMedia'])->name('content.addmedia');
        Route::resource('embed', EmbedController::class)->only('show','edit','update');

        //Authenticate
        Route::get('user/fetch',[ UserController::class,'fetch'])->name('user.fetch');
        Route::resource('user', UserController::class);
        Route::get('role/fetch',[ RoleController::class,'fetch'])->name('role.fetch');
        Route::resource('role', RoleController::class);
        
    });
});
