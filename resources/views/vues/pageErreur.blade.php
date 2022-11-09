@extends('layouts.master');
@section('content')
<div class="alert-danger" role="alert">
    @if( $monErreur != "")
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">{{$monErreur}}</span>
    @endif
</div>
@stop
