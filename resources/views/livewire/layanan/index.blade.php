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
            <h1 data-aos="fade-up">Layanan Kami</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Layanan</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">

            <!-- Layanan Grid -->
            <div class="layanan-grid" id="layananGrid">
                @forelse($layanans as $index => $layanan)
                <div class="layanan-card" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <!-- Card Image -->
                    <div class="layanan-image">
                        @if($layanan->thumb)
                        <img src="{{ Storage::url($layanan->thumb) }}" alt="{{ $layanan->nama_layanan }}">
                        @else
                        <div class="layanan-placeholder">
                            <i class="{{ $layanan->icon ?? 'fas fa-concierge-bell' }}"></i>
                        </div>
                        @endif
                        <div class="layanan-overlay">
                            <a href="{{ route('layanan.detail', $layanan->slug) }}" class="btn-detail-layanan">
                                Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="layanan-content">
                        <div class="layanan-icon-small">
                            <i class="{{ $layanan->icon ?? 'fas fa-concierge-bell' }}"></i>
                        </div>
                        <h3 class="layanan-title">
                            <a href="{{ route('layanan.detail', $layanan->slug) }}">
                                {{ $layanan->nama_layanan }}
                            </a>
                        </h3>
                        <p class="layanan-description">
                            {{ Str::limit($layanan->deskripsi_singkat, 120) }}
                        </p>
                        <a href="{{ route('layanan.detail', $layanan->slug) }}" class="layanan-link">
                            Selengkapnya <i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="empty-state" data-aos="fade-up">
                        <i class="fas fa-concierge-bell"></i>
                        <h4>Tidak Ada Layanan</h4>
                        <p>
                            @if($search)
                                Tidak ada layanan yang sesuai dengan pencarian "{{ $search }}"
                            @else
                                Belum ada layanan yang tersedia
                            @endif
                        </p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($layanans->hasPages())
            <div class="pagination-wrapper">
                {{ $layanans->links() }}
            </div>
            @endif
        </div>
    </section>
</div>
