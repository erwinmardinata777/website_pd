<div x-data="{}" x-init="
    // Re-initialize Swiper and AOS on Livewire navigation
    document.addEventListener('livewire:navigated', () => {
        if (typeof AOS !== 'undefined') AOS.refreshHard();
        
        const swiperElement = document.getElementById('lowonganSwiper');
        if (swiperElement) {
            if (swiperElement.swiper) swiperElement.swiper.destroy(true, true);
            
            new Swiper('#lowonganSwiper', {
                loop: true,
                speed: 800,
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: '#lowonganSwiper .swiper-pagination', clickable: true, dynamicBullets: true },
                navigation: { nextEl: '#lowonganSwiper .swiper-button-next', prevEl: '#lowonganSwiper .swiper-button-prev' },
                effect: 'fade',
                fadeEffect: { crossFade: true }
            });
        }
    });

    // Initial load
    if (typeof AOS !== 'undefined') AOS.init({ duration: 1000, once: true, offset: 100 });
    const swiperElement = document.getElementById('lowonganSwiper');
    if (swiperElement) {
        new Swiper('#lowonganSwiper', {
            loop: true,
            speed: 800,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '#lowonganSwiper .swiper-pagination', clickable: true, dynamicBullets: true },
            navigation: { nextEl: '#lowonganSwiper .swiper-button-next', prevEl: '#lowonganSwiper .swiper-button-prev' },
            effect: 'fade',
            fadeEffect: { crossFade: true }
        });
    }
">
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
            <h1 data-aos="fade-up">{{ $lowongan->judul }}</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('lowongan-kerja.index') }}">Lowongan Kerja</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($lowongan->judul, 50) }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Lowongan Detail Card -->
                    <div class="lowongan-detail-card" data-aos="fade-up">
                        <!-- Gallery -->
                        @if($lowongan->fotoLowongans->count() > 0)
                        <div class="lowongan-detail-gallery">
                            @if($lowongan->fotoLowongans->count() > 1)
                            <!-- Multiple images - Use Swiper -->
                            <div class="swiper lowongan-swiper" id="lowonganSwiper">
                                <div class="swiper-wrapper">
                                    @foreach($lowongan->fotoLowongans as $foto)
                                    <div class="swiper-slide">
                                        <img src="{{ Storage::url($foto->foto) }}" alt="{{ $lowongan->judul }}">
                                    </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                            @else
                            <!-- Single image -->
                            <div class="single-image">
                                <img src="{{ Storage::url($lowongan->fotoLowongans->first()->foto) }}" alt="{{ $lowongan->judul }}">
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Content -->
                        <div class="lowongan-detail-content">
                            <h4><i class="fas fa-info-circle me-2 text-primary"></i> Deskripsi Pekerjaan</h4>
                            <div class="lowongan-description">
                                {!! $lowongan->deskripsi !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Info Card -->
                    <div class="lowongan-info-card" data-aos="fade-up">
                        <h4><i class="fas fa-clipboard-list me-2 text-primary"></i> Informasi Lowongan</h4>
                        <div class="lowongan-info-list">
                            <div class="lowongan-info-item">
                                <i class="fas fa-building"></i>
                                <div>
                                    <strong>Perusahaan</strong>
                                    <p>{{ $lowongan->nama_perusahaan }}</p>
                                </div>
                            </div>
                            <div class="lowongan-info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <strong>Lokasi</strong>
                                    <p>{{ $lowongan->alamat }}</p>
                                </div>
                            </div>
                            <div class="lowongan-info-item">
                                <i class="fas fa-calendar-alt"></i>
                                <div>
                                    <strong>Tanggal Posting</strong>
                                    <p>{{ \Carbon\Carbon::parse($lowongan->tanggal)->format('d F Y') }}</p>
                                </div>
                            </div>
                            <div class="lowongan-info-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <strong>Diposting</strong>
                                    <p>{{ \Carbon\Carbon::parse($lowongan->tanggal)->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Lowongan -->
                    @if($relatedLowongan->count() > 0)
                    <div class="related-lowongan-card" data-aos="fade-up" data-aos-delay="100">
                        <h4><i class="fas fa-briefcase me-2 text-primary"></i> Lowongan Lainnya</h4>
                        <div class="related-lowongan-list">
                            @foreach($relatedLowongan as $related)
                            <a wire:navigate href="{{ route('lowongan-kerja.detail', $related->id) }}" class="related-lowongan-item">
                                <div class="related-lowongan-thumb">
                                    @if($related->fotoLowongans->first())
                                    <img src="{{ Storage::url($related->fotoLowongans->first()->foto) }}" alt="{{ $related->judul }}">
                                    @else
                                    <div class="related-placeholder">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="related-lowongan-info">
                                    <h6>{{ Str::limit($related->judul, 45) }}</h6>
                                    <p>{{ $related->nama_perusahaan }}</p>
                                    <span class="related-date">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($related->tanggal)->diffForHumans() }}
                                    </span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Back Button -->
            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('lowongan-kerja.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Lowongan
                </a>
            </div>
        </div>
    </section>
</div>
