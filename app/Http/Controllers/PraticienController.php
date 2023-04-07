<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use App\Metier\Employe;
use App\dao\ServiceEmploye;
use App\Exceptions\MonException;
use App\dao\ServicePraticien;
use App\Http\Controllers\ServiceSpecialite;



class PraticienController extends Controller
{
    public function listerPraticien()
    {
        $unPraticien = new ServicePraticien();
       try {
            $mesPraticiens = $unPraticien->getListePraticien();
        }catch (MonException $e) {
        $monErreur = $e->getMessage();
        return view('vues/pageErreur', compact('monErreur'));
    } catch (Exception $e) {
        $monErreur = $e->getMessage();
        return view('vues/pageErreur', compact('monErreur'));
    }
         return view('vues/formListePraticien', compact('mesPraticiens'));
     }


    public function modifier($id)
    {
        try {
            $unPraticienSpe = new SpePraticien();
            $unPraticien = $unPraticienSpe->getPraticien($id);
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (\Mockery\Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
        return view('vues/formModifierPraticien', compact('unPraticien'));
    }

    public function postSearch(){
        try {
            $nom = Request::input("nom");
            $uneSpe = new ServicePraticien();
            $SearchSpe = $uneSpe->getSpeSearch($nom);

            $unPra = new ServicePraticien();
            $SearchPra = $unPra->getPraSearch($nom);
            return view('vues.SearchResult', compact('SearchSpe', 'SearchPra'));
        }catch (monException $e) {
            $monErreur = $e->getMessage();
            return view('vues.pageErreur',compact('monErreur'));
        }catch (Exception $e){
            $Erreur = $e->getMessage();
            return view( 'vues.pageErreur', compact('Erreur'));
        }
    }

 }
