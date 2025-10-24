<div>
<div>
    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengaduan.form') }}">Pengaduan</a></li>
                    <li class="breadcrumb-item active">Daftar Pengaduan</li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="page-header" data-aos="fade-up">
                <div class="container position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1>Daftar Pengaduan Masyarakat</h1>
                            <p>
                                Transparansi penanganan pengaduan untuk pelayanan publik yang lebih baik
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('pengaduan.form') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-plus-circle me-2"></i> Buat Pengaduan Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="stats-cards" data-aos="fade-up">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-number">{{ $statistics['total'] }}</div>
                    <div class="stat-label">Total Pengaduan</div>
                </div>

                <div class="stat-card info">
                    <div class="stat-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <div class="stat-number">{{ $statistics['baru'] }}</div>
                    <div class="stat-label">Pengaduan Baru</div>
                </div>

                <div class="stat-card warning">
                    <div class="stat-icon">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <div class="stat-number">{{ $statistics['proses'] }}</div>
                    <div class="stat-label">Dalam Proses</div>
                </div>

                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number">{{ $statistics['selesai'] }}</div>
                    <div class="stat-label">Selesai</div>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="filter-bar" data-aos="fade-up">
                <div class="filter-tabs">
                    <button wire:click="setFilterStatus('semua')" 
                            class="filter-tab {{ $filterStatus === 'semua' ? 'active' : '' }}">
                        <i class="fas fa-th-large me-1"></i> Semua
                    </button>
                    <button wire:click="setFilterStatus('baru')" 
                            class="filter-tab {{ $filterStatus === 'baru' ? 'active' : '' }}">
                        <i class="fas fa-inbox me-1"></i> Baru ({{ $statistics['baru'] }})
                    </button>
                    <button wire:click="setFilterStatus('proses')" 
                            class="filter-tab {{ $filterStatus === 'proses' ? 'active' : '' }}">
                        <i class="fas fa-spinner me-1"></i> Dalam Proses ({{ $statistics['proses'] }})
                    </button>
                    <button wire:click="setFilterStatus('selesai')" 
                            class="filter-tab {{ $filterStatus === 'selesai' ? 'active' : '' }}">
                        <i class="fas fa-check-circle me-1"></i> Selesai ({{ $statistics['selesai'] }})
                    </button>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" wire:model.live.debounce.500ms="search" 
                                   placeholder="Cari pengaduan..." />
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <select class="form-select" wire:model.live="sortBy">
                            <option value="terbaru">Terbaru</option>
                            <option value="terlama">Terlama</option>
                            <option value="populer">Paling Banyak Dilihat</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" wire:model.live="filterMonth">
                            <option value="">Semua Bulan</option>
                            <option value="10">Oktober 2025</option>
                            <option value="9">September 2025</option>
                            <option value="8">Agustus 2025</option>
                            <option value="7">Juli 2025</option>
                            <option value="6">Juni 2025</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Pengaduan List -->
            <div id="pengaduanList">
                @forelse($pengaduans as $index => $pengaduan)
                    <div class="pengaduan-card status-{{ $pengaduan->status }}" 
                         data-aos="fade-up" 
                         data-aos-delay="{{ $index * 100 }}">
                        <div class="pengaduan-header">
                            <div class="pengaduan-id">#PGD{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</div>
                            <span class="status-badge status-{{ $pengaduan->status }}">
                                @if($pengaduan->status === 'baru')
                                    Baru
                                @elseif($pengaduan->status === 'proses')
                                    Dalam Proses
                                @elseif($pengaduan->status === 'selesai')
                                    Selesai
                                @else
                                    {{ ucfirst($pengaduan->status) }}
                                @endif
                            </span>
                        </div>
                        <h4 class="pengaduan-title">{{ $pengaduan->pengaduan }}</h4>
                        <p class="pengaduan-excerpt">
                            {{ Str::limit($pengaduan->isi_pengaduan, 200) }}
                        </p>
                        <div class="pengaduan-meta">
                            <span><i class="fas fa-user"></i> {{ $pengaduan->nama }}</span>
                            <span>
                                <i class="fas fa-map-marker-alt"></i> 
                                {{ $pengaduan->desa->nama_desa ?? '-' }}, {{ $pengaduan->kecamatan->nama_kecamatan ?? '-' }}
                            </span>
                            <span>
                                <i class="fas fa-calendar"></i> 
                                {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengaduan)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('pengaduan.detail', $pengaduan->id) }}" class="btn-detail">
                                Lihat Detail <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="empty-state" data-aos="fade-up">
                        <i class="fas fa-inbox"></i>
                        <h4>Tidak Ada Pengaduan</h4>
                        <p>
                            @if($search)
                                Tidak ada pengaduan yang sesuai dengan pencarian "{{ $search }}"
                            @elseif($filterStatus !== 'semua')
                                Tidak ada pengaduan dengan status {{ $filterStatus }}
                            @else
                                Belum ada pengaduan yang masuk
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($pengaduans->hasPages())
                <div class="pagination-wrapper">
                    {{ $pengaduans->links() }}
                </div>
            @endif
        </div>
    </section>
</div>

</div>
