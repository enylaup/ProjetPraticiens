<?php
namespace App\metier;

use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;
use DB;


class Praticien extends Model
{
    protected $table = 'Praticien';
    public $timestamps=false;
    protected $fillable =[
        'id','nom','prenom'];

}
