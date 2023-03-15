    <?php

    use App\Http\Controllers\VoteController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(VoteController::class)->prefix('vote')->group(function () {
    Route::get('list', 'list')->name('vote.list');
    Route::post('create', 'create')->name('vote.create');
    Route::get('get/{id}', 'get')->name('vote.get');
    Route::put('update/{id}', 'update')->name('vote.update');
    Route::delete('delete/{id}', 'delete')->name('vote.delete');
});
