<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pelanggan - Three D Bakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-brown: #8B6F47;
            --light-brown: #C9A877;
            --cream: #F7F3E9;
            --white: #FFFFFF;
            --light-gray: #F8F9FA;
            --medium-gray: #E9ECEF;
            --dark-gray: #6C757D;
            --text-dark: #2D3748;
            --success: #10B981;
            --danger: #EF4444;
            --info: #3B82F6;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
            --border-radius-xl: 16px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--cream) 0%, #f0e9dd 100%);
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .header {
            background: var(--white);
            box-shadow: var(--shadow-md);
            border-radius: var(--border-radius-xl);
            padding: 20px 30px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-logo {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-brown) 0%, var(--light-brown) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 24px;
            font-weight: bold;
        }

        .brand-info h1 {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-brown);
            margin: 0;
        }

        .brand-info span {
            font-size: 12px;
            color: var(--dark-gray);
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--primary-brown) 0%, var(--light-brown) 100%);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .main-content {
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
        }

        .profile-card {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--primary-brown) 0%, var(--light-brown) 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .profile-photo-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid var(--white);
            object-fit: cover;
            background: var(--light-gray);
            box-shadow: var(--shadow-lg);
        }

        .profile-photo-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid var(--white);
            background: var(--medium-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            color: var(--dark-gray);
            box-shadow: var(--shadow-lg);
        }

        .profile-name {
            color: var(--white);
            font-size: 24px;
            font-weight: 700;
            margin-top: 10px;
        }

        .profile-status {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-top: 5px;
        }

        .profile-body {
            padding: 40px 30px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: #D1FAE5;
            color: #065F46;
            border: 1px solid var(--success);
        }

        .alert-error {
            background-color: #FEE2E2;
            color: #7F1D1D;
            border: 1px solid var(--danger);
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--medium-gray);
        }

        .form-section-title i {
            color: var(--primary-brown);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .form-label.required::after {
            content: '*';
            color: var(--danger);
        }

        .form-input,
        .form-textarea {
            padding: 12px 15px;
            border: 2px solid var(--medium-gray);
            border-radius: var(--border-radius);
            font-size: 14px;
            font-family: inherit;
            transition: var(--transition);
            background-color: var(--white);
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-brown);
            background-color: #FFFBF5;
            box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
            font-size: 14px;
        }

        .photo-upload-container {
            border: 2px dashed var(--medium-gray);
            border-radius: var(--border-radius);
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background-color: #FFFBF5;
        }

        .photo-upload-container:hover {
            border-color: var(--primary-brown);
            background-color: #FEF6F0;
        }

        .photo-upload-container input[type="file"] {
            display: none;
        }

        .photo-upload-label {
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .photo-upload-icon {
            font-size: 32px;
            color: var(--primary-brown);
        }

        .photo-upload-text {
            font-size: 14px;
            color: var(--text-dark);
        }

        .photo-upload-hint {
            font-size: 12px;
            color: var(--dark-gray);
            margin-top: 5px;
        }

        .photo-preview {
            margin-top: 15px;
            text-align: center;
        }

        .photo-preview img {
            max-width: 150px;
            max-height: 150px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid var(--medium-gray);
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: var(--border-radius);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            flex: 1;
            justify-content: center;
        }

        .btn-save {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: var(--white);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-cancel {
            background-color: var(--medium-gray);
            color: var(--text-dark);
        }

        .btn-cancel:hover {
            background-color: var(--dark-gray);
            color: var(--white);
        }

        .loading {
            display: none;
            font-size: 12px;
            color: var(--dark-gray);
            margin-top: 10px;
        }

        .loading.active {
            display: block;
        }

        .spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid var(--medium-gray);
            border-top-color: var(--primary-brown);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .error-message {
            color: var(--danger);
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container-wrapper {
                padding: 15px;
            }

            .header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .header-content {
                width: 100%;
                justify-content: center;
            }

            .header-actions {
                width: 100%;
                justify-content: center;
            }

            .profile-header {
                padding: 30px 20px;
            }

            .profile-body {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                flex: 1;
            }

            .profile-photo,
            .profile-photo-placeholder {
                width: 120px;
                height: 120px;
                border-width: 4px;
            }

            .profile-name {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="brand-logo">
                    <i class="fas fa-store"></i>
                </div>
                <div class="brand-info">
                    <h1>Three D Bakery</h1>
                    <span>Toko Roti Online Terpercaya</span>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('pelanggan.dashboard') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Success Alert -->
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ $message }}
                </div>
            @endif

            <!-- Error Alert -->
            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        Terdapat kesalahan dalam form:
                        <ul style="margin-left: 20px; margin-top: 5px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Profile Card -->
            <div class="profile-card">
                <!-- Profile Header with Photo -->
                <div class="profile-header">
                    <div class="profile-photo-section">
                        @if ($user->foto_profil)
                            <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" class="profile-photo">
                        @else
                            <div class="profile-photo-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        <div>
                            <div class="profile-name">{{ $pelanggan->nama }}</div>
                            <div class="profile-status">
                                <i class="fas fa-check-circle"></i> Pelanggan Aktif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Body with Form -->
                <div class="profile-body">
                    <form action="{{ route('pelanggan.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PATCH')

                        <!-- Photo Upload Section -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-image"></i>
                                Foto Profil
                            </div>
                            <div class="form-group">
                                <div class="photo-upload-container">
                                    <label class="photo-upload-label" for="foto_profil">
                                        <div class="photo-upload-icon">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>
                                        <div class="photo-upload-text">Klik atau drag foto untuk upload</div>
                                        <div class="photo-upload-hint">Format: JPG, PNG, GIF | Max: 2MB</div>
                                        <input type="file" id="foto_profil" name="foto_profil" accept="image/*" onchange="previewPhoto(this)">
                                    </label>
                                </div>
                                <div class="photo-preview" id="photoPreview"></div>
                                @error('foto_profil')
                                    <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Personal Information Section -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-user"></i>
                                Informasi Pribadi
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label required">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-input" placeholder="Masukkan nama lengkap" value="{{ old('nama', $pelanggan->nama) }}" required>
                                    @error('nama')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label required">Username</label>
                                    <input type="text" name="username" class="form-input" placeholder="Masukkan username" value="{{ old('username', $user->username) }}" required>
                                    @error('username')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row full">
                                <div class="form-group">
                                    <label class="form-label">Bio</label>
                                    <textarea name="bio" class="form-textarea" placeholder="Tulis bio singkat Anda...">{{ old('bio', $pelanggan->bio) }}</textarea>
                                    @error('bio')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-phone"></i>
                                Informasi Kontak
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label required">Email</label>
                                    <input type="email" name="email" class="form-input" placeholder="Masukkan email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label required">Nomor Telepon</label>
                                    <input type="tel" name="no_tlp" class="form-input" placeholder="Masukkan nomor telepon" value="{{ old('no_tlp', $pelanggan->no_tlp) }}" required>
                                    @error('no_tlp')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Address Section -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="fas fa-map-marker-alt"></i>
                                Alamat
                            </div>

                            <div class="form-row full">
                                <div class="form-group">
                                    <label class="form-label required">Alamat Lengkap</label>
                                    <textarea name="alamat" class="form-textarea" placeholder="Masukkan alamat lengkap..." required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-cancel">
                                <i class="fas fa-times"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-save" id="submitBtn">
                                <i class="fas fa-save"></i>
                                <span id="submitText">Simpan Perubahan</span>
                                <span class="loading" id="submitLoading">
                                    <span class="spinner"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Photo preview
        function previewPhoto(input) {
            const previewContainer = document.getElementById('photoPreview');
            previewContainer.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Form submission
        document.getElementById('profileForm').addEventListener('submit', function (e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitLoading = document.getElementById('submitLoading');

            submitBtn.disabled = true;
            submitText.style.display = 'none';
            submitLoading.classList.add('active');
        });

        // Drag and drop
        const photoUploadContainer = document.querySelector('.photo-upload-container');
        const fileInput = document.getElementById('foto_profil');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            photoUploadContainer.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            photoUploadContainer.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            photoUploadContainer.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            photoUploadContainer.style.borderColor = '#8B6F47';
            photoUploadContainer.style.backgroundColor = '#FEF6F0';
        }

        function unhighlight(e) {
            photoUploadContainer.style.borderColor = '#E9ECEF';
            photoUploadContainer.style.backgroundColor = '#FFFBF5';
        }

        photoUploadContainer.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;

            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }
    </script>
</body>
</html>
