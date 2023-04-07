<?php

namespace App\Http\Controllers;
use App\dao\ServiceVisiteur;
use Request;
use Exception;
use App\MonException;

class VisiteurController extends Controller
{
    public function getLogin()
    {
        try {
            $erreur = "";

            return view('vues/formLoging');
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }

    public function signIn()
    {
        try {
            $login = Request::input('login');
            $pwd = Request::input('pwd');
            $unVisiteur = new ServiceVisiteur();
            $connected = $unVisiteur->login($login, $pwd);

            if ($connected) {

                return view('home');
            } else {
                $erreur = "Login ou mot de passe inconnu";
                return view('vues/formLoging', compact('erreur'));
            }
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/formLogin', compact('erreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/formLogin', compact('erreur'));
        }
    }

    public function signOut()
    {
        $unVisiteur = new ServiceVisiteur();
        $unVisiteur->logout();
        return view('home');
    }


}
