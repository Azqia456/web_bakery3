<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Three D Bakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-brown: #8B6F47;
            --light-brown: #D4A574;
            --cream: #F7F3E9;
            --white: #FFFFFF;
            --light-gray: #F8F9FA;
            --medium-gray: #E9ECEF;
            --dark-gray: #6C757D;
            --text-dark: #2D3748;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
            --border-radius-lg: 12px;
            --border-radius-xl: 16px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--cream) 0%, #F5F0E6 100%);
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Header Navigation */
        .navbar {
            background: var(--white);
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 16px 0;
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-brown);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-brand i {
            font-size: 24px;
        }

        .navbar-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: var(--light-gray);
            color: var(--text-dark);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-back:hover {
            background: var(--medium-gray);
            transform: translateX(-2px);
        }

        /* Main Content */
        .container {
            max-width: 1400px;
            margin: 32px auto;
            padding: 0 24px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 40px;
            animation: slideDown 0.6s ease;
        }

        .profile-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-brown);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .profile-header p {
            font-size: 16px;
            color: var(--dark-gray);
        }

        /* Profile Card */
        .profile-card {
            background: var(--white);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            animation: slideUp 0.6s ease;
            display: flex;
            min-height: 600px;
        }

        .profile-card-header {
            background: linear-gradient(135deg, var(--primary-brown), var(--light-brown));
            color: var(--white);
            padding: 40px 24px;
            text-align: center;
            position: relative;
            flex: 0 0 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .profile-photo-container {
            position: relative;
            width: 160px;
            height: 160px;
            margin-bottom: 20px;
        }

        .profile-photo {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--white);
            box-shadow: var(--shadow-xl);
            background: rgba(255, 255, 255, 0.1);
        }

        .photo-edit-overlay {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 45px;
            height: 45px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-md);
            color: var(--primary-brown);
            font-size: 18px;
            transition: var(--transition);
        }

        .photo-edit-overlay:hover {
            transform: scale(1.1);
            background: var(--light-gray);
        }

        .profile-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .profile-role {
            font-size: 14px;
            opacity: 0.9;
            text-transform: capitalize;
        }

        /* Profile Form */
        .profile-form {
            padding: 40px;
            flex: 1;
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 32px;
            padding-bottom: 32px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .form-group:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .form-group-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .form-group-label {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--primary-brown);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group-label i {
            font-size: 16px;
        }

        .form-group-value {
            font-size: 16px;
            color: var(--text-dark);
            padding: 12px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 40px;
        }

        .form-group-value strong {
            font-weight: 600;
        }

        .form-group-value.empty {
            color: var(--dark-gray);
            font-style: italic;
        }

        .btn-edit {
            padding: 8px 16px;
            background: var(--light-brown);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-edit:hover {
            background: var(--primary-brown);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-edit i {
            font-size: 14px;
        }

        .edit-form {
            display: none;
            margin-top: 16px;
            padding: 20px;
            background: var(--light-gray);
            border-radius: var(--border-radius);
            animation: slideDown 0.3s ease;
        }

        .edit-form.active {
            display: block;
        }

        .form-input-group {
            margin-bottom: 16px;
        }

        .form-input-group:last-child {
            margin-bottom: 0;
        }

        .form-input-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-input-group input,
        .form-input-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--medium-gray);
            border-radius: var(--border-radius);
            font-size: 14px;
            font-family: inherit;
            transition: var(--transition);
            color: var(--text-dark);
        }

        .form-input-group input:focus,
        .form-input-group textarea:focus {
            outline: none;
            border-color: var(--primary-brown);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
        }

        .form-input-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-primary {
            padding: 12px 24px;
            background: var(--primary-brown);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-brown), var(--light-brown));
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            padding: 12px 24px;
            background: var(--medium-gray);
            color: var(--text-dark);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary:hover {
            background: var(--dark-gray);
            color: var(--white);
        }

        /* Alert Messages */
        .alert {
            padding: 16px 20px;
            border-radius: var(--border-radius);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }

        .alert-success {
            background: #D1F2EB;
            color: #065F46;
            border-left: 4px solid var(--success);
        }

        .alert-error {
            background: #FEE2E2;
            color: #7F1D1D;
            border-left: 4px solid var(--danger);
        }

        .alert i {
            font-size: 18px;
            flex-shrink: 0;
        }

        .alert-close {
            margin-left: auto;
            cursor: pointer;
            font-size: 18px;
            opacity: 0.7;
            transition: var(--transition);
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* File Upload */
        .file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-input {
            display: none;
        }

        .file-input-label {
            display: block;
            padding: 16px;
            background: var(--cream);
            border: 2px dashed var(--primary-brown);
            border-radius: var(--border-radius);
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--primary-brown);
            font-weight: 600;
        }

        .file-input-label:hover {
            background: rgba(139, 111, 71, 0.05);
            border-color: var(--light-brown);
        }

        .file-input-label i {
            font-size: 24px;
            margin-bottom: 8px;
            display: block;
        }

        .file-preview {
            margin-top: 12px;
            font-size: 13px;
            color: var(--dark-gray);
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading State */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid var(--white);
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        /* Sub cards (verification / password) */
        .bottom-cards {
            display: flex;
            gap: 20px;
            margin-top: 24px;
            align-items: flex-start;
        }

        .card-small {
            background: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
            padding: 20px;
            flex: 1;
        }

        .badge-verified {
            background: rgba(16,185,129,0.12);
            color: var(--success);
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 700;
            display: inline-block;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .profile-card {
                min-height: auto;
            }

            .profile-form {
                padding: 30px;
            }

            .form-group {
                margin-bottom: 24px;
                padding-bottom: 24px;
            }
        }

        @media (max-width: 768px) {
            .profile-card {
                flex-direction: column;
                min-height: auto;
            }

            .profile-card-header {
                flex: 0 0 auto;
                padding: 30px 24px;
            }

            .profile-form {
                padding: 24px;
                flex: 1;
            }

            .form-group {
                margin-bottom: 24px;
                padding-bottom: 24px;
            }

            .profile-header h1 {
                font-size: 24px;
            }

            .profile-photo-container {
                width: 100px;
                height: 100px;
            }

            .form-actions {
                flex-direction: column;
                gap: 8px;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                justify-content: center;
            }

            .form-group-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <i class="fas fa-cake-candles"></i>
                Three D Bakery
            </div>
            <div class="navbar-actions">
                <a href="{{ route('dashboard') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <!-- Alert Messages -->
        @if(session('status') === 'profile-updated')
            <div class="alert alert-success" id="alertSuccess">
                <i class="fas fa-check-circle"></i>
                <span>Profil berhasil diperbarui! ✓</span>
                <span class="alert-close" onclick="this.parentElement.style.display='none';"><i class="fas fa-times"></i></span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error" id="alertError">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Terjadi kesalahan!</strong>
                    <ul style="margin-top: 4px; margin-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <span class="alert-close" onclick="this.parentElement.style.display='none';"><i class="fas fa-times"></i></span>
            </div>
        @endif

        <!-- Page Header -->
        <div class="profile-header">
            <h1>Profil Saya</h1>
            <p>Kelola informasi pribadi Anda</p>
        </div>

        <!-- Profile Card -->
        <div class="profile-card">
            <!-- Header dengan Foto -->
            <div class="profile-card-header">
                <div class="profile-photo-container">
                    <img 
                        id="profilePhotoDisplay" 
                        src="{{ $user->foto_profil ? asset('storage/' . $user->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($user->username) . '&background=' . str_replace('#', '', '8B6F47') . '&color=fff&size=140' }}" 
                        alt="Foto Profil" 
                        class="profile-photo"
                    >
                    <div class="photo-edit-overlay" onclick="document.getElementById('photoInput').click()" title="Ubah Foto Profil">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
                <h2 class="profile-name">{{ $user->username }}</h2>
                <p class="profile-role">{{ ucfirst($user->role) }}</p>
            </div>

            <!-- Form -->
            <form id="profileForm" class="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Hidden Photo Input -->
                <input type="file" id="photoInput" name="foto_profil" class="file-input" accept="image/*" onchange="previewPhoto(this)">

                <!-- Username -->
                <div class="form-group">
                    <div class="form-group-header">
                        <span class="form-group-label">
                            <i class="fas fa-user"></i>
                            Username
                        </span>
                        <button type="button" class="btn-edit" onclick="toggleEdit('username')">
                            <i class="fas fa-pen"></i>
                            Edit
                        </button>
                    </div>
                    <div class="form-group-value" id="usernameValue">
                        <strong>{{ $user->username }}</strong>
                    </div>
                    <div class="edit-form" id="usernameForm">
                        <div class="form-input-group">
                            <label for="usernameInput">Username Baru</label>
                            <input
                                type="text"
                                id="usernameInput"
                                name="username"
                                value="{{ $user->username }}"
                                placeholder="Masukkan username baru"
                                required
                            >
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="toggleEdit('username')">
                                <i class="fas fa-times"></i>
                                Batal
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-check"></i>
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <div class="form-group-header">
                        <span class="form-group-label">
                            <i class="fas fa-envelope"></i>
                            Email
                        </span>
                        <button type="button" class="btn-edit" onclick="toggleEdit('email')">
                            <i class="fas fa-pen"></i>
                            Edit
                        </button>
                    </div>
                    <div class="form-group-value" id="emailValue">
                        <strong>{{ $user->email }}</strong>
                    </div>
                    <div class="edit-form" id="emailForm">
                        <div class="form-input-group">
                            <label for="emailInput">Email Baru</label>
                            <input
                                type="email"
                                id="emailInput"
                                name="email"
                                value="{{ $user->email }}"
                                placeholder="Masukkan email baru"
                                required
                            >
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="toggleEdit('email')">
                                <i class="fas fa-times"></i>
                                Batal
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-check"></i>
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- No Telpon -->
                <div class="form-group">
                    <div class="form-group-header">
                        <span class="form-group-label">
                            <i class="fas fa-phone"></i>
                            No. Telpon
                        </span>
                        <button type="button" class="btn-edit" onclick="toggleEdit('no_telpon')">
                            <i class="fas fa-pen"></i>
                            Edit
                        </button>
                    </div>
                    <div class="form-group-value" id="no_telponValue">
                        @if($user->no_telpon)
                            <strong>{{ $user->no_telpon }}</strong>
                        @else
                            <span class="empty">Belum ditambahkan</span>
                        @endif
                    </div>
                    <div class="edit-form" id="no_telponForm">
                        <div class="form-input-group">
                            <label for="no_telponInput">No. Telpon</label>
                            <input
                                type="tel"
                                id="no_telponInput"
                                name="no_telpon"
                                value="{{ $user->no_telpon ?? '' }}"
                                placeholder="Contoh: 08123456789"
                                maxlength="20"
                            >
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="toggleEdit('no_telpon')">
                                <i class="fas fa-times"></i>
                                Batal
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-check"></i>
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <div class="form-group-header">
                        <span class="form-group-label">
                            <i class="fas fa-location-dot"></i>
                            Alamat
                        </span>
                        <button type="button" class="btn-edit" onclick="toggleEdit('alamat')">
                            <i class="fas fa-pen"></i>
                            Edit
                        </button>
                    </div>
                    <div class="form-group-value" id="alamatValue">
                        @if($user->alamat)
                            <strong>{{ $user->alamat }}</strong>
                        @else
                            <span class="empty">Belum ditambahkan</span>
                        @endif
                    </div>
                    <div class="edit-form" id="alamatForm">
                        <div class="form-input-group">
                            <label for="alamatInput">Alamat</label>
                            <textarea
                                id="alamatInput"
                                name="alamat"
                                placeholder="Masukkan alamat lengkap Anda"
                                maxlength="500"
                            >{{ $user->alamat ?? '' }}</textarea>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="toggleEdit('alamat')">
                                <i class="fas fa-times"></i>
                                Batal
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-check"></i>
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bottom Cards: Verifikasi Email & Ubah Password -->
        <div class="bottom-cards">
            <div class="card-small">
                <h3 style="margin-bottom:12px;">Verifikasi Email</h3>
                @if($user->email_verified_at)
                    <div style="display:flex;align-items:center;gap:12px;">
                        <span class="badge-verified">Terverifikasi</span>
                        <div style="color:var(--dark-gray);">Email Anda telah terverifikasi pada {{ \Carbon\Carbon::parse($user->email_verified_at)->translatedFormat('d F Y H:i') }}</div>
                    </div>
                @else
                    <p style="color:var(--dark-gray);margin-bottom:12px;">Email Anda: <strong>{{ $user->email }}</strong></p>
                    <div style="display:flex;gap:8px;align-items:center;margin-bottom:12px;">
                        <button type="button" class="btn-primary" id="sendOtpBtn" onclick="sendVerificationOtp()">Kirim OTP</button>
                        <button type="button" class="btn-secondary" id="resendOtpBtn" style="display:none;" onclick="sendVerificationOtp(true)">Kirim Ulang</button>
                    </div>

                    <div id="otpSection" style="display:none;margin-top:12px;">
                        <div class="form-input-group">
                            <label for="verifyOtpInput">Masukkan Kode OTP</label>
                            <input type="text" id="verifyOtpInput" maxlength="6" placeholder="6 digit kode OTP">
                        </div>
                        <div style="display:flex;gap:8px;margin-top:12px;justify-content:flex-end;">
                            <button type="button" class="btn-secondary" onclick="document.getElementById('verifyOtpInput').value='';">Batal</button>
                            <button type="button" class="btn-primary" onclick="verifyEmailOtp()">Verifikasi</button>
                        </div>
                    </div>
                @endif
            </div>

            <div class="card-small">
                <h3 style="margin-bottom:12px;">Ubah Password</h3>
                @if(session('status') === 'password-updated')
                    <div class="alert alert-success"><i class="fas fa-check-circle"></i> Kata sandi berhasil diperbarui.</div>
                @endif

                @if($errors->updatePassword->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong>Terjadi kesalahan!</strong>
                            <ul style="margin-top: 4px; margin-left: 20px;">
                                @foreach($errors->updatePassword->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-input-group">
                        <label for="current_password">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" placeholder="Masukkan password saat ini" required>
                    </div>

                    <div class="form-input-group">
                        <label for="password">Password Baru</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan password baru" required>
                    </div>

                    <div class="form-input-group">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi password baru" required>
                    </div>

                    <div style="display:flex;justify-content:flex-end;margin-top:12px;gap:8px;">
                        <button type="submit" class="btn-primary">Simpan Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle edit form
        function toggleEdit(field) {
            const form = document.getElementById(field + 'Form');
            if (form) {
                form.classList.toggle('active');
                if (form.classList.contains('active')) {
                    const input = form.querySelector('input, textarea');
                    if (input) {
                        setTimeout(() => input.focus(), 100);
                    }
                }
            }
        }

        // Preview photo before upload
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePhotoDisplay').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
                
                // Auto submit form when photo is selected
                setTimeout(() => {
                    document.getElementById('profileForm').submit();
                }, 300);
            }
        }

        // Form submission - all fields are validated server-side

        // Close alert after 5 seconds
        setTimeout(() => {
            const alert = document.getElementById('alertSuccess');
            if (alert) {
                alert.style.transition = 'opacity 0.3s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Escape to close edit forms
            if (e.key === 'Escape') {
                document.querySelectorAll('.edit-form.active').forEach(form => {
                    form.classList.remove('active');
                });
            }
        });

        // Email verification OTP
        const sendOtpUrl = "{{ route('email.send-otp') }}";
        const verifyOtpUrl = "{{ route('email.verify-otp') }}";

        function getCsrfToken() {
            const m = document.querySelector('meta[name="csrf-token"]');
            return m ? m.getAttribute('content') : '';
        }

        async function sendVerificationOtp(resend = false) {
            const sendBtn = document.getElementById('sendOtpBtn');
            const resendBtn = document.getElementById('resendOtpBtn');
            if (sendBtn) {
                sendBtn.disabled = true;
                sendBtn.textContent = 'Mengirim...';
            }

            try {
                const res = await fetch(sendOtpUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ resend })
                });

                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Gagal mengirim OTP');

                // show otp input
                const otpSection = document.getElementById('otpSection');
                if (otpSection) otpSection.style.display = 'block';
                if (resendBtn) resendBtn.style.display = 'inline-flex';
                alert(data.message || 'Kode OTP dikirim');
            } catch (err) {
                alert(err.message || 'Gagal mengirim OTP');
            } finally {
                if (sendBtn) {
                    sendBtn.disabled = false;
                    sendBtn.textContent = 'Kirim OTP';
                }
            }
        }

        async function verifyEmailOtp() {
            const input = document.getElementById('verifyOtpInput');
            if (!input) return;
            const otp = input.value.trim();
            if (otp.length !== 6) {
                alert('Masukkan kode OTP 6 digit');
                return;
            }

            try {
                const res = await fetch(verifyOtpUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ otp })
                });

                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Verifikasi gagal');

                alert(data.message || 'Email berhasil diverifikasi');
                // Reload to reflect verified badge
                window.location.reload();
            } catch (err) {
                alert(err.message || 'Verifikasi gagal');
            }
        }
    </script>
</body>
</html>
