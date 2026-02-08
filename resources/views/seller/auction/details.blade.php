@extends('layouts.app')

@section('content')
@livewire('seller.car-details', ['car' => $car])

@endsection
