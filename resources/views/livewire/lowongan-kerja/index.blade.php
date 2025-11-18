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
            <h1 data-aos="fade-up">Lowongan Kerja</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Lowongan Kerja</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Statistics Cards -->
            <div class="lowongan-stats-grid" data-aos="fade-up">
                <div class="lowongan-stat-card">
                    <div class="lowongan-stat-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="lowongan-stat-info">
                        <h3>{{ number_format($totalLowongan) }}</h3>
                        <p>Total Lowongan</p>
                    </div>
                </div>
                <div class="lowongan-stat-card success">
                    <div class="lowongan-stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="lowongan-stat-info">
                        <h3>{{ number_format($lowonganBulanIni) }}</h3>
                        <p>Lowongan Bulan Ini</p>
                    </div>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <div class="lowongan-filter-section" data-aos="fade-up">
                <div class="row align-items-center">
                    <!-- Search Box -->
                    <div class="col-lg-6 mb-3 mb-lg-0">
                        <div class="search-box-lowongan">
                            <i class="fas fa-search"></i>
                            <input type="text" 
                                   wire:model.live.debounce.500ms="search" 
                                   placeholder="Cari lowongan (judul, perusahaan, lokasi)..." />
                            @if($search)
                            <button class="clear-search" wire:click="clearSearch">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                        </div>
                        @if($search)
                        <small class="text-muted ms-2">
                            <i class="fas fa-info-circle"></i> 
                            Hasil pencarian untuk: <strong>"{{ $search }}"</strong>
                        </small>
                        @endif
                    </div>

                    <!-- Sort & Per Page -->
                    <div class="col-lg-6">
                        <div class="filter-controls">
                            <!-- Sort By -->
                            <div class="filter-item">
                                <label>
                                    <i class="fas fa-sort-amount-down"></i> Urutkan:
                                </label>
                                <select class="form-select" wire:model.live="sortBy">
                                    <option value="latest">Terbaru</option>
                                    <option value="oldest">Terlama</option>
                                </select>
                            </div>

                            <!-- Per Page -->
                            <div class="filter-item">
                                <label>
                                    <i class="fas fa-th"></i> Tampilkan:
                                </label>
                                <select class="form-select" wire:model.live="perPage">
                                    <option value="6">6 Lowongan</option>
                                    <option value="9">9 Lowongan</option>
                                    <option value="12">12 Lowongan</option>
                                    <option value="15">15 Lowongan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Info -->
            @if($lowonganKerjas->total() > 0)
            <div class="results-info" data-aos="fade-up">
                <p>
                    Menampilkan <strong>{{ $lowonganKerjas->firstItem() }}</strong> 
                    sampai <strong>{{ $lowonganKerjas->lastItem() }}</strong> 
                    dari <strong>{{ $lowonganKerjas->total() }}</strong> lowongan
                </p>
            </div>
            @endif

            <!-- Loading State -->
            <div wire:loading.delay class="text-center my-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Memuat data...</p>
            </div>

            <!-- Lowongan Grid -->
            <div class="lowongan-grid" wire:loading.remove data-aos="fade-up">
                @forelse($lowonganKerjas as $index => $lowongan)
                <div class="lowongan-card-list" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 50 }}">
                    <div class="lowongan-image-list">
                        @if($lowongan->fotoLowongans->first())
                        <img src="{{ Storage::url($lowongan->fotoLowongans->first()->foto) }}" 
                             alt="{{ $lowongan->judul }}">
                        @else
                        <div class="lowongan-placeholder-list">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        @endif
                        <div class="lowongan-date-badge">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($lowongan->tanggal)->format('d M Y') }}
                        </div>
                    </div>
                    <div class="lowongan-content-list">
                        <div class="lowongan-company-tag">
                            <i class="fas fa-building me-2"></i>
                            {{ $lowongan->nama_perusahaan }}
                        </div>
                        <h4>
                            <a href="{{ route('lowongan-kerja.detail', $lowongan->id) }}" 
                               class="text-decoration-none text-dark">
                                {{ $lowongan->judul }}
                            </a>
                        </h4>
                        <p class="lowongan-location">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $lowongan->alamat }}
                        </p>
                        <p class="lowongan-desc">
                            {{ Str::limit(strip_tags($lowongan->deskripsi), 150) }}
                        </p>
                        <div class="lowongan-meta">
                            <span class="meta-posted">
                                <i class="fas fa-clock me-1"></i>
                                Diposting {{ \Carbon\Carbon::parse($lowongan->tanggal)->diffForHumans() }}
                            </span>
                        </div>
                        <a href="{{ route('lowongan-kerja.detail', $lowongan->id) }}" 
                           class="btn-lowongan-detail">
                            <i class="fas fa-arrow-right me-2"></i>
                            Lihat Detail Lowongan
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-briefcase"></i>
                        <h4>Tidak Ada Lowongan</h4>
                        <p>
                            @if($search)
                                Tidak ada lowongan yang sesuai dengan pencarian "<strong>{{ $search }}</strong>"
                            @else
                                Belum ada lowongan kerja yang tersedia saat ini
                            @endif
                        </p>
                        @if($search)
                        <button wire:click="clearSearch" class="btn btn-primary mt-3">
                            <i class="fas fa-redo me-2"></i> Reset Pencarian
                        </button>
                        @endif
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($lowonganKerjas->hasPages())
            <div class="mt-5" data-aos="fade-up">
                <div class="d-flex justify-content-center">
                    {{ $lowonganKerjas->links() }}
                </div>
            </div>
            @endif
        </div>
    </section>
</div>