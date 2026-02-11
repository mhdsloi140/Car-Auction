@extends('layouts.app')

@section('content')
<div class="container my-5">

    @livewire('seller.dashboard.seller-stats')
</div>
<div class="container my-4" wire:poll.6s>

    @livewire('seller.dashboard.notifications')
</div>

@endsection
