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


    public function modifier($id_praticien,$id_specialite)
    {
        try {
            $unPraticienSpe = new ServicePraticien();
            $unPraticien = $unPraticienSpe->getUneSpeDunPraticien($id_praticien,$id_specialite);
            $mesSpePossible=$unPraticienSpe->getSpecialitePossiblePraticien($id_praticien);
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Mockery\Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
        return view('vues/formModifierPraticien', compact('unPraticien','mesSpePossible'));
    }

    public function postModifierSpecalite()
    {
        try {
            $unPraticienSpe = new ServicePraticien();
            $id_praticien=Request::input('id_prat');
            $old_spe=Request::input('old_spe');
            $new_spe=Request::input('spe');
            $unPraticienSpe->updateSpePraticien($id_praticien,$old_spe,$new_spe);

            return view('home');

        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Mockery\Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
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
