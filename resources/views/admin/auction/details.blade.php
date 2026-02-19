@extends('layouts.app')

@section('content')
{{-- @livewire('admin.car-details', ['car' => $car]) --}}
@livewire('admin.car-details', ['car' => $car->id])

@endsection
