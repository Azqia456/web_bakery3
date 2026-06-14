@extends('layouts.pelanggan')

@push('styles')
<style>
{{-- Keep all existing profile-specific CSS variables and styles --}}
:root {
    --profile-primary: #8B6F47;
    --profile-light: #C9A877;
    --profile-cream: #F7F3E9;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container-wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    padding: 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--white);
    border-radius: var(--border-radius);
    padding: 16px 24px;
    margin-bottom: 24px;
    box-shadow: var(--shadow-sm);
}

.header-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-actions {
    display: flex;
    gap: 8px;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: var(--cream);
    border-radius: 8px;
    color: var(--primary-brown);
    font-weight: 500;
    text-decoration: none;
    font-size: 13px;
}

.main-content {
    flex: 1;
}

.alert {
    padding: 16px;
    border-radius: var(--border-radius);
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
}

.alert-success {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.alert-error {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.profile-card {
    background: var(--white);
    border-radius: var(--border-radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

.profile-header {
    background: linear-gradient(135deg, #6B4F3A 0%, #4b2f1c 100%);
    padding: 32px;
    color: var(--white);
}

.profile-photo-section {
    display: flex;
    align-items: center;
    gap: 20px;
}

.profile-photo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.3);
}

.profile-photo-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
}

.profile-name {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 4px;
}

.profile-status {
    font-size: 13px;
    opacity: 0.9;
}

.profile-body {
    padding: 32px;
}

.form-section {
    margin-bottom: 32px;
}

.form-section-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--cream);
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--primary-brown);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.form-group {
    margin-bottom: 16px;
}

.form-label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: var(--dark-gray);
    margin-bottom: 6px;
}

.form-label.required::after {
    content: '*';
    color: var(--danger);
    margin-left: 4px;
}

.form-input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid var(--medium-gray);
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    transition: var(--transition);
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-brown);
    box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
}

.form-input::placeholder {
    color: #adb5bd;
}

.error-message {
    color: var(--danger);
    font-size: 12px;
    margin-top: 4px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.photo-upload-container {
    border: 2px dashed var(--medium-gray);
    border-radius: var(--border-radius);
    padding: 32px;
    text-align: center;
    transition: var(--transition);
}

.photo-upload-container:hover {
    border-color: var(--primary-brown);
    background: rgba(139, 111, 71, 0.02);
}

.photo-upload-label {
    cursor: pointer;
}

.photo-upload-label input {
    display: none;
}

.photo-upload-icon {
    font-size: 36px;
    color: var(--primary-brown);
    margin-bottom: 12px;
}

.photo-upload-text {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 4px;
}

.photo-upload-hint {
    font-size: 12px;
    color: var(--dark-gray);
}

.photo-preview {
    margin-top: 16px;
}

.photo-preview img {
    max-width: 150px;
    border-radius: 8px;
    box-shadow: var(--shadow-sm);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 24px;
    border-top: 1px solid var(--medium-gray);
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    background: #4b2f1c;
    color: var(--white);
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
}

.btn-submit:hover {
    background: #3d2516;
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-cancel {
    display: inline-flex;
    align-items: center;
    padding: 10px 24px;
    background: var(--light-gray);
    color: var(--text-dark);
    border: 1px solid var(--medium-gray);
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
}

.spinner {
    display: none;
    width: 18px;
    height: 18px;
    border: 2px solid rgba(255,255,255,0.3);
    border-top-color: var(--white);
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

.spinner.active {
    display: inline-block;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

@media (max-width: 768px) {
    .header {
        flex-direction: column;
        gap: 12px;
        text-align: center;
    }
    .header-content {
        justify-content: center;
    }
    .form-row {
        grid-template-columns: 1fr;
    }
    .profile-body {
        padding: 20px;
    }
}
</style>
@endpush

@section('content')
    <div class="container-wrapper">
        <!-- Header -->
        {{-- <div class="header">
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
        </div> --}}

        <!-- Main Content -->
        <div class="main-content">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ $message }}
                </div>
            @endif

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

                <div class="profile-body">
                    <form action="{{ route('pelanggan.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PATCH')

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
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label required">Nomor Telepon</label>
                                    <input type="tel" name="no_tlp" class="form-input" placeholder="Masukkan nomor telepon" value="{{ old('no_tlp', $pelanggan->no_tlp) }}" required>
                                    @error('no_tlp')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-input" placeholder="Masukkan email" value="{{ old('email', $pelanggan->email) }}">
                                    @error('email')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label required">Alamat</label>
                                <input type="text" name="alamat" class="form-input" placeholder="Masukkan alamat lengkap" value="{{ old('alamat', $pelanggan->alamat) }}" required>
                                @error('alamat')
                                    <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Bio</label>
                                <textarea name="bio" class="form-input" rows="3" placeholder="Ceritakan sedikit tentang diri Anda">{{ old('bio', $pelanggan->bio) }}</textarea>
                                @error('bio')
                                    <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('pelanggan.dashboard') }}" class="btn-cancel">Batal</a>
                            <button type="submit" class="btn-submit" id="submitBtn">
                                <span class="spinner" id="submitLoading"></span>
                                <span id="submitText">Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
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

        document.getElementById('profileForm').addEventListener('submit', function (e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitLoading = document.getElementById('submitLoading');
            submitBtn.disabled = true;
            submitText.style.display = 'none';
            submitLoading.classList.add('active');
        });

        const photoUploadContainer = document.querySelector('.photo-upload-container');
        if (photoUploadContainer) {
            photoUploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#4b2f1c';
            });
            photoUploadContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = '';
            });
            photoUploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '';
                const input = document.getElementById('foto_profil');
                if (e.dataTransfer.files.length) {
                    input.files = e.dataTransfer.files;
                    previewPhoto(input);
                }
            });
        }
    </script>
@endpush
