<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>

    <form action="{{ route('admin.login.submit') }}" method="POST">
        @csrf


        @if ($errors->has('login_error'))
        <div class="alert alert-danger text-center">
            {{ $errors->first('login_error') }}
        </div>
        @endif

        <section class="vh-100" style="background-color: #508bfc;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-2-strong" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">

                                <h3 class="mb-5">تسجيل الدخول</h3>


                                <div class="form-outline mb-4 text-start">
                                    <label class="form-label" for="phone"> رقم الهاتف</label>
                                    <input type="tel" id="phone" name="phone" class="form-control form-control-lg" />
                                    @error('phnoe')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- كلمة المرور --}}
                                <div class="form-outline mb-4 text-start">
                                    <label class="form-label" for="password">كلمة المرور</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg" />
                                    @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- تذكر كلمة المرور --}}
                                <div class="form-check d-flex justify-content-start mb-4">
                                    <input class="form-check-input" type="checkbox" id="remember" />
                                    <label class="form-check-label" for="remember">تذكر كلمة المرور</label>
                                </div>

                                {{-- زر تسجيل الدخول --}}
                                <button class="btn btn-primary btn-lg btn-block w-100" type="submit">تسجيل
                                    الدخول</button>

                                <hr class="my-4">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
