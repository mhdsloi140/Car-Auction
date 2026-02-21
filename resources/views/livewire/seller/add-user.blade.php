<div>
    <div style="
        max-width:480px;
        margin:auto;
        padding:25px;
        background:#ffffff;
        border-radius:12px;
        box-shadow:0 4px 15px rgba(0,0,0,0.08);
        font-family: 'Tajawal', sans-serif;
    ">

        <h3 style="
            text-align:center;
            margin-bottom:25px;
            color:#2c3e50;
            font-weight:600;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;
        ">
            <i class="bi bi-shop" style="color:#3498db;"></i>
            إضافة مستخدم جديد
        </h3>

        @if (session()->has('success'))
            <div style="
                background:#27ae60;
                color:white;
                padding:12px 15px;
                margin-bottom:20px;
                border-radius:8px;
                text-align:center;
                font-size:15px;
                display:flex;
                align-items:center;
                justify-content:center;
                gap:8px;
            ">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div style="
                background:#e74c3c;
                color:white;
                padding:12px 15px;
                margin-bottom:20px;
                border-radius:8px;
                text-align:center;
                font-size:15px;
                display:flex;
                align-items:center;
                justify-content:center;
                gap:8px;
            ">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        <div style="margin-bottom:15px;">
            <label style="
                display:block;
                margin-bottom:6px;
                color:#34495e;
                font-size:14px;
                font-weight:600;
            ">
                <i class="bi bi-person" style="margin-left:4px;"></i>
                الاسم الكامل
            </label>
            <input type="text"
                   wire:model.defer="name"
                   placeholder="أدخل الاسم الكامل"
                   style="
                       width:100%;
                       padding:12px 15px;
                       border:1px solid #dcdcdc;
                       border-radius:8px;
                       font-size:15px;
                       transition:0.2s;
                       outline:none;
                   "
                   onfocus="this.style.borderColor='#3498db'"
                   onblur="this.style.borderColor='#dcdcdc'">
            @error('name')
                <span style="
                    color:#e74c3c;
                    font-size:13px;
                    margin-top:5px;
                    display:block;
                    display:flex;
                    align-items:center;
                    gap:4px;
                ">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div style="margin-bottom:20px;">
            <label style="
                display:block;
                margin-bottom:6px;
                color:#34495e;
                font-size:14px;
                font-weight:600;
            ">
                <i class="bi bi-telephone" style="margin-left:4px;"></i>
                رقم الجوال
            </label>
            <input type="tel"
                   wire:model.defer="phone"
                   placeholder="05xxxxxxxx"
                   style="
                       width:100%;
                       padding:12px 15px;
                       border:1px solid #dcdcdc;
                       border-radius:8px;
                       font-size:15px;
                       transition:0.2s;
                       outline:none;
                   "
                   onfocus="this.style.borderColor='#3498db'"
                   onblur="this.style.borderColor='#dcdcdc'">
            @error('phone')
                <span style="
                    color:#e74c3c;
                    font-size:13px;
                    margin-top:5px;
                    display:block;
                    display:flex;
                    align-items:center;
                    gap:4px;
                ">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- حقل الموقع على الخريطة --}}
        <div style="margin-bottom:20px;">
            <label style="
                display:block;
                margin-bottom:6px;
                color:#34495e;
                font-size:14px;
                font-weight:600;
            ">
                <i class="bi bi-geo-alt" style="margin-left:4px;"></i>
                الموقع على الخريطة
            </label>

            {{-- حقل البحث --}}
            <div style="position: relative;">
                <input type="text"
                       id="searchBox"
                       placeholder="ابحث عن عنوان..."
                       style="
                           width:100%;
                           padding:12px 15px;
                           border:1px solid #dcdcdc;
                           border-radius:8px;
                           margin-bottom:10px;
                           font-size:15px;
                           transition:0.2s;
                           outline:none;
                       "
                       onfocus="this.style.borderColor='#3498db'"
                       onblur="this.style.borderColor='#dcdcdc'"
                       autocomplete="off">

                {{-- نتائج البحث --}}
                <div id="searchResults" style="
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
                "></div>
            </div>

            {{-- خريطة مصغرة --}}
            <div id="map" style="
                width:100%;
                height:300px;
                border-radius:8px;
                margin-bottom:10px;
                border:1px solid #dcdcdc;
            "></div>

            {{-- حقول خط الطول والعرض (مخفية) --}}
            <input type="hidden" wire:model.defer="latitude" id="latitude">
            <input type="hidden" wire:model.defer="longitude" id="longitude">

            {{-- عرض العنوان المحدد --}}
            <div style="
                background:#f8f9fa;
                border-radius:8px;
                padding:12px;
                margin-top:10px;
                font-size:14px;
                color:#7f8c8d;
                display:flex;
                align-items:center;
                gap:8px;
            ">
                <i class="bi bi-pin-map" style="color:#3498db;"></i>
                <span id="selectedLocation">لم يتم تحديد موقع بعد</span>
            </div>

            @error('latitude')
                <span style="
                    color:#e74c3c;
                    font-size:13px;
                    margin-top:5px;
                    display:block;
                    display:flex;
                    align-items:center;
                    gap:4px;
                ">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div style="
            background:#f8f9fa;
            border-radius:8px;
            padding:12px;
            margin-bottom:20px;
            font-size:13px;
            color:#7f8c8d;
            display:flex;
            align-items:center;
            gap:8px;
        ">
            <i class="bi bi-info-circle" style="color:#3498db;"></i>
            سيتم إنشاء كلمة مرور تلقائية وإرسالها إلى رقم الجوال
        </div>

        <button wire:click="addUser"
                wire:loading.attr="disabled"
                style="
                    width:100%;
                    padding:14px;
                    background:#3498db;
                    color:white;
                    border:none;
                    border-radius:8px;
                    cursor:pointer;
                    font-size:16px;
                    font-weight:600;
                    transition:0.3s;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    gap:8px;
                "
                onmouseover="this.style.background='#2980b9'"
                onmouseout="this.style.background='#3498db'"
                onmousedown="this.style.transform='scale(0.98)'"
                onmouseup="this.style.transform='scale(1)'"
        >
            <span wire:loading.remove>
                <i class="bi bi-plus-circle" style="font-size:18px;"></i>
                إضافة المستخدم
            </span>
            <span wire:loading>
                <i class="bi bi-arrow-repeat" style="font-size:18px; animation: spin 1s linear infinite;"></i>
                جاري الإضافة...
            </span>
        </button>
    </div>

    {{-- كل شيء داخل عنصر واحد --}}
    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
        .leaflet-container {
            border-radius: 8px !important;
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // التأكد من أن الخريطة لم يتم تهيئتها من قبل
            if (document.getElementById('map').__mapInitialized) return;

            const mapElement = document.getElementById('map');
            if (!mapElement) return;

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

                // تحديث Livewire model
                @this.set('latitude', lat);
                @this.set('longitude', lng);

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

                @this.set('latitude', lat);
                @this.set('longitude', lng);

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
                    const locationSpan = document.getElementById('selectedLocation');
                    if (locationSpan) {
                        locationSpan.innerText = address;
                    }

                    @this.set('address', address);
                })
                .catch(error => {
                    console.error('Error:', error);
                    const locationSpan = document.getElementById('selectedLocation');
                    if (locationSpan) {
                        locationSpan.innerText = `خط عرض: ${lat.toFixed(6)}, خط طول: ${lng.toFixed(6)}`;
                    }
                });
            }

            // البحث عن العناوين
            const searchBox = document.getElementById('searchBox');
            const searchResults = document.getElementById('searchResults');
            let searchTimeout;

            if (searchBox) {
                searchBox.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);
                    const query = e.target.value.trim();

                    if (query.length < 3) {
                        if (searchResults) searchResults.style.display = 'none';
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
                            if (data.length > 0 && searchResults) {
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

                                        @this.set('latitude', lat);
                                        @this.set('longitude', lng);
                                        @this.set('address', item.display_name);

                                        const locationSpan = document.getElementById('selectedLocation');
                                        if (locationSpan) {
                                            locationSpan.innerText = item.display_name;
                                        }
                                        searchBox.value = item.display_name;
                                        searchResults.style.display = 'none';
                                    });

                                    searchResults.appendChild(div);
                                });
                                searchResults.style.display = 'block';
                            } else if (searchResults) {
                                searchResults.innerHTML = '<div style="padding: 10px; text-align: center; color: #7f8c8d;">لا توجد نتائج</div>';
                                searchResults.style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            if (searchResults) {
                                searchResults.innerHTML = '<div style="padding: 10px; text-align: center; color: #e74c3c;">حدث خطأ في البحث</div>';
                                searchResults.style.display = 'block';
                            }
                        });
                    }, 500);
                });

                // إخفاء نتائج البحث عند النقر خارجها
                document.addEventListener('click', function(e) {
                    if (searchResults && !searchBox.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.style.display = 'none';
                    }
                });

                // إظهار النتائج مرة أخرى عند النقر على حقل البحث
                searchBox.addEventListener('focus', function() {
                    if (this.value.length >= 3 && searchResults) {
                        searchResults.style.display = 'block';
                    }
                });
            }

            // علامة أن الخريطة تم تهيئتها
            document.getElementById('map').__mapInitialized = true;
        });
    </script>
</div>
