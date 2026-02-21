@extends('layouts.app')

@section('content')
<div class="add-user-container">
    <div class="add-user-card">
        <h3 class="add-user-title">
            <i class="bi bi-shop"></i>
            إضافة معرض جديد
        </h3>

        @if (session('success'))
            <div class="alert-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-validation">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

     <form method="POST" action="{{ route('add-user.store') }}" id="addUserForm">
    @csrf

    <div class="form-group">
        <label for="name">
            <i class="bi bi-person"></i>
            الاسم الكامل
        </label>
        <input type="text"
               id="name"
               name="name"
               value="{{ old('name') }}"
               placeholder="أدخل الاسم الكامل"
               class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="phone">
            <i class="bi bi-telephone"></i>
            رقم الجوال
        </label>
        <input type="tel"
               id="phone"
               name="phone"
               value="{{ old('phone') }}"
               placeholder="05xxxxxxxx"
               class="form-control @error('phone') is-invalid @enderror"
               dir="ltr">
        @error('phone')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    {{-- حقل الموقع على الخريطة --}}
    <div class="form-group">
        <label for="searchBox">
            <i class="bi bi-geo-alt"></i>
            الموقع على الخريطة
        </label>

        {{-- حقل البحث --}}
        <div class="search-container">
            <input type="text"
                   id="searchBox"
                   placeholder="ابحث عن عنوان..."
                   class="form-control search-input"
                   autocomplete="off">

            {{-- نتائج البحث --}}
            <div id="searchResults" class="search-results"></div>
        </div>

        {{-- خريطة مصغرة --}}
        <div id="map" class="map-container"></div>

        {{-- حقول خط الطول والعرض (مخفية) --}}
        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
        <input type="hidden" name="address" id="address" value="{{ old('address') }}">

        {{-- عرض العنوان المحدد --}}
        <div class="selected-location" id="selectedLocation">
            <i class="bi bi-pin-map"></i>
            <span>لم يتم تحديد موقع بعد</span>
        </div>

        @error('latitude')
            <span class="error-message">{{ $message }}</span>
        @enderror
        @error('longitude')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="info-message">
        <i class="bi bi-info-circle"></i>
        سيتم إنشاء كلمة مرور تلقائية وإرسالها إلى رقم الجوال
    </div>

    <button type="submit" class="btn-submit" id="submitBtn">
        <i class="bi bi-plus-circle"></i>
        إضافة معرض
    </button>
</form>
    </div>
</div>

<style>
.add-user-container {
    max-width: 480px;
    margin: 40px auto;
    padding: 20px;
}

.add-user-card {
    background: #ffffff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    font-family: 'Tajawal', sans-serif;
}

.add-user-title {
    text-align: center;
    margin-bottom: 25px;
    color: #2c3e50;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 1.5rem;
}

.add-user-title i {
    color: #3498db;
    font-size: 1.8rem;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #34495e;
    font-size: 14px;
    font-weight: 600;
}

.form-group label i {
    margin-left: 4px;
    color: #3498db;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #dcdcdc;
    border-radius: 8px;
    font-size: 15px;
    transition: 0.2s;
    outline: none;
    font-family: 'Tajawal', sans-serif;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52,152,219,0.1);
}

.form-control.is-invalid {
    border-color: #e74c3c;
}

.error-message {
    color: #e74c3c;
    font-size: 13px;
    margin-top: 5px;
    display: block;
    display: flex;
    align-items: center;
    gap: 4px;
}

.error-message::before {
    content: '⚠️';
    font-size: 12px;
}

.search-container {
    position: relative;
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #dcdcdc;
    border-radius: 8px;
    margin-top: 5px;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.search-result-item {
    padding: 10px 15px;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s;
    font-size: 14px;
}

.search-result-item:hover {
    background: #f8f9fa;
}

.search-result-item:last-child {
    border-bottom: none;
}

.search-result-item i {
    color: #3498db;
    margin-left: 8px;
    font-size: 12px;
}

.map-container {
    width: 100%;
    height: 300px;
    border-radius: 8px;
    margin: 10px 0;
    border: 1px solid #dcdcdc;
}

.selected-location {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 12px;
    margin-top: 10px;
    font-size: 14px;
    color: #7f8c8d;
    display: flex;
    align-items: center;
    gap: 8px;
}

.selected-location i {
    color: #3498db;
}

.info-message {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 20px;
    font-size: 13px;
    color: #7f8c8d;
    display: flex;
    align-items: center;
    gap: 8px;
}

.info-message i {
    color: #3498db;
}

.btn-submit {
    width: 100%;
    padding: 14px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-submit:hover {
    background: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(52,152,219,0.3);
}

.btn-submit:active {
    transform: scale(0.98);
}

.alert-success,
.alert-error,
.alert-validation {
    padding: 12px 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.alert-success {
    background: #27ae60;
    color: white;
}

.alert-error {
    background: #e74c3c;
    color: white;
}

.alert-validation {
    background: #f39c12;
    color: white;
    display: block;
}

.alert-validation ul {
    margin: 10px 0 0 20px;
    padding: 0;
}

.alert-validation li {
    margin: 5px 0;
}

/* Leaflet custom */
.leaflet-container {
    border-radius: 8px !important;
}
</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // إحداثيات افتراضية (وسط العراق)
    const defaultLat = 33.3152;
    const defaultLng = 44.3661;

    // إنشاء الخريطة
    var map = L.map('map').setView([defaultLat, defaultLng], 13);

    // إضافة طبقة الخريطة من OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // إضافة علامة (Marker)
    var marker = L.marker([defaultLat, defaultLng], {
        draggable: true
    }).addTo(map);

    // تحديث الحقول المخفية عند تحريك العلامة
    marker.on('dragend', function(e) {
        var lat = e.target.getLatLng().lat;
        var lng = e.target.getLatLng().lng;

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        // الحصول على العنوان
        getAddress(lat, lng);
    });

    // تحديث الموقع عند النقر على الخريطة
    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        marker.setLatLng([lat, lng]);

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        getAddress(lat, lng);
    });

    // دالة للحصول على العنوان من الإحداثيات
    function getAddress(lat, lng) {
        const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=ar`;

        fetch(url, {
            headers: {
                'User-Agent': 'MyApp/1.0'
            }
        })
        .then(response => response.json())
        .then(data => {
            var address = data.display_name || 'موقع محدد';
            document.getElementById('selectedLocation').querySelector('span').innerText = address;
            document.getElementById('address').value = address;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('selectedLocation').querySelector('span').innerText = `خط عرض: ${lat.toFixed(6)}, خط طول: ${lng.toFixed(6)}`;
        });
    }

    // البحث عن العناوين
    const searchBox = document.getElementById('searchBox');
    const searchResults = document.getElementById('searchResults');
    let searchTimeout;

    searchBox.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();

        if (query.length < 3) {
            searchResults.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5&accept-language=ar`;

            fetch(url, {
                headers: {
                    'User-Agent': 'MyApp/1.0'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    searchResults.innerHTML = '';
                    data.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'search-result-item';
                        div.innerHTML = `<i class="bi bi-geo-alt"></i> ${item.display_name}`;

                        div.addEventListener('click', function() {
                            const lat = parseFloat(item.lat);
                            const lng = parseFloat(item.lon);

                            map.setView([lat, lng], 15);
                            marker.setLatLng([lat, lng]);

                            document.getElementById('latitude').value = lat;
                            document.getElementById('longitude').value = lng;
                            document.getElementById('address').value = item.display_name;
                            document.getElementById('selectedLocation').querySelector('span').innerText = item.display_name;
                            searchBox.value = item.display_name;
                            searchResults.style.display = 'none';
                        });

                        searchResults.appendChild(div);
                    });
                    searchResults.style.display = 'block';
                } else {
                    searchResults.innerHTML = '<div style="padding: 10px; text-align: center; color: #7f8c8d;">لا توجد نتائج</div>';
                    searchResults.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                searchResults.innerHTML = '<div style="padding: 10px; text-align: center; color: #e74c3c;">حدث خطأ في البحث</div>';
                searchResults.style.display = 'block';
            });
        }, 500);
    });

    // إخفاء نتائج البحث عند النقر خارجها
    document.addEventListener('click', function(e) {
        if (!searchBox.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });

    // إظهار النتائج مرة أخرى عند النقر على حقل البحث
    searchBox.addEventListener('focus', function() {
        if (this.value.length >= 3) {
            searchResults.style.display = 'block';
        }
    });

    // إذا كان هناك قيم قديمة (بعد خطأ في التحقق)
    if (document.getElementById('latitude').value) {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);
        if (lat && lng) {
            map.setView([lat, lng], 15);
            marker.setLatLng([lat, lng]);

            // جلب العنوان إذا كان موجوداً
            if (document.getElementById('address').value) {
                document.getElementById('selectedLocation').querySelector('span').innerText = document.getElementById('address').value;
            } else {
                getAddress(lat, lng);
            }
        }
    }
});
</script>
@endsection
