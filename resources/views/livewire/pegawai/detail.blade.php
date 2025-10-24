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
            <h1 data-aos="fade-up">Profil Pegawai</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('struktur-organisasi.index') }}">Struktur Organisasi</a></li>
                    <li class="breadcrumb-item active">{{ $pegawai->nama }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="row">
                <!-- Profile Card -->
                <div class="col-lg-4">
                    <div class="profile-card" data-aos="fade-up">
                        <div class="profile-header">
                            <div class="profile-photo">
                                <img src="{{ $pegawai->foto ? Storage::url($pegawai->foto) : 'https://img.freepik.com/premium-vector/user-profile-icon-circle_1256048-12499.jpg?semt=ais_hybrid&w=740&q=80' }}" 
                                     alt="{{ $pegawai->nama }}"
                                     onerror="this.src='https://img.freepik.com/premium-vector/user-profile-icon-circle_1256048-12499.jpg?semt=ais_hybrid&w=740&q=80'">
                            </div>
                            <h3>{{ $pegawai->nama }}</h3>
                            <p class="profile-position">{{ $pegawai->jabatan }}</p>
                            @if($pegawai->bidang)
                            <p class="profile-bidang">
                                <i class="fas fa-building me-2"></i>
                                {{ $pegawai->bidang->nama_bidang }}
                            </p>
                            @endif
                        </div>

                        <!-- Quick Info -->
                        <div class="profile-quick-info">
                            @if($pegawai->nip)
                            <div class="quick-info-item">
                                <i class="fas fa-id-card"></i>
                                <div>
                                    <strong>NIP</strong>
                                    <p>{{ $pegawai->nip }}</p>
                                </div>
                            </div>
                            @endif

                            @if($pegawai->pangkat_golongan)
                            <div class="quick-info-item">
                                <i class="fas fa-award"></i>
                                <div>
                                    <strong>Pangkat/Golongan</strong>
                                    <p>{{ $pegawai->pangkat_golongan }}</p>
                                </div>
                            </div>
                            @endif

                            @if($pegawai->no_hp)
                            <div class="quick-info-item">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <strong>Telepon</strong>
                                    <p>{{ $pegawai->no_hp }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Social Media -->
                        @if($pegawai->facebook || $pegawai->instagram || $pegawai->twitter || $pegawai->youtube)
                        <div class="profile-social">
                            <h4><i class="fas fa-share-alt me-2"></i> Media Sosial</h4>
                            <div class="social-links-profile">
                                @if($pegawai->facebook)
                                <a href="{{ $pegawai->facebook }}" target="_blank" class="social-link-item facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                @endif
                                @if($pegawai->instagram)
                                <a href="{{ $pegawai->instagram }}" target="_blank" class="social-link-item instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                @endif
                                @if($pegawai->twitter)
                                <a href="{{ $pegawai->twitter }}" target="_blank" class="social-link-item twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                @endif
                                @if($pegawai->youtube)
                                <a href="{{ $pegawai->youtube }}" target="_blank" class="social-link-item youtube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="col-lg-8">
                    <!-- Personal Information -->
                    <div class="detail-card" data-aos="fade-up">
                        <h4><i class="fas fa-user me-2"></i> Informasi Pribadi</h4>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <strong>Tempat, Tanggal Lahir</strong>
                                <p>
                                    @if($pegawai->tempat_lahir && $pegawai->tanggal_lahir)
                                        {{ $pegawai->tempat_lahir }}, {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d F Y') }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>

                            <div class="detail-item">
                                <strong>Jenis Kelamin</strong>
                                <p>{{ $pegawai->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>

                            @if($pegawai->agama)
                            <div class="detail-item">
                                <strong>Agama</strong>
                                <p>{{ $pegawai->agama }}</p>
                            </div>
                            @endif

                            @if($pegawai->status_kawin)
                            <div class="detail-item">
                                <strong>Status Perkawinan</strong>
                                <p>{{ $pegawai->status_kawin }}</p>
                            </div>
                            @endif

                            @if($pegawai->alamat)
                            <div class="detail-item full-width">
                                <strong>Alamat</strong>
                                <p>{{ $pegawai->alamat }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="detail-card" data-aos="fade-up" data-aos-delay="100">
                        <h4><i class="fas fa-briefcase me-2"></i> Informasi Kepegawaian</h4>
                        <div class="detail-grid">
                            @if($pegawai->pendidikan_terakhir)
                            <div class="detail-item">
                                <strong>Pendidikan Terakhir</strong>
                                <p>{{ $pegawai->pendidikan_terakhir }}</p>
                            </div>
                            @endif

                            <div class="detail-item">
                                <strong>Jabatan</strong>
                                <p>{{ $pegawai->jabatan }}</p>
                            </div>

                            @if($pegawai->pangkat_golongan)
                            <div class="detail-item">
                                <strong>Pangkat/Golongan</strong>
                                <p>{{ $pegawai->pangkat_golongan }}</p>
                            </div>
                            @endif

                            @if($pegawai->nip)
                            <div class="detail-item">
                                <strong>NIP</strong>
                                <p>{{ $pegawai->nip }}</p>
                            </div>
                            @endif

                            @if($pegawai->bidang)
                            <div class="detail-item full-width">
                                <strong>Bidang</strong>
                                <p>{{ $pegawai->bidang->nama_bidang }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Organizational Structure -->
                    @if($pegawai->atasan || $pegawai->bawahan->count() > 0)
                    <div class="detail-card" data-aos="fade-up" data-aos-delay="200">
                        <h4><i class="fas fa-sitemap me-2"></i> Struktur Organisasi</h4>
                        
                        @if($pegawai->atasan)
                        <div class="org-relation">
                            <h5>Atasan Langsung</h5>
                            <a href="{{ route('pegawai.detail', $pegawai->atasan->id) }}" class="relation-card">
                                <div class="relation-photo">
                                    <img src="{{ $pegawai->atasan->foto ? Storage::url($pegawai->atasan->foto) : 'https://img.freepik.com/premium-vector/user-profile-icon-circle_1256048-12499.jpg?semt=ais_hybrid&w=740&q=80' }}" 
                                         alt="{{ $pegawai->atasan->nama }}"
                                         onerror="this.src='https://img.freepik.com/premium-vector/user-profile-icon-circle_1256048-12499.jpg?semt=ais_hybrid&w=740&q=80'">
                                </div>
                                <div class="relation-info">
                                    <h6>{{ $pegawai->atasan->nama }}</h6>
                                    <p>{{ $pegawai->atasan->jabatan }}</p>
                                </div>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                        @endif

                        @if($pegawai->bawahan->count() > 0)
                        <div class="org-relation">
                            <h5>Bawahan ({{ $pegawai->bawahan->count() }})</h5>
                            <div class="relation-grid">
                                @foreach($pegawai->bawahan as $bawahan)
                                <a href="{{ route('pegawai.detail', $bawahan->id) }}" class="relation-card-small">
                                    <div class="relation-photo-small">
                                        <img src="{{ $bawahan->foto ? Storage::url($bawahan->foto) : 'https://img.freepik.com/premium-vector/user-profile-icon-circle_1256048-12499.jpg?semt=ais_hybrid&w=740&q=80' }}" 
                                             alt="{{ $bawahan->nama }}"
                                             onerror="this.src='https://img.freepik.com/premium-vector/user-profile-icon-circle_1256048-12499.jpg?semt=ais_hybrid&w=740&q=80'">
                                    </div>
                                    <div class="relation-info-small">
                                        <h6>{{ $bawahan->nama }}</h6>
                                        <p>{{ $bawahan->jabatan }}</p>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Back Button -->
                    <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="300">
                        <a href="{{ route('struktur-organisasi.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Struktur Organisasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
