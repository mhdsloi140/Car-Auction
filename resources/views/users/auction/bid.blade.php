@extends('layouts-users.app')

@section('title', 'المزايدة')

@section('content-user')

<div class="container my-5" style="direction: rtl; text-align: right;">
   
<div class="mt-3">
    <h5 class="fw-bold">الوقت المتبقي لانتهاء المزاد:</h5>
    <div id="countdown" class="fs-4 text-danger fw-bold"></div>
</div>


<input type="hidden" id="auctionEndTime" value="{{ optional($auction->end_at)->format('Y-m-d\TH:i:s') }}">



    <h2 class="fw-bold mb-4">المزايدة على المزاد رقم #{{ $auction->id }}</h2>

    @livewire('user.place-bid', ['auction' => $auction])

</div>

<script>
    function startCountdown() {
        const endTime = document.getElementById('auctionEndTime').value;

        if (!endTime) {
            document.getElementById("countdown").innerHTML = "لا يوجد وقت انتهاء للمزاد";
            return;
        }

        const end = new Date(endTime).getTime();

        const timer = setInterval(function () {
            const now = new Date().getTime();
            const distance = end - now;

            if (distance <= 0) {
                clearInterval(timer);
                document.getElementById("countdown").innerHTML = "انتهى المزاد";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML =
                `${days} يوم - ${hours} ساعة - ${minutes} دقيقة - ${seconds} ثانية`;
        }, 1000);
    }

    startCountdown();
</script>



@endsection
