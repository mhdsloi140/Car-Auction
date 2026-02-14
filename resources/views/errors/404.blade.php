<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الصفحة غير موجودة - 404</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #f5f6fa;
            color: #2f3640;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            text-align: center;
        }
        h1 {
            font-size: 120px;
            color: #3498db;
            margin: 0;
        }
        h3 {
            font-size: 30px;
            margin: 10px 0;
        }
        p {
            font-size: 18px;
            margin: 10px 0 30px;
        }
        a {
            text-decoration: none;
            padding: 12px 25px;
            background: #3498db;
            color: white;
            border-radius: 5px;
            transition: 0.3s;
        }
        a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <h1>404</h1>
    <h3>الصفحة غير موجودة</h3>
    <p>الصفحة التي تحاول الوصول إليها غير موجودة أو تم نقلها.</p>
    <a href="{{ route('home') }}">العودة للرئيسية</a>
</body>
</html>
