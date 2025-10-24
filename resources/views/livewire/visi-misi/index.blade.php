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
            <h1 data-aos="fade-up">Visi & Misi</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Visi & Misi</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Visi Section -->
            @if($visi)
            <div class="visi-section" data-aos="fade-up">
                <div class="visi-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h2 class="section-title-vm">Visi</h2>
                <div class="visi-content">
                    <div class="quote-mark-top">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p>{!! $visi->visi !!}</p>
                    <div class="quote-mark-bottom">
                        <i class="fas fa-quote-right"></i>
                    </div>
                </div>
            </div>
            @else
            <div class="empty-state" data-aos="fade-up">
                <i class="fas fa-eye"></i>
                <h4>Visi Belum Tersedia</h4>
                <p>Visi organisasi akan segera ditampilkan</p>
            </div>
            @endif

            <!-- Misi Section -->
            <div class="misi-section" data-aos="fade-up" data-aos-delay="100">
                <div class="misi-header">
                    <div class="misi-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h2 class="section-title-vm">Misi</h2>
                </div>

                @if($misis->count() > 0)
                <div class="misi-grid">
                    @foreach($misis as $index => $misi)
                    <div class="misi-card" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                        <div class="misi-number">
                            <span>{{ $index + 1 }}</span>
                        </div>
                        <div class="misi-content-card">
                            <h4>{{ $misi->judul }}</h4>
                            <p>{{ $misi->deskripsi }}</p>
                        </div>
                        <div class="misi-decoration">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state" data-aos="fade-up">
                    <i class="fas fa-bullseye"></i>
                    <h4>Misi Belum Tersedia</h4>
                    <p>Misi organisasi akan segera ditampilkan</p>
                </div>
                @endif
            </div>

            <!-- Values Section (Optional) -->
            <div class="values-section" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-center mb-4">
                    <i class="fas fa-star me-2"></i>
                    Nilai-Nilai Kami
                </h3>
                <div class="values-grid">
                    <div class="value-card" data-aos="zoom-in" data-aos-delay="250">
                        <div class="value-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>Integritas</h5>
                        <p>Menjunjung tinggi kejujuran dan etika dalam setiap tindakan</p>
                    </div>

                    <div class="value-card" data-aos="zoom-in" data-aos-delay="300">
                        <div class="value-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5>Kolaborasi</h5>
                        <p>Bekerja sama untuk mencapai tujuan bersama</p>
                    </div>

                    <div class="value-card" data-aos="zoom-in" data-aos-delay="350">
                        <div class="value-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h5>Inovasi</h5>
                        <p>Mendorong kreativitas dan solusi yang berkelanjutan</p>
                    </div>

                    <div class="value-card" data-aos="zoom-in" data-aos-delay="400">
                        <div class="value-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h5>Profesional</h5>
                        <p>Memberikan pelayanan terbaik dengan standar tinggi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
