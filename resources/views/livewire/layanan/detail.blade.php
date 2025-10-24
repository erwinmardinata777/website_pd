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
            <h1 data-aos="fade-up">{{ $layanan->nama_layanan }}</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('layanan.index') }}">Layanan</a></li>
                    <li class="breadcrumb-item active">{{ $layanan->nama_layanan }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Layanan Detail Card -->
                    <div class="layanan-detail-card" data-aos="fade-up">
                        <!-- Featured Image -->
                        @if($layanan->thumb)
                        <div class="layanan-featured-image">
                            <img src="{{ Storage::url($layanan->thumb) }}" alt="{{ $layanan->nama_layanan }}">
                            <div class="layanan-badge">
                                <i class="{{ $layanan->icon ?? 'fas fa-concierge-bell' }} me-2"></i>
                                Layanan Unggulan
                            </div>
                        </div>
                        @endif

                        <!-- Content -->
                        <div class="layanan-detail-content">
                            <!-- Icon & Title -->
                            <div class="detail-header">
                                <div class="detail-icon">
                                    <i class="{{ $layanan->icon ?? 'fas fa-concierge-bell' }}"></i>
                                </div>
                                <div>
                                    <h2>{{ $layanan->nama_layanan }}</h2>
                                    @if($layanan->deskripsi_singkat)
                                    <p class="detail-subtitle">{{ $layanan->deskripsi_singkat }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Full Description -->
                            <div class="detail-description">
                                {!! $layanan->deskripsi_full ?? $layanan->deskripsi_singkat !!}
                            </div>

                            <!-- Features/Benefits -->
                            <div class="detail-features">
                                <h3><i class="fas fa-check-circle me-2"></i> Keunggulan Layanan</h3>
                                <div class="features-grid">
                                    <div class="feature-item">
                                        <i class="fas fa-bolt"></i>
                                        <div>
                                            <h5>Proses Cepat</h5>
                                            <p>Pelayanan yang efisien dan cepat</p>
                                        </div>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-shield-alt"></i>
                                        <div>
                                            <h5>Aman & Terpercaya</h5>
                                            <p>Data dijamin aman dan terlindungi</p>
                                        </div>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-headset"></i>
                                        <div>
                                            <h5>Dukungan 24/7</h5>
                                            <p>Siap membantu kapan saja</p>
                                        </div>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-mobile-alt"></i>
                                        <div>
                                            <h5>Akses Mudah</h5>
                                            <p>Dapat diakses dimana saja</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Button -->
                            <div class="detail-cta">
                                <a href="{{ route('kontak.index') }}" class="btn-cta-primary">
                                    <i class="fas fa-comment-alt me-2"></i>
                                    Hubungi Kami
                                </a>
                                <a href="{{ route('layanan.index') }}" class="btn-cta-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali ke Layanan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Info Box -->
                    <div class="info-box-layanan" data-aos="fade-up">
                        <h4><i class="fas fa-info-circle me-2"></i> Informasi Layanan</h4>
                        <div class="info-list">
                            <div class="info-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <strong>Jam Operasional</strong>
                                    <p>Senin - Jumat, 08:00 - 16:00 WITA</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <strong>Lokasi</strong>
                                    <p>Kantor {{ $profilWeb->nama }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <strong>Kontak</strong>
                                    <p>{{ $profilWeb->telp }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <strong>Email</strong>
                                    <p>{{ $profilWeb->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Layanan Terkait -->
                    @if($layananTerkait->count() > 0)
                    <div class="related-layanan-box" data-aos="fade-up" data-aos-delay="100">
                        <h4><i class="fas fa-th-large me-2"></i> Layanan Lainnya</h4>
                        <div class="related-list">
                            @foreach($layananTerkait as $terkait)
                            <a href="{{ route('layanan.detail', $terkait->slug) }}" class="related-item">
                                <div class="related-icon">
                                    <i class="{{ $terkait->icon ?? 'fas fa-concierge-bell' }}"></i>
                                </div>
                                <div class="related-info">
                                    <h5>{{ $terkait->nama_layanan }}</h5>
                                    <p>{{ Str::limit($terkait->deskripsi_singkat, 60) }}</p>
                                </div>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Help Box -->
                    <div class="help-box" data-aos="fade-up" data-aos-delay="200">
                        <div class="help-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h4>Butuh Bantuan?</h4>
                        <p>Tim kami siap membantu Anda dalam menggunakan layanan ini</p>
                        <a href="{{ route('kontak.index') }}" class="btn-help">
                            <i class="fas fa-headset me-2"></i>
                            Hubungi Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
