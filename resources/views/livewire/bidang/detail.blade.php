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
            <h1 data-aos="fade-up">{{ $bidang->nama_bidang }}</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bidang.index') }}">Bidang</a></li>
                    <li class="breadcrumb-item active">{{ $bidang->nama_bidang }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Bidang Info Card -->
            <div class="bidang-detail-header" data-aos="fade-up">
                @if($bidang->thumb)
                <div class="bidang-detail-image">
                    <img src="{{ Storage::url($bidang->thumb) }}" alt="{{ $bidang->nama_bidang }}">
                </div>
                @endif
                <div class="bidang-detail-info">
                    <div class="bidang-detail-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <h2>{{ $bidang->nama_bidang }}</h2>
                        <div class="bidang-detail-meta">
                            <span class="meta-item">
                                <i class="fas fa-users me-2"></i>
                                {{ $bidang->pegawais->count() }} Pegawai
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($bidang->deskripsi)
            <div class="bidang-description-card" data-aos="fade-up" data-aos-delay="100">
                <h4><i class="fas fa-info-circle me-2"></i> Deskripsi</h4>
                <p>{!! $bidang->deskripsi !!}</p>
            </div>
            @endif

            <!-- Pegawai List -->
            <div class="bidang-pegawai-section" data-aos="fade-up" data-aos-delay="200">
                <h3 class="section-title-bidang">
                    <i class="fas fa-users me-2"></i>
                    Pegawai di {{ $bidang->nama_bidang }}
                    <span class="count-badge">{{ $bidang->pegawais->count() }}</span>
                </h3>

                @if($bidang->pegawais->count() > 0)
                <div class="staff-grid-simple">
                    @foreach($bidang->pegawais as $index => $pegawai)
                    <div class="staff-card-simple" data-aos="fade-up" data-aos-delay="{{ $index * 30 }}">
                        <a href="{{ route('pegawai.detail', $pegawai->id) }}" style="text-decoration: none;">
                            <img src="{{ $pegawai->foto ? Storage::url($pegawai->foto) : 'https://img.freepik.com/premium-vector/user-profile-icon-circle_1256048-12499.jpg?semt=ais_hybrid&w=740&q=80' }}" 
                                 alt="{{ $pegawai->nama }}"
                                 onerror="this.src='https://img.freepik.com/premium-vector/user-profile-icon-circle_1256048-12499.jpg?semt=ais_hybrid&w=740&q=80'" />
                            <h6>{{ $pegawai->nama }}</h6>
                            <p class="staff-position">{{ $pegawai->jabatan }}</p>
                            @if($pegawai->nip)
                            <p class="staff-nip">NIP: {{ $pegawai->nip }}</p>
                            @endif
                        </a>
                        
                        @if($pegawai->facebook || $pegawai->instagram || $pegawai->twitter || $pegawai->youtube)
                        <div class="social-links">
                            @if($pegawai->facebook)
                            <a href="{{ $pegawai->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if($pegawai->twitter)
                            <a href="{{ $pegawai->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                            @endif
                            @if($pegawai->instagram)
                            <a href="{{ $pegawai->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
                            @endif
                            @if($pegawai->youtube)
                            <a href="{{ $pegawai->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h4>Belum Ada Pegawai</h4>
                    <p>Belum ada pegawai yang terdaftar di bidang ini</p>
                </div>
                @endif
            </div>

            <!-- Back Button -->
            <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('bidang.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Bidang
                </a>
            </div>
        </div>
    </section>
</div>
