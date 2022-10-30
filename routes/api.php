<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PatientController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\InstitutionController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\ProjectCategoryController;
use App\Http\Controllers\API\InputController;
use App\Http\Controllers\API\ProjectInputController;
use App\Http\Controllers\API\RecordController;
use App\Http\Controllers\API\ProjectLogController;
use App\Http\Controllers\API\MenuRoleController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\ExportController;
use App\Http\Controllers\API\InputDetailController;

Route::middleware('auth:sanctum')
->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware'=>'auth:sanctum'], function(){
    Route::get('auth', [AuthController::class, 'auth']);
    Route::get('menu', [MenuController::class, 'menu']);

    // CRUD
    Route::resource('users', UserController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('institutions', InstitutionController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('inputs', InputController::class);
    Route::resource('input-details', InputDetailController::class);
    Route::resource('project-inputs', ProjectInputController::class);
    Route::resource('project-logs', ProjectLogController::class);
    Route::resource('menu-roles', MenuRoleController::class);
    Route::resource('categories', CategoryController::class);

    // List
    Route::get('roles-list', [RoleController::class, 'list']);
    Route::get('institutions-list', [InstitutionController::class, 'list']);
    Route::get('inputs-properties', [InputController::class, 'properties']);
    Route::get('categories-hierarchy', [CategoryController::class, 'hierarchy']);
    Route::get('categories-list', [CategoryController::class, 'list']);
    Route::get('sub-categories-list', [CategoryController::class, 'sub_list']);
    Route::get('record-list', [RecordController::class, 'list']);
    Route::get('inputs-list', [InputController::class, 'list']);

    // Categories
    Route::get('project-categories/{project_id}', [ProjectCategoryController::class, 'index']);
    Route::post('project-categories/{project_id}', [ProjectCategoryController::class, 'create']);
    Route::patch('project-categories/{project_id}/{category_id}', [ProjectCategoryController::class, 'update']);
    Route::delete('project-categories/{project_id}/{category_id}', [ProjectCategoryController::class, 'destroy']);

    // Record
    Route::get('records/{project_id}', [RecordController::class, 'index']);
    Route::get('project-records', [RecordController::class, 'show']);
    Route::post('project-input', [RecordController::class, 'update']);
    Route::get('input-logs', [ProjectInputController::class, 'input_logs']);
    Route::get('record-project/{record_id}', [RecordController::class, 'record_project']);
    Route::get('category-input/{category_id}', [InputController::class, 'category_input']);
    Route::get('record-report/{record_id}', [RecordController::class, 'record_report']);
    Route::delete('records/{record_id}', [RecordController::class, 'destroy']);
    Route::get('export-list', [ExportController::class, 'list']);
    Route::post('export-data', [ExportController::class, 'export']);

    // Dashboard
    Route::get('dashboard-stats', [DashboardController::class, 'stats']);
    Route::get('dashboard-user', [DashboardController::class, 'user']);
    Route::get('profile', [DashboardController::class, 'profile']);
    Route::post('profile', [DashboardController::class, 'update_profile']);
});
