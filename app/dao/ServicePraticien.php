<?php

namespace App\dao;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\MonException;
use Exception;

class ServicePraticien {
    public function getListePraticien()
    {
        try {
            $praticien = DB::table('praticien')
                ->Select()
                ->join('posseder','praticien.id_praticien','=','posseder.id_praticien')
                ->join('specialite','posseder.id_specialite','=', 'specialite.id_specialite')
                ->get();
            return $praticien;
        } catch (\Illuminate\Database\QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }


    }

    public function ajoutPraticien( $id_praticien, $nom_praticien, $prenom_praticien )
    {
        try {
            DB::table('praticien')->insert(
                ['id' => $id_praticien, 'nom' => $nom_praticien,
                    'prenom' => $prenom_praticien ]);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function ModificationPraticien($id_praticien, $nom_praticien, $prenom_praticien)
    {
        try {
            DB::table('Praticien')
                ->where('numPrat',$id_praticien)
                ->update(['id' => $id_praticien, 'nom' => $nom_praticien,
                    'prenom' => $prenom_praticien ]);
        }catch (QueryException $e)
        {
            throw new MonException($e->getMessage(),5);
        }
    }

    public function supprimeSpe($id_prat,$id_spe)
    {
        try {
            DB::table('posseder')
                ->where('id_praticien','=',$id_prat)
                ->where('id_specialite','=', $id_spe)
                ->delete();
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }




    public function getSpeSearch($nom)
    {
        $results = DB::table('specialite')
            ->where('lib_specialite', 'LIKE', $nom . '%')
            ->get();
        return $results;

    }

    public function getPraSearch($nom)
    {
        $results = DB::table('praticien')
            ->where('nom_praticien', 'LIKE', $nom . '%')
            ->get();
        return $results;

    }


}
