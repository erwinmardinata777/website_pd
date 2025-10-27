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
            <h1 data-aos="fade-up">Tugas & Fungsi</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Tugas & Fungsi</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            @if($tugasFungsi)
            <!-- Single Tugas Fungsi Card -->
            <div class="tf-single-card" data-aos="fade-up">
                <!-- Thumbnail -->
                @if($tugasFungsi->thumb)
                <div class="tf-single-thumb">
                    <img src="{{ Storage::url($tugasFungsi->thumb) }}" alt="{{ $tugasFungsi->judul }}">
                    <div class="tf-single-overlay">
                        <div class="tf-single-badge">
                            <i class="fas fa-clipboard-check me-2"></i>
                            Tugas & Fungsi
                        </div>
                    </div>
                </div>
                @endif

                <!-- Content -->
                <div class="tf-single-content">
                    <div class="tf-single-header">
                        <div class="tf-single-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div>
                            <h2>{{ $tugasFungsi->judul }}</h2>
                            <p class="tf-subtitle">{{ $profilWeb->nama }}</p>
                        </div>
                    </div>

                    <div class="tf-single-body">
                        {!! $tugasFungsi->isi !!}
                    </div>

                    <!-- Additional Info Card -->
                    <div class="tf-info-card-bottom">
                        <div class="tf-info-item">
                            <div class="tf-info-icon-bottom">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <h5>Komitmen</h5>
                                <p>Melaksanakan tugas dengan penuh tanggung jawab</p>
                            </div>
                        </div>
                        <div class="tf-info-item">
                            <div class="tf-info-icon-bottom">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div>
                                <h5>Kolaborasi</h5>
                                <p>Bekerja sama dengan seluruh stakeholder</p>
                            </div>
                        </div>
                        <div class="tf-info-item">
                            <div class="tf-info-icon-bottom">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <div>
                                <h5>Target</h5>
                                <p>Mencapai tujuan organisasi secara optimal</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <div class="tf-single-cta">
                        <a href="{{ route('kontak.index') }}" class="btn-cta-tf">
                            <i class="fas fa-phone-alt me-2"></i>
                            Hubungi Kami
                        </a>
                        <a href="{{ url('/') }}" class="btn-secondary-tf">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="empty-state" data-aos="fade-up">
                <i class="fas fa-clipboard-list"></i>
                <h4>Belum Ada Data</h4>
                <p>Tugas dan fungsi akan segera ditampilkan</p>
            </div>
            @endif
        </div>
    </section>
</div>
