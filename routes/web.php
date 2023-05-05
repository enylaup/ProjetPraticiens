<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\FraisController;
use App\Http\Controllers\PraticienController;
use App\Http\Controllers\RechercheSpeController;
use App\dao\ServicePraticien;
use App\dao\ServiceSpecialite;

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
    return view('home');
});
Route::get('/getLogin', [VisiteurController::class,'getLogin']);
Route::post('/login', [VisiteurController::class,'signIn']);
Route::get('/getLogout', [VisiteurController::class,'signOut']);
Route::get('/getListePraticien',[PraticienController::class,'listerPraticien']);
Route::get('/modifSpe/{id_praticien}/{id_specialite}', [PraticienController::class, 'modifier']);
Route::get('/ajouterFrais', [FraisController::class, 'addFrais']);
Route::post('/validerFrais', [FraisController::class, 'validateFrais']);
Route::get('/supprimerFrais/{id_frais}',[FraisController::class, 'supprimerFrais']);
Route::post('/search', [\App\Http\Controllers\RechercheSpeController::class, 'formListePraticien']);
Route::post('/SearchResult', [PraticienController::class, 'postSearch']);
Route::get('/supprimeSpe/{id_prat}/{id_spe}',[RechercheSpeController::class,'suppression']);
Route::post('postmodifierSpecialite',[PraticienController::class,'postModifierSpecalite']);



Route::post('/postSearch',
array(
    'uses'=> 'App\Http\Controllers\PraticienController@postSearch',
    'as'=>'postSearch'
));

