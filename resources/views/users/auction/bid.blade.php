@extends('layouts-users.app')

@section('title', 'المزايدة')

@section('content')

@livewire('user.place-bid', ['auction' => $auction])

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .bid-modern {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f5f9ff 0%, #e8f0fe 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* شريط التنقل */
    .modern-breadcrumb {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(8px);
        border-radius: 60px;
        padding: 0.7rem 2rem;
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        border: 1px solid rgba(0, 76, 128, 0.15);
        box-shadow: 0 8px 20px -6px rgba(0, 20, 40, 0.1);
    }
    .modern-breadcrumb .breadcrumb-item {
        display: flex;
        align-items: center;
        color: #1e293b;
        font-size: 1rem;
    }
    .modern-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: #004c80;
        font-size: 1.4rem;
        line-height: 1;
        opacity: 0.8;
        margin: 0 0.5rem;
    }
    .breadcrumb-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #004c80;
        padding: 0.3rem 1.2rem;
        border-radius: 40px;
        transition: all 0.2s;
        font-weight: 500;
    }
    .breadcrumb-link:hover {
        background: rgba(0, 76, 128, 0.1);
        color: #002b44;
    }
    .modern-breadcrumb .breadcrumb-item.active {
        display: flex;
        align-items: center;
        color: #002b44;
        background: rgba(0, 76, 128, 0.1);
        padding: 0.3rem 1.5rem;
        border-radius: 40px;
        font-weight: 700;
        border: 1px solid rgba(0, 76, 128, 0.3);
    }

    /* البطاقات الإحصائية */
    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 24px;
        box-shadow: 0 10px 30px -5px rgba(0, 40, 80, 0.1);
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px -8px rgba(0, 76, 128, 0.2);
    }
    .stat-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #0a2540;
        line-height: 1.2;
    }

    /* عداد الوقت */
    .timer-card .timer-display {
        font-size: 2.5rem;
        font-weight: 800;
        font-family: 'Courier New', monospace;
        color: #004c80;
        background: #e0edff;
        padding: 0.5rem 1rem;
        border-radius: 60px;
        letter-spacing: 4px;
        border: 2px solid #004c80;
    }

    /* البطاقات الرئيسية */
    .content-card {
        background: white;
        border-radius: 30px;
        padding: 2rem;
        box-shadow: 0 15px 35px -8px rgba(0, 40, 80, 0.15);
        transition: all 0.2s;
    }
    .content-card:hover {
        box-shadow: 0 25px 50px -12px rgba(0, 76, 128, 0.25);
    }
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0a2540;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        border-bottom: 2px solid #e0edff;
        padding-bottom: 0.75rem;
    }
    .section-title i {
        color: #004c80;
        font-size: 1.5rem;
    }

    /* السعر الحالي */
    .current-price {
        background: #f8fafd;
        border-radius: 60px;
        padding: 1rem 2rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #cbd5e1;
    }
    .price-label {
        font-size: 1rem;
        font-weight: 500;
        color: #475569;
    }
    .price-value {
        font-size: 2rem;
        font-weight: 800;
        color: #004c80;
    }

    /* أزرار الزيادة */
    .bid-increment-section {
        margin-bottom: 2rem;
    }
    .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.75rem;
        display: block;
    }
    .increment-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    .increment-btn {
        background: white;
        border: 2px solid #cbd5e1;
        color: #1e293b;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 60px;
        transition: all 0.2s;
        font-size: 1rem;
        cursor: pointer;
        flex: 1 1 auto;
        min-width: 100px;
    }
    .increment-btn:hover {
        border-color: #004c80;
        background: #e0edff;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px -5px #004c80;
    }

    /* زر المزايدة الرئيسي */
    .btn-bid-now {
        background: #004c80;
        border: none;
        color: white;
        font-weight: 700;
        font-size: 1.25rem;
        padding: 1rem 2rem;
        border-radius: 60px;
        width: 100%;
        transition: all 0.3s;
        box-shadow: 0 10px 20px -5px #004c80;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-bid-now:hover {
        background: #002b44;
        transform: translateY(-3px);
        box-shadow: 0 20px 30px -8px #004c80;
    }

    /* رابط عرض الكل */
    .view-all-link {
        color: #004c80;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        transition: color 0.2s;
    }
    .view-all-link:hover {
        color: #002b44;
        text-decoration: underline;
    }

    /* تنسيق أثر المزايدات - تصميم جديد مطابق للصورة */
    .bids-timeline {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .bid-timeline-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #f8fafd;
        padding: 0.75rem 1.25rem;
        border-radius: 50px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .bid-timeline-item:hover {
        background: #e0edff;
        border-color: #004c80;
        transform: translateX(-5px);
    }
    .bid-amount-badge {
        background: #004c80;
        color: white;
        font-weight: 700;
        padding: 0.5rem 1rem;
        border-radius: 40px;
        min-width: 70px;
        text-align: center;
        font-size: 1rem;
        box-shadow: 0 4px 8px rgba(0, 76, 128, 0.2);
    }
    .bidder-details {
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .bidder-name {
        font-weight: 700;
        color: #0a2540;
        font-size: 1rem;
    }
    .bid-time {
        font-size: 0.8rem;
        color: #64748b;
    }

    /* أزرار All */
    .all-bids-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }
    .btn-all {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #334155;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 40px;
        transition: all 0.2s;
        cursor: pointer;
        flex: 1;
    }
    .btn-all:hover {
        background: #004c80;
        color: white;
        border-color: #004c80;
    }
    .increment-btn {
    border: 1px solid #0d6efd;
    background-color: white;
    color: #0d6efd;
    padding: 0.5rem 1rem;
    border-radius: 60px;
    cursor: pointer;
    transition: 0.2s;
}

.increment-btn:hover {
    background-color: #e7f1ff;
}

.increment-btn.active {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
}
.timer-card {

    color: #fff;
    padding: 20px;
    border-radius: 60px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.timer-display {
    font-size: 2rem;
    font-weight: bold;
    margin-top: 10px;
    letter-spacing: 2px;
}


    /* تحسينات الجوال */
    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }
        .timer-card .timer-display {
            font-size: 2rem;
        }
        .increment-btn {
            min-width: 80px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }
        .price-value {
            font-size: 1.5rem;
        }
        .modern-breadcrumb {
            padding: 0.5rem 1.2rem;
            gap: 0.3rem;
        }
        .breadcrumb-link, .modern-breadcrumb .breadcrumb-item.active {
            padding: 0.2rem 0.8rem;
        }
    }
</style>

<!-- سكريبت العدّاد (يعمل مع الوقت القادم من الخادم) -->
<script>
function startCountdown() {
    const endTimeInput = document.getElementById('auctionEndTime');
    if (!endTimeInput) return;

    function updateTimer() {
        const endTime = new Date(endTimeInput.value).getTime();
        const now = new Date().getTime();
        const diff = endTime - now;

        const timerDisplay = document.getElementById('countdown');

        if (diff <= 0) {
            timerDisplay.innerHTML = "انتهى المزاد";
            return;
        }

        let hours = Math.floor(diff / (1000 * 60 * 60));
        let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((diff % (1000 * 60)) / 1000);

        timerDisplay.innerHTML =
            `${String(hours).padStart(2, '0')}:` +
            `${String(minutes).padStart(2, '0')}:` +
            `${String(seconds).padStart(2, '0')}`;
    }

    updateTimer();
    setInterval(updateTimer, 1000);
}

document.addEventListener("DOMContentLoaded", startCountdown);

// تحديث الوقت عند وصول مزايدة جديدة من Livewire
document.addEventListener('livewire:update-end-time', event => {
    document.getElementById('auctionEndTime').value = event.detail.endTime;
});
</script>

@endsection
