<?php

namespace App\dao;
use Illuminate\Support\Facades\Session;
use Request;
use Exception;
use Illuminate\Support\Facades\Input;
use App\Metier\Visiteur;
use DB;

use App\Exceptions\MonException;

class ServiceVisiteur
{
    public function login($login, $pwd){
        $connected =false;
        try {
            $visiteur = DB::table('visiteur')
                ->select()
                ->where('login_visiteur', '=', $login)
                ->first();
            if ($visiteur) {
                if ($visiteur->pwd_visiteur == $pwd) {
                    Session::put('id', $visiteur->id_visiteur);
                    Session::put('type', $visiteur->id_visiteur);
                    $connected = true;

                }
            }
        }catch (QueryException $e) {
            throw new MonException($e->getMessage(),5);
        }
        return $connected;
    }
public function logout () {
        Session::put('id', 0);
}

}
