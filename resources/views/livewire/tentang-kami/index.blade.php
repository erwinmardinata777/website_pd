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
            <h1 data-aos="fade-up">Tentang Kami</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Tentang Kami</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            @if($profil)
            <!-- About Card -->
            <div class="about-card" data-aos="fade-up">
                <!-- Background Image Section -->
                @if($profil->bg)
                <div class="about-image-section">
                    <div class="about-image-container">
                        <img src="{{ Storage::url($profil->bg) }}" alt="{{ $profil->nama }}">
                        <div class="about-image-overlay">
                            <div class="about-badge">
                                <i class="fas fa-building me-2"></i>
                                {{ $profil->nama ?? 'Dinas Komunikasi dan Informatika' }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Content Section -->
                <div class="about-content-section">
                    <div class="row">
                        <!-- Main Content -->
                        <div class="col-lg-8">
                            <div class="about-main-content">
                                <div class="about-header">
                                    <div class="about-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div>
                                        <h2>{{ $profil->nama ?? 'Dinas Komunikasi dan Informatika' }}</h2>
                                        <p class="about-subtitle">Kabupaten Sumbawa, Nusa Tenggara Barat</p>
                                    </div>
                                </div>

                                <div class="about-description">
                                    @if($profil->deskripsi_full)
                                        {!! $profil->deskripsi_full !!}
                                    @else
                                        <p>Informasi tentang {{ $profil->nama ?? 'instansi kami' }} akan segera ditampilkan.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Info -->
                        <div class="col-lg-4">
                            <!-- Contact Info Box -->
                            <div class="about-info-box" data-aos="fade-up" data-aos-delay="100">
                                <h4><i class="fas fa-address-card me-2"></i> Informasi Kontak</h4>
                                <div class="about-info-list">
                                    @if($profil->alamat)
                                    <div class="about-info-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <div>
                                            <strong>Alamat</strong>
                                            <p>{{ $profil->alamat }}</p>
                                        </div>
                                    </div>
                                    @endif

                                    @if($profil->telp)
                                    <div class="about-info-item">
                                        <i class="fas fa-phone"></i>
                                        <div>
                                            <strong>Telepon</strong>
                                            <p><a href="tel:{{ $profil->telp }}">{{ $profil->telp }}</a></p>
                                        </div>
                                    </div>
                                    @endif

                                    @if($profil->email)
                                    <div class="about-info-item">
                                        <i class="fas fa-envelope"></i>
                                        <div>
                                            <strong>Email</strong>
                                            <p><a href="mailto:{{ $profil->email }}">{{ $profil->email }}</a></p>
                                        </div>
                                    </div>
                                    @endif

                                    @if($profil->url)
                                    <div class="about-info-item">
                                        <i class="fas fa-globe"></i>
                                        <div>
                                            <strong>Website</strong>
                                            <p><a href="{{ $profil->url }}" target="_blank">{{ $profil->url }}</a></p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Social Media Box -->
                            @if($profil->facebook || $profil->twitter || $profil->instagram || $profil->youtube)
                            <div class="about-social-box" data-aos="fade-up" data-aos-delay="200">
                                <h4><i class="fas fa-share-alt me-2"></i> Media Sosial</h4>
                                <div class="about-social-links">
                                    @if($profil->facebook)
                                    <a href="{{ $profil->facebook }}" target="_blank" class="about-social-link facebook">
                                        <i class="fab fa-facebook-f"></i>
                                        <span>Facebook</span>
                                    </a>
                                    @endif

                                    @if($profil->twitter)
                                    <a href="{{ $profil->twitter }}" target="_blank" class="about-social-link twitter">
                                        <i class="fab fa-twitter"></i>
                                        <span>Twitter</span>
                                    </a>
                                    @endif

                                    @if($profil->instagram)
                                    <a href="{{ $profil->instagram }}" target="_blank" class="about-social-link instagram">
                                        <i class="fab fa-instagram"></i>
                                        <span>Instagram</span>
                                    </a>
                                    @endif

                                    @if($profil->youtube)
                                    <a href="{{ $profil->youtube }}" target="_blank" class="about-social-link youtube">
                                        <i class="fab fa-youtube"></i>
                                        <span>YouTube</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Quick Links Box -->
                            <div class="about-links-box" data-aos="fade-up" data-aos-delay="300">
                                <h4><i class="fas fa-link me-2"></i> Link Cepat</h4>
                                <div class="about-quick-links">
                                    <a href="{{ route('visi-misi.index') }}"><i class="fas fa-eye"></i> Visi & Misi</a>
                                    <a href="{{ route('tugas-fungsi.index') }}"><i class="fas fa-tasks"></i> Tugas & Fungsi</a>
                                    <a href="{{ route('struktur-organisasi.index') }}"><i class="fas fa-sitemap"></i> Struktur Organisasi</a>
                                    <a href="{{ route('kontak.index') }}"><i class="fas fa-envelope"></i> Hubungi Kami</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="about-stats-section" data-aos="fade-up" data-aos-delay="100">
                <div class="about-stat-card">
                    <div class="about-stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>100K+</h3>
                    <p>Masyarakat Terlayani</p>
                </div>
                <div class="about-stat-card">
                    <div class="about-stat-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>50+</h3>
                    <p>Aplikasi Digital</p>
                </div>
                <div class="about-stat-card">
                    <div class="about-stat-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>10+</h3>
                    <p>Penghargaan</p>
                </div>
                <div class="about-stat-card">
                    <div class="about-stat-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>25+</h3>
                    <p>Kemitraan</p>
                </div>
            </div>

            @else
            <div class="empty-state" data-aos="fade-up">
                <i class="fas fa-info-circle"></i>
                <h4>Informasi Belum Tersedia</h4>
                <p>Informasi tentang kami akan segera ditampilkan</p>
            </div>
            @endif
        </div>
    </section>
</div>
