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
                ->Join('posseder','praticien.id_praticien','=','posseder.id_praticien')
                ->Join('specialite','posseder.id_specialite','=', 'specialite.id_specialite')
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

    public function getUneSpeDunPraticien ($id_praticien,$id_specialite) {
        try {
            $monPraticien=DB::table('praticien')
                ->Select()
                ->join('posseder','praticien.id_praticien','=','posseder.id_praticien')
                ->join('specialite','specialite.id_specialite','=','posseder.id_specialite')
                ->where('praticien.id_praticien','=', $id_praticien)
                ->where('posseder.id_specialite','=',$id_specialite)
                ->first();
            return $monPraticien;

        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function getSpecialitePossiblePraticien($id_praticien)
    {
        $monPraticien=DB::table('specialite')
            ->Select()
            ->whereNotIn('id_specialite',function ($query) use ($id_praticien)
            {
                $query->select('id_specialite')->from('posseder')->where('id_praticien','=',$id_praticien);
            })

            ->get();
        return $monPraticien;
    }

    public function updateSpePraticien($id_praticien,$old_specialite,$new_specialite)
    {
        try {
            DB::table('posseder')
                ->where('posseder.id_praticien','=', $id_praticien)
                ->where('posseder.id_specialite','=',$old_specialite)
                ->update(['id_specialite'=>$new_specialite]);

        }catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
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
