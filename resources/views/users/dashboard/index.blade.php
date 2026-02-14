@extends('layouts-users.app')


@section('content')


<div class="container-fluid product py-5">
    <div class="container py-5">
        <div class="tab-class">




            @livewire('user.auctions-list')

        </div>
    </div>
</div>


@endsection
