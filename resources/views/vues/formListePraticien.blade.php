@extends('layouts.master');
@section('content')
<div class="container">
    <div class="col-md-5">
        <div class="blanc">
            <h1>Liste des Praticiens</h1>
        </div>



<ul>
    <li data-toggle="collapse" data-target=".navabar-collapse.in">
        {!! Form::open(['url'=>'SearchResult', 'files' => true]) !!}
        <input type="search" name="nom">
        <input type="submit" name="button" value="Rechercher">
        {!! Form::close() !!}
    </li>
<ul>


</div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>id</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Specialité</th>

        </tr>
        </thead>
        @foreach($mesPraticiens as $unPrat)
            <tr>
                <td>{{$unPrat->id_praticien}}</td>
                <td>{{$unPrat->nom_praticien}}</td>
                <td>{{$unPrat->prenom_praticien}}</td>
                <td>{{$unPrat->lib_specialite}}</td>

                <td style="text-align: center">
                    <a href="{{url('/ModifierPraticien')}}/{{$unPrat->id_praticien}}">
                            <span class="glyphicon glyphicon-pencil" data-toggle="tooltip"
                                  data-placement="top" title="Modifier">

                            </span>

                    <a class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" data-placement="top" title="Supprimer" href="#"
                       onclick="javascript:if (confirm('Suppression confirmée ?')) window.location ='{{ url('/supprimeSpe')}}/{{$unPrat->id_praticien}}/{{$unPrat->id_specialite}}';">
                    </a>

                    </a>
                </td>
            </tr>
        @endforeach
        <br> <br>
    </table>
</div>
@stop

