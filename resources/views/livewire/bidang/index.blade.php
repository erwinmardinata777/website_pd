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
            <h1 data-aos="fade-up">Bidang</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Bidang</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Statistics Cards -->
            <div class="bidang-stats" data-aos="fade-up">
                <div class="bidang-stat-card">
                    <div class="bidang-stat-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="bidang-stat-info">
                        <h3>{{ number_format($totalBidang) }}</h3>
                        <p>Total Bidang</p>
                    </div>
                </div>
                <div class="bidang-stat-card">
                    <div class="bidang-stat-icon success">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="bidang-stat-info">
                        <h3>{{ number_format($totalPegawai) }}</h3>
                        <p>Pegawai Terdistribusi</p>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="bidang-search" data-aos="fade-up">
                <div class="search-box-bidang">
                    <i class="fas fa-search"></i>
                    <input type="text" 
                           wire:model.live.debounce.500ms="search" 
                           placeholder="Cari bidang..." />
                </div>
            </div>

            <!-- Bidang Grid -->
            <div class="bidang-grid" data-aos="fade-up">
                @forelse($bidangs as $index => $bidang)
                <div class="bidang-card" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <div class="bidang-image">
                        @if($bidang->thumb)
                        <img src="{{ Storage::url($bidang->thumb) }}" alt="{{ $bidang->nama_bidang }}">
                        @else
                        <div class="bidang-placeholder">
                            <i class="fas fa-building"></i>
                        </div>
                        @endif
                        <div class="bidang-overlay">
                            <div class="bidang-badge">
                                <i class="fas fa-users me-2"></i>
                                {{ $bidang->pegawais_count }} Pegawai
                            </div>
                        </div>
                    </div>
                    <div class="bidang-content">
                        <h4>{{ $bidang->nama_bidang }}</h4>
                        <p>{{ Str::limit($bidang->deskripsi ?? 'Deskripsi bidang belum tersedia', 100) }}</p>
                        <a href="{{ route('bidang.detail', $bidang->id) }}" class="btn-bidang-detail">
                            <i class="fas fa-arrow-right me-2"></i>
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-building"></i>
                        <h4>Tidak Ada Data</h4>
                        <p>
                            @if($search)
                                Tidak ada bidang yang sesuai dengan pencarian "{{ $search }}"
                            @else
                                Belum ada data bidang
                            @endif
                        </p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
