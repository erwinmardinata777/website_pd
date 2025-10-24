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
            <h1 data-aos="fade-up">Struktur Organisasi</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Struktur Organisasi</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Statistics Cards -->
            <!-- <div class="stats-cards mb-5" data-aos="fade-up">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">{{ number_format($totalPegawai) }}</div>
                    <div class="stat-label">Total Pegawai</div>
                </div>

                <div class="stat-card info">
                    <div class="stat-icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <div class="stat-number">{{ number_format($totalBidang) }}</div>
                    <div class="stat-label">Total Bidang</div>
                </div>

                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-number">{{ number_format($pejabatStruktural) }}</div>
                    <div class="stat-label">Pejabat Struktural</div>
                </div>
            </div> -->

            <!-- View Mode Tabs -->
            <div class="view-mode-tabs" data-aos="fade-up">
                <button wire:click="setViewMode('grid')" 
                        class="view-tab {{ $viewMode === 'grid' ? 'active' : '' }}">
                    <i class="fas fa-th-large me-2"></i>
                    Tampilan Grid
                </button>
                <button wire:click="setViewMode('hierarchy')" 
                        class="view-tab {{ $viewMode === 'hierarchy' ? 'active' : '' }}">
                    <i class="fas fa-sitemap me-2"></i>
                    Tampilan Hierarki
                </button>
            </div>

            <!-- Filter Bar -->
            <div class="filter-bar" data-aos="fade-up">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" 
                                   wire:model.live.debounce.500ms="search" 
                                   placeholder="Cari pegawai (nama, jabatan, NIP)..." />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" wire:model.live="filterBidang">
                            <option value="">Semua Bidang</option>
                            @foreach($bidangs as $bidang)
                                <option value="{{ $bidang->id }}">
                                    {{ $bidang->nama_bidang }} ({{ $bidang->pegawais_count }} pegawai)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Grid View (4 Kolom) -->
            @if($viewMode === 'grid')
            <div class="staff-grid-simple" data-aos="fade-up">
                @forelse($allPegawais as $index => $pegawai)
                <div class="staff-card-simple" data-aos="fade-up" data-aos-delay="{{ $index * 30 }}">
                    <a href="{{ route('pegawai.detail', $pegawai->id) }}" style="text-decoration: none;">
                        <img src="{{ $pegawai->foto ? Storage::url($pegawai->foto) : asset('img/default-user.png') }}" 
                             alt="{{ $pegawai->nama }}" />
                        <h6>{{ $pegawai->nama }}</h6>
                        <p class="staff-position">{{ $pegawai->jabatan }}</p>
                        @if($pegawai->bidang)
                        <p class="staff-bidang">
                            <i class="fas fa-building me-1"></i>
                            {{ $pegawai->bidang->nama_bidang }}
                        </p>
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
                @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <h4>Tidak Ada Data</h4>
                        <p>
                            @if($search)
                                Tidak ada pegawai yang sesuai dengan pencarian "{{ $search }}"
                            @else
                                Belum ada data pegawai
                            @endif
                        </p>
                    </div>
                </div>
                @endforelse
            </div>
            @endif

            <!-- Hierarchy View -->
            @if($viewMode === 'hierarchy')
            <div class="org-chart-container" data-aos="fade-up">
                @forelse($pegawais as $pegawai)
                <div class="org-level-1">
                    <!-- Top Level -->
                    <div class="org-card kepala">
                        <a href="{{ route('pegawai.detail', $pegawai->id) }}" class="org-link">
                            <div class="org-photo">
                                <img src="{{ $pegawai->foto ? Storage::url($pegawai->foto) : asset('img/default-user.png') }}" 
                                     alt="{{ $pegawai->nama }}">
                            </div>
                            <div class="org-info">
                                <h4>{{ $pegawai->nama }}</h4>
                                <p class="org-position">{{ $pegawai->jabatan }}</p>
                                @if($pegawai->bidang)
                                <p class="org-bidang">{{ $pegawai->bidang->nama_bidang }}</p>
                                @endif
                                @if($pegawai->nip)
                                <p class="org-nip">NIP: {{ $pegawai->nip }}</p>
                                @endif
                            </div>
                        </a>
                    </div>

                    <!-- Level 2 - Bawahan -->
                    @if($pegawai->bawahan->count() > 0)
                    <div class="org-connector"></div>
                    <div class="org-level-2">
                        @foreach($pegawai->bawahan as $bawahan1)
                        <div class="org-branch">
                            <div class="org-card">
                                <a href="{{ route('pegawai.detail', $bawahan1->id) }}" class="org-link">
                                    <div class="org-photo">
                                        <img src="{{ $bawahan1->foto ? Storage::url($bawahan1->foto) : asset('img/default-user.png') }}" 
                                             alt="{{ $bawahan1->nama }}">
                                    </div>
                                    <div class="org-info">
                                        <h4>{{ $bawahan1->nama }}</h4>
                                        <p class="org-position">{{ $bawahan1->jabatan }}</p>
                                        @if($bawahan1->bidang)
                                        <p class="org-bidang">{{ $bawahan1->bidang->nama_bidang }}</p>
                                        @endif
                                    </div>
                                </a>
                            </div>

                            <!-- Level 3 - Sub Bawahan -->
                            @if($bawahan1->bawahan->count() > 0)
                            <div class="org-connector-small"></div>
                            <div class="org-level-3">
                                @foreach($bawahan1->bawahan as $bawahan2)
                                <div class="org-card-small">
                                    <a href="{{ route('pegawai.detail', $bawahan2->id) }}" class="org-link">
                                        <div class="org-photo-small">
                                            <img src="{{ $bawahan2->foto ? Storage::url($bawahan2->foto) : asset('img/default-user.png') }}" 
                                                 alt="{{ $bawahan2->nama }}">
                                        </div>
                                        <div class="org-info-small">
                                            <h5>{{ $bawahan2->nama }}</h5>
                                            <p>{{ $bawahan2->jabatan }}</p>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h4>Tidak Ada Data</h4>
                    <p>
                        @if($search)
                            Tidak ada pegawai yang sesuai dengan pencarian "{{ $search }}"
                        @else
                            Belum ada data pegawai
                        @endif
                    </p>
                </div>
                @endforelse
            </div>
            @endif
        </div>
    </section>
</div>
