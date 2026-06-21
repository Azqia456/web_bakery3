<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Diproses - Three D Bakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; background: #f7f3e9; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: white; border-radius: 16px; padding: 40px; max-width: 480px; width: 100%; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .icon { font-size: 64px; margin-bottom: 16px; }
        h1 { font-size: 24px; color: #2d3748; margin-bottom: 8px; }
        p { color: #6c757d; margin-bottom: 24px; line-height: 1.5; }
        .btn { display: inline-block; background: #8b6f47; color: white; padding: 12px 32px; border-radius: 10px; text-decoration: none; font-weight: 600; transition: background 0.3s; }
        .btn:hover { background: #6b4f33; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">⏳</div>
        <h1>Pembayaran Diproses</h1>
        <p>Pembayaran Anda sedang diproses. Kami akan mengirimkan notifikasi setelah pembayaran terverifikasi.</p>
        <a href="{{ route('pelanggan.dashboard') }}" class="btn">Kembali ke Dashboard</a>
    </div>
</body>
</html>
