<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CalibrationController;
use App\Http\Controllers\FreqCalController;
use App\Http\Controllers\FreqCalMeasuringDeviceController;
use App\Http\Controllers\HistoryCalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LifeTimeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MeasuringDeviceController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\RangeController;
use App\Http\Controllers\ResolutionController;
use App\Http\Controllers\SubTableController;
use App\Http\Controllers\TypeController;
use App\Http\Middleware\userActivityNow;

// Import the middleware
use App\Models\Calibration;
use App\Models\FreqCalMeasuringDevice;
use App\Models\MeasuringDevice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Export\DownloadController;
use App\Http\Controllers\Upload\CalFreq;
use App\Http\Controllers\Upload\SubTableType;
use App\Http\Controllers\Upload\SubTableMerk;
use App\Http\Controllers\Upload\SubTableRange;
use App\Http\Controllers\Upload\SubTableResolution;
use App\Http\Controllers\Upload\SubTableArea;
use App\Http\Controllers\Upload\SubTableCarname;
use App\Http\Controllers\Upload\UploadMeasuringDevice;
use App\Http\Controllers\Upload\UploadControlMeasuringDevice;

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


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth', userActivityNow::class])->group(function () {
    //main page
    Route::get('/', function () {
        return redirect('dashboard');
    });
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('user', 'App\Http\Controllers\UserController', ['names' => 'users']);
    Route::resource('profile', 'App\Http\Controllers\ProfileController', ['names' => 'profile']);
    Route::resource('measuring-device', 'App\Http\Controllers\MeasuringDeviceController', ['names' => 'measuring_devices']);
    Route::resource('frequency', 'App\Http\Controllers\FreqCalMeasuringDeviceController', ['names' => 'freq']);
    Route::resource('sub-table', 'App\Http\Controllers\SubTableController', ['names' => 'sub_table']);
    Route::resource('type', 'App\Http\Controllers\TypeController', ['names' => 'types']);
    Route::resource('merk', 'App\Http\Controllers\MerkController', ['names' => 'merks']);
    Route::resource('range', 'App\Http\Controllers\RangeController', ['names' => 'ranges']);
    Route::resource('resolution', 'App\Http\Controllers\ResolutionController', ['names' => 'resolutions']);
    Route::resource('area', 'App\Http\Controllers\AreaController', ['names' => 'areas']);
    Route::resource('carname', 'App\Http\Controllers\CarnameController', ['names' => 'carnames']);
    Route::get('/getDeviceName/{id}', 'MeasuringDeviceController@getDeviceName');
    Route::resource('calibration', 'App\Http\Controllers\CalibrationController', ['names' => 'calibrations']);
    Route::get('sub-table', [SubTableController::class, 'index'])->name('sub_table.index');
    Route::get('history', [HistoryCalController::class, 'index'])->name('calibration_history.index');

    Route::get('/export/{id}', [HistoryCalController::class, 'export'])->name('export.calibration');


    // Additional routes
    Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
    Route::get('status', [UserController::class, 'userOnlineStatus']);

    Route::get('/print/{id}', [HistoryCalController::class, 'print'])->name('calibration_history.print');

    // download document at dashboard
    Route::post('/calibration/export', [DownloadController::class, 'export'])->name('calibration.export');

    // rute untuk unggahan file excel cal_freq
    Route::post('/upload/excel/cal_freq', [CalFreq::class, 'uploadCalFreq'])->name('upload.excel.cal_freq');
    //rute untuk unggahan file Excel type
    Route::post('/upload/excel/types', [SubTableType::class, 'uploadType'])->name('upload.excel.types');
    //rute untuk unggahan file Excel merk
    Route::post('/upload/excel/merks', [SubTableMerk::class, 'uploadMerk'])->name('upload.excel.merks');
    //rute untuk unggahan file Excel range
    Route::post('/upload/excel/ranges', [SubTableRange::class, 'uploadRange'])->name('upload.excel.ranges');
    //rute untuk unggahan file Excel resolution
    Route::post('/upload/excel/resolutions', [SubTableResolution::class, 'uploadResolution'])->name('upload.excel.resolutions');
    //rute untuk unggahan file Excel area
    Route::post('/upload/excel/areas', [SubTableArea::class, 'uploadArea'])->name('upload.excel.areas');
    //rute untuk unggahan file Excel carname
    Route::post('/upload/excel/carnames', [SubTableCarname::class, 'uploadCarname'])->name('upload.excel.carnames');
    //rute untuk unggahan file Excel measuring_device
    Route::post('/upload/excel/measuring_devices', [UploadMeasuringDevice::class, 'uploadMeasuringDevice'])->name('upload.excel.measuring_devices');
    //rute untuk unggahan file Excel control measuring device
    Route::post('/upload/excel/control_measuring_devices', [UploadControlMeasuringDevice::class, 'uploadControlMeasuringDevice'])->name('upload.excel.control_measuring_devices');

    //    pagination datatable measuring device
    Route::get('measuring_device/index', [MeasuringDeviceController::class, 'index'])->name('measuring_device.index');
    Route::get('/measuring_device/index/json', [MeasuringDeviceController::class, 'data'])->name('measuring_device_json.data');

    //    pagination datatable freq cal
    Route::get('freq_cal/index', [FreqCalMeasuringDeviceController::class, 'index'])->name('freq_cal.index');
    Route::get('/freq_cal/index/json', [FreqCalMeasuringDeviceController::class, 'data'])->name('freq_cal_json.data');

 //    pagination datatable calibration
    Route::get('cal/index', [CalibrationController::class, 'index'])->name('cal.index');
    Route::get('/cal/index/json', [CalibrationController::class, 'data'])->name('cal_json.data');
    Route::get('/getvalue/{id}', [CalibrationController::class, 'getAllValue'])->name('getAllValue');


});

Route::group(['middleware' => 'admin'], function () {

});

