@extends('layouts.app')


@section('content')

<h1>CONTACT PAGE</h1>
<br>
<br>
<ol>
    @if (count($pple)>0)
        @foreach ($pple as $person)
            <li>{{$person}}</li>
        @endforeach
    @endif
</ol>


@endsection