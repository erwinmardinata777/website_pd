<div>
    <style>
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: white;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.6);
        }
    </style>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container position-relative">
            <h1 data-aos="fade-up">Hubungi Kami</h1>
            <p data-aos="fade-up" data-aos-delay="100">
                Kami siap membantu dan menjawab pertanyaan Anda
            </p>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Kontak</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Contact Info Cards -->
            <div class="contact-info-cards" data-aos="fade-up">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4>Alamat</h4>
                    <p>{{ $profil->alamat ?? 'Jl. Garuda No. 1, Sumbawa Besar, NTB' }}</p>
                </div>

                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h4>Telepon</h4>
                    <p>
                        <a href="tel:{{ $profil->telp }}">{{ $profil->telp ?? '(0371) 123456' }}</a>
                    </p>
                </div>

                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h4>Email</h4>
                    <p>
                        <a href="mailto:{{ $profil->email }}">{{ $profil->email ?? 'diskominfo@sumbawakab.go.id' }}</a>
                    </p>
                </div>

                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4>Jam Layanan</h4>
                    <p>Senin - Jumat<br>08:00 - 16:00 WITA</p>
                </div>
            </div>

            <div class="row mt-5">
                <!-- Contact Form -->
                <div class="col-lg-6 mb-4" data-aos="fade-up">
                    <div class="contact-form-card">
                        <div class="contact-form-header">
                            <i class="fas fa-paper-plane"></i>
                            <h3>Kirim Pesan</h3>
                            <p>Isi form di bawah untuk mengirim pesan kepada kami</p>
                        </div>

                        <form wire:submit.prevent="submit">
                            <div class="mb-4">
                                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nama') is-invalid @enderror"
                                       wire:model="nama" 
                                       placeholder="Masukkan nama lengkap Anda">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Email <span class="required">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror"
                                       wire:model="email" 
                                       placeholder="contoh@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" 
                                       class="form-control @error('telp') is-invalid @enderror"
                                       wire:model="telp" 
                                       placeholder="08xx xxxx xxxx">
                                @error('telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Subjek <span class="required">*</span></label>
                                <input type="text" 
                                       class="form-control @error('subjek') is-invalid @enderror"
                                       wire:model="subjek" 
                                       placeholder="Subjek pesan Anda">
                                @error('subjek')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Pesan <span class="required">*</span></label>
                                <textarea class="form-control @error('pesan') is-invalid @enderror"
                                          wire:model="pesan" 
                                          rows="6" 
                                          placeholder="Tulis pesan Anda di sini..."></textarea>
                                @error('pesan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="char-counter">
                                    {{ strlen($pesan ?? '') }} karakter
                                </div>
                            </div>

                            <button type="submit" 
                                    class="btn-submit w-100"
                                    wire:loading.attr="disabled"
                                    wire:target="submit">
                                <span wire:loading.remove wire:target="submit">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Pesan
                                </span>
                                <span wire:loading wire:target="submit">
                                    <i class="fas fa-spinner fa-spin me-2"></i> Mengirim...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Map & Social Media -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <!-- Google Maps -->
                    @if($profil && $profil->googlemap)
                    <div class="map-container">
                        <iframe src="{{ $profil->googlemap }}" 
                                width="100%" 
                                height="400" 
                                style="border:0; border-radius: 15px;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    @else
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.3947632825396!2d117.42088631478225!3d-8.488991793929677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcbf0c0e0000001%3A0x0!2zOMKwMjknMjAuNCJTIDExN8KwMjUnMjQuNyJF!5e0!3m2!1sid!2sid!4v1234567890" 
                                width="100%" 
                                height="400" 
                                style="border:0; border-radius: 15px;" 
                                allowfullscreen="" 
                                loading="lazy">
                        </iframe>
                    </div>
                    @endif

                    <!-- Social Media -->
                    <div class="social-media-card">
                        <h4><i class="fas fa-share-alt me-2"></i> Ikuti Kami</h4>
                        <p class="text-muted mb-4">Tetap terhubung dengan kami melalui media sosial</p>
                        <div class="social-links">
                            @if($profil && $profil->facebook)
                            <a href="{{ $profil->facebook }}" target="_blank" class="social-link facebook">
                                <i class="fab fa-facebook-f"></i>
                                <span>Facebook</span>
                            </a>
                            @endif

                            @if($profil && $profil->twitter)
                            <a href="{{ $profil->twitter }}" target="_blank" class="social-link twitter">
                                <i class="fab fa-twitter"></i>
                                <span>Twitter</span>
                            </a>
                            @endif

                            @if($profil && $profil->instagram)
                            <a href="{{ $profil->instagram }}" target="_blank" class="social-link instagram">
                                <i class="fab fa-instagram"></i>
                                <span>Instagram</span>
                            </a>
                            @endif

                            @if($profil && $profil->youtube)
                            <a href="{{ $profil->youtube }}" target="_blank" class="social-link youtube">
                                <i class="fab fa-youtube"></i>
                                <span>YouTube</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="quick-links-card">
                        <h4><i class="fas fa-link me-2"></i> Link Cepat</h4>
                        <ul class="quick-links-list">
                            <li><a href="{{ route('pengaduan.form') }}"><i class="fas fa-chevron-right"></i> Form Pengaduan</a></li>
                            <li><a href="{{ route('dokumen.index') }}"><i class="fas fa-chevron-right"></i> Dokumen Publik</a></li>
                            <li><a href="{{ route('galeri.index') }}"><i class="fas fa-chevron-right"></i> Galeri Foto & Video</a></li>
                            <li><a href="{{ url('/berita') }}"><i class="fas fa-chevron-right"></i> Berita & Artikel</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('pesanBerhasil', () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Pesan Terkirim!',
                    html: `
                        <div style="text-align: center; padding: 20px;">
                            <i class="fas fa-check-circle" style="font-size: 60px; color: #28a745; margin-bottom: 20px;"></i>
                            <p style="font-size: 16px; color: #666; margin-bottom: 15px;">
                                Terima kasih telah menghubungi kami. Pesan Anda telah kami terima dan akan segera kami proses.
                            </p>
                            <div style="background: #e8f5e9; padding: 15px; border-radius: 10px; margin-top: 20px;">
                                <p style="margin: 0; color: #2e7d32; font-weight: 600;">
                                    <i class="fas fa-clock me-2"></i>
                                    Kami akan menghubungi Anda dalam 1x24 jam
                                </p>
                            </div>
                        </div>
                    `,
                    confirmButtonText: '<i class="fas fa-check me-2"></i> OK',
                    confirmButtonColor: '#667eea',
                    width: 600
                });
            });

            Livewire.on('pesanGagal', (event) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengirim Pesan',
                    text: event.message,
                    confirmButtonColor: '#667eea'
                });
            });
        });
    </script>
    @endpush
</div>
