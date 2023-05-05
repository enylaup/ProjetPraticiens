<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use App\Exceptions\MonException;
use App\dao\ServicePraticien;
use App\Http\Controllers\ServiceSpecialite;
use Illuminate\Support\Facades\Session;


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



 //ajout
public function ajout () {
    if (Session::get('role') == "admin") {
        try {
            $unPraticien = new ServicePraticien();
            $mesPraticiens = $unPraticien->getListePraticien();
            $unPrat = new ServicePraticien();
            $mesPraticiens = $unPrat->getListePraticien();
            return view('vues/formAjout',
                compact('mesPraticiens', 'mesPraticiens'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('error', compact('erreur'));
        } catch (Exception $ex) {
            $erreur = $ex->getMessage();
            return view('error', compact('erreur'));
        }
    } else {
        $erreur = "Vous n'avez pas l'autorisation d'ajouter";
        return view('error', compact('erreur'));
    }
}

public function postAjoutSejour() {
    try {
        $id_praticien = Request::input('id_praticien');
        $nom_praticien = Request::input('nom_praticien');
        $prenom_praticien = Request::input('prenom_praticien');
        $uneSpe = new ServiceSpecialite();
        $uneSpe->ajoutSpe(id_praticien, nom_praticien, prenom_praticien );
        return view('home');
    } catch (MonException $e) {
        $erreur = $e->getMessage();
        return view('error', compact('erreur'));
    } catch (Exception $ex) {
        $erreur = $ex->getMessage();
        return view('error', compact('erreur'));
    }
}
}
