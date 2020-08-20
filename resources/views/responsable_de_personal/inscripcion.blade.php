@extends('layouts.admin')

@section('content')

        <div class="card">
            <div class="card-header">the end is coming</div>

            <div class="card-body">


                You are logged in!
                <p>Hola caracola, {{ Auth::user()->name }} !!</p>
            </div>
        </div>



@endsection
