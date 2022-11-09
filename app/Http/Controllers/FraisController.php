<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\metier\Frais;
use Exception;
use App\Exceptions\MonException;
use App\dao\ServiceFrais;
use Function Sodium\compare;
use App\Http\Controllers\Controller;
use App\metier\Visiteur;




class FraisController extends Controller{
public function getFraisVisiteurs(){
    try {
        $monErreur = Session::get('monErreur');
        Session::forget('monErreur');
        $unServiceFrais = new ServiceFrais();
        $id_visiteur = Session::get('id');
        $mesFrais = $unServiceFrais->getFrais($id_visiteur);
        return view('vues/listeFrais', compact('mesFrais', 'monErreur'));
    }catch (MonException $e){
        $monErreur = $e->getMessage();
        return view('vues/pageErreur', compact('monErreur'));
    }catch (Exception $e){
        $monErreur = $e->getMessage();
        return view('vues/pageErreur', compact('monErreur'));
    }
}

public function updateFrais($id_frais) {
    try {
        $monErreur = "";
        $unServiceFrais = new ServiceFrais();
        $unFrais = $unServiceFrais->getById($id_frais);
        $titreVue = "Modification d'une fiche de Frais";
        return view('Vues/formFrais', compact('unFrais', 'titreVue', 'monErreur'));
    } catch (MonException $e) {
        $monErreur = $e->getMessage();
        return view('Vues/pageErreur', compact('monErreur'));
    } catch (Exception $e) {
        $monErreur = $e->getMessage();
        return view('Vues/pageErreur', compact ('monErreur'));
    }
}

public function validateFrais(){
    try {
        $id_frais = Request::input('id_frais');
        $anneemois = Request::input('anneemois');
        $nbjustificatifs = Request::input('nbjustificatifs');
        $unServiceFrais = new ServiceFrais();
        if ($id_frais > 0) {
            $unServiceFrais->updateFrais($id_frais, $anneemois, $nbjustificatifs);
        } else {
            $montant = Request::input('montant');
            $id_visiteur = Session::get('id');
            $unServiceFrais->insertFrais($anneemois, $nbjustificatifs, $id_visiteur, $montant);
        }
        return redirect('/getListeFrais');
    }catch (MonException $e) {
        $monErreur = $e->getMessage();
        return view('Vues/pageErreur', compact('monErreur'));
    }catch (Exception $e) {
        $monErreur = $e->getMessage();
        return view('Vues/pagErreur', compact('monErreur'));
    }
}

public function addFrais() {
    try {
        $monErreur = "";
        $titreVue = "Ajout d'une fiche de Frais";
        $unFrais = new Frais();
        return view('Vues/formFrais', compact('unFrais', 'titreVue', 'monErreur'));
            }catch (MonException $e) {
        $monErreur = $e->getMessage();
        return view('Vues/pageErreur', compact('monErreur'));
    }catch (Exception $e){
        $monErreur = $e->getMessage();
        return view('Vues/pageErreur', compact('monErreur'));
    }
}

public function validateFraisHorsFrais(){
    try {
        $id_frais = Request::input('id_frais');
        $anneemois = Request::input('anneemois');
        $nbjustificatifs = Request::input('nbjustificatifs');
        $unServiceFrais = new ServiceFrais();
        if ($id_frais > 0) {
            $unServiceFrais->updateFrais($id_frais, $anneemois, $nbjustificatifs);
        }else {
            $montant = Request::input('montant');
            $id_visiteur = Session::get('id');
            $unServiceFrais->insertFrais($anneemois, $nbjustificatifs, $id_visiteur, $montant);
        }

        return redirect('/getListeFrais');
    }catch (MonException $e) {
        $monErreur = $e->getMessage();
        return view('Vues/pageErreur', compact('monErreur'));
    }catch (Exception $e) {
        $monErreur = $e->getMessage();
        return view('Vues/pagErreur', compact('monErreur'));
        }
    }



    public function supprimerFrais($id_frais)
    {
        $unSeviceFrais = new ServiceFrais();
        try{
            $unSeviceFrais->deleteFrais($id_frais);
        }catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('Vues/pageErreur', compact('monErreur'));
        }
        catch (Exception $e) {
            Session::put('monErreur', $e->getMessage());

        } finally {
            return redirect('/getListeFrais');
        }

    }



}
