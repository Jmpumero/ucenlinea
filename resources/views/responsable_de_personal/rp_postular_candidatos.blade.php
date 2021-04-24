@extends('layouts.admin')

@section('content')
    {{-- <livewire:select-formaciones> --}}
        @livewire('select-formaciones',['user'=>$user])
@endsection
