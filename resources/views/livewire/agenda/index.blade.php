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
            <h1 data-aos="fade-up">Agenda Kegiatan</h1>
            <p data-aos="fade-up" data-aos-delay="100">
                Jadwal kegiatan dan acara Diskominfo Kabupaten Sumbawa
            </p>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Agenda</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Statistics Cards -->
            <div class="stats-cards mb-5" data-aos="fade-up">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stat-number">{{ number_format($totalAgenda) }}</div>
                    <div class="stat-label">Total Agenda</div>
                </div>

                <div class="stat-card info">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-number">{{ number_format($upcomingCount) }}</div>
                    <div class="stat-label">Agenda Mendatang</div>
                </div>

                <div class="stat-card warning">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-number">{{ number_format($todayCount) }}</div>
                    <div class="stat-label">Hari Ini</div>
                </div>

                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <div class="stat-number">{{ number_format($thisMonthCount) }}</div>
                    <div class="stat-label">Bulan Ini</div>
                </div>
            </div>

            <!-- View Mode Tabs -->
            <div class="view-mode-tabs" data-aos="fade-up">
                <button wire:click="setViewMode('upcoming')" 
                        class="view-tab {{ $viewMode === 'upcoming' ? 'active' : '' }}">
                    <i class="fas fa-calendar-plus me-2"></i>
                    Mendatang ({{ $upcomingCount }})
                </button>
                <button wire:click="setViewMode('all')" 
                        class="view-tab {{ $viewMode === 'all' ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Semua Agenda
                </button>
                <button wire:click="setViewMode('past')" 
                        class="view-tab {{ $viewMode === 'past' ? 'active' : '' }}">
                    <i class="fas fa-calendar-check me-2"></i>
                    Sudah Lewat
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
                                   placeholder="Cari agenda..." />
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <select class="form-select" wire:model.live="filterMonth">
                            <option value="">Semua Bulan</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" wire:model.live="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="upcoming">Mendatang</option>
                            <option value="ongoing">Sedang Berlangsung</option>
                            <option value="completed">Selesai</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Agenda Grid -->
            <div class="agenda-grid" id="agendaGrid">
                @forelse($agendas as $index => $agenda)
                    @php
                        $tanggal = \Carbon\Carbon::parse($agenda->tanggal);
                        $isToday = $tanggal->isToday();
                        $isPast = $tanggal->isPast() && !$isToday;
                        $colors = [
                            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                            'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                            'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                            'linear-gradient(135deg, #30cfd0 0%, #330867 100%)',
                        ];
                        $color = $colors[$index % count($colors)];
                    @endphp

                    <div class="agenda-card {{ $isPast ? 'past-event' : '' }}" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                        <!-- Date Badge -->
                        <div class="agenda-date-badge" style="background: {{ $color }}">
                            <div class="date-day">{{ $tanggal->format('d') }}</div>
                            <div class="date-month">{{ $tanggal->translatedFormat('M') }}</div>
                            <div class="date-year">{{ $tanggal->format('Y') }}</div>
                        </div>

                        <!-- Status Badge -->
                        @if($isToday)
                        <div class="status-badge today">
                            <i class="fas fa-circle me-1"></i> Hari Ini
                        </div>
                        @elseif($isPast)
                        <div class="status-badge completed">
                            <i class="fas fa-check-circle me-1"></i> Selesai
                        </div>
                        @else
                        <div class="status-badge upcoming">
                            <i class="fas fa-clock me-1"></i> Mendatang
                        </div>
                        @endif

                        <!-- Image -->
                        @if($agenda->gambar)
                        <div class="agenda-image">
                            <img src="{{ Storage::url($agenda->gambar) }}" alt="{{ $agenda->agenda }}">
                        </div>
                        @endif

                        <!-- Content -->
                        <div class="agenda-content">
                            <h3 class="agenda-title">
                                <a href="{{ route('agenda.detail', $agenda->slug) }}">
                                    {{ $agenda->agenda }}
                                </a>
                            </h3>
                            
                            @if($agenda->deskripsi)
                            <p class="agenda-description">
                                {!! Str::limit($agenda->deskripsi, 120) !!}
                            </p>
                            @endif

                            <div class="agenda-meta">
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ substr($agenda->jam_mulai, 0, 5) }} - {{ substr($agenda->jam_selesai, 0, 5) }} WITA</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $agenda->tempat }}</span>
                                </div>
                            </div>

                            <a href="{{ route('agenda.detail', $agenda->slug) }}" class="btn-detail-agenda">
                                Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state" data-aos="fade-up">
                            <i class="fas fa-calendar-times"></i>
                            <h4>Tidak Ada Agenda</h4>
                            <p>
                                @if($search)
                                    Tidak ada agenda yang sesuai dengan pencarian "{{ $search }}"
                                @elseif($viewMode === 'upcoming')
                                    Belum ada agenda kegiatan mendatang
                                @elseif($viewMode === 'past')
                                    Belum ada agenda yang sudah lewat
                                @else
                                    Belum ada agenda yang tersedia
                                @endif
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($agendas->hasPages())
            <div class="pagination-wrapper">
                {{ $agendas->links() }}
            </div>
            @endif
        </div>
    </section>
</div>
