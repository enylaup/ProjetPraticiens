@extends('layouts.master')
@section('content')
    @if (Session::get('type')!="")
        <h1>Praticiens</h1>
        <table class="table table-bordered table-striped table-responsive ">
            <thead>
            <tr>
                <th style="...">nom</th>
                <th style="...">prenom</th>



            </tr>
            </thead>

            @foreach($SearchPra as $unPraticien)

                <tr>
                    <td>
                        {{$unPraticien->nom_praticien}}
                    </td>

                    <td>
                        {{$unPraticien->prenom_praticien}}
                    </td>


                </tr>
            @endforeach
        </table>

        <h1>Les Spécialités</h1>
        <table class="table table-bordered table-stripped table-responsive">
        <thead>
        <tr>

            <th style="...">nom</th>
            @if (Session::get('type')=="A")
                <th style="...">spécialités</th>
                <th style="...">suprimer</th>
            @endif

        </tr>
        </thead>
        @foreach($SearchSpe as $UneSpe)
            <tr>
                <td>{{$UneSpe->lib_specialite}}</td>

                @if(Session::get('type')=="A")
                    <td style="...">
                        <a href="{{url('/modifSpe')}}/{{$UneSpe->id_specialite}}"><span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" tittle="Modifier"></span></a>
                    </td>
                    <td style="...">
                        <a href="{{url('/supprSpe')}}/{{$UneSpe->id_specialite}}"><span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" tittle="Supprimer"></span></a>
                    </td>
                @endif
            </tr>
        @endforeach
        </table>
    @endif


