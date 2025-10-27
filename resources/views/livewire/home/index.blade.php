<div>
    <!-- Hero Slider dengan Swiper.js -->
    <section id="beranda">
      <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
          @forelse ($sliders as $slider)
            <div
              class="swiper-slide"
              style="background-image: url('{{ asset('storage/' . $slider->gambar) }}');"
            >
              <div class="slide-content text-center text-white d-flex flex-column justify-content-center align-items-center h-100">
                <h2 data-aos="fade-up">{{ $slider->judul }}</h2>
                @if ($slider->link)
                  <a
                    href="{{ $slider->link }}"
                    target="_blank"
                    class="btn btn-light btn-lg mt-3"
                    data-aos="fade-up"
                    data-aos-delay="200"
                  >
                    <i class="fas fa-arrow-right me-2"></i> Selengkapnya
                  </a>
                @endif
              </div>
            </div>
          @empty
            <div class="swiper-slide" style="background-color: #ccc;">
              <div class="slide-content text-center text-dark p-5">
                <h2>Tidak ada data slider</h2>
              </div>
            </div>
          @endforelse
        </div>

        <!-- Navigation Buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

        <!-- Pagination -->
        <div class="swiper-pagination"></div>
      </div>
    </section>

    <!-- Layanan Section -->
    <section id="layanan" class="section-padding bg-light">
      <div class="container">
        <div class="section-title text-center mb-5" data-aos="fade-up">
          <h2>Layanan Kami</h2>
          <p class="text-muted mt-3">
            Berbagai layanan digital untuk kemudahan masyarakat
          </p>
        </div>

        <div class="row g-4 justify-content-center">
          @php
            // Warna latar ikon bisa diganti sesuka kamu (otomatis berganti)
            $colors = [
                'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                'linear-gradient(135deg, #30cfd0 0%, #330867 100%)',
                'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                'linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%)',
                'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
                'linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%)',
                'linear-gradient(135deg, #fccb90 0%, #d57eeb 100%)',
                'linear-gradient(135deg, #5ee7df 0%, #b490ca 100%)',
            ];
          @endphp

          @forelse ($layanans as $index => $layanan)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
              <div class="layanan-card text-center p-4 bg-white shadow-sm rounded-4 h-100">
                <div
                  class="layanan-icon mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle"
                  style="
                    width: 80px;
                    height: 80px;
                    background: {{ $colors[$index % count($colors)] }};
                    color: #fff;
                    font-size: 2rem;
                  "
                >
                  <i class="{{ $layanan->icon }}"></i>
                </div>
                <h4 class="mt-3">{{ $layanan->nama_layanan }}</h4>
                <p class="text-muted">
                  {{ Str::limit($layanan->deskripsi_singkat, 100) }}
                </p>
                @if ($layanan->slug)
                  <a href="{{ url('layanan/' . $layanan->slug) }}" class="btn btn-sm btn-outline-primary mt-2">
                    Akses Layanan →
                  </a>
                @endif
              </div>
            </div>
          @empty
            <div class="text-center py-5">
              <p class="text-muted">Belum ada data layanan tersedia.</p>
            </div>
          @endforelse
        </div>
      </div>
    </section>

    <!-- Profil Perangkat Daerah -->
    <section id="profil" class="profil-section">
      <div class="container">
        <div class="section-title" data-aos="fade-up">
          <h2>Profil Perangkat Daerah</h2>
        </div>

        <div class="row align-items-center">
          <div class="col-lg-6" data-aos="fade-right">
            <div class="profil-img">
              <img
                src="{{ optional($profil)->bg ? Storage::url($profil->bg) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&h=400&fit=crop' }}"
                alt="Profil"
              />
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-left">
            <div class="profil-content">
              <h3 class="mb-4" style="color: #1e3c72; font-weight: 700">
                {{ optional($profil)->nama ?? 'Nama Perangkat Daerah' }}
              </h3>

              <p class="text-muted">
                {!! Str::limit(strip_tags(optional($profil)->deskripsi_full ?? 'Deskripsi tidak tersedia'), 500) !!}
              </p> 

              <a href="{{ url('tentang-kami') }}" class="btn btn-primary mt-3">
                <i class="fas fa-info-circle me-2"></i> Selengkapnya
              </a>
            </div>
          </div>
        </div>

        <!-- Struktur Organisasi dengan Swiper -->
        <div class="mt-5 justify-content-center">
          <h3 class="text-center mb-4" style="color: #1e3c72; font-weight: 700">
            Struktur Organisasi
          </h3>

          <div class="swiper staff-swiper">
            <div class="swiper-wrapper">
              @foreach ($pegawais as $pegawai)
              <div class="swiper-slide">
                <div class="staff-card text-center">
                  <img
                    src="{{ $pegawai->foto ? Storage::url($pegawai->foto) : 'https://img.freepik.com/premium-vector/user-profile-icon-circle_1256048-12499.jpg?semt=ais_hybrid&w=740&q=80' }}"
                    alt="{{ $pegawai->nama }}"
                    onerror="this.src='https://img.freepik.com/premium-vector/user-profile-icon-circle_1256048-12499.jpg?semt=ais_hybrid&w=740&q=80'"
                  />
                  <h6>
                    <a href="{{ route('pegawai.detail', $pegawai->id) }}" class="text-decoration-none text-dark" style="font-size: 16px;">
                      {{ $pegawai->nama }}
                    </a>
                  </h6>
                  <p class="text-muted" style="font-size: 14px;">{{ $pegawai->jabatan }}</p>
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
                </div>
              </div>
              @endforeach
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
          </div>
        </div>

      </div>
    </section>

    <!-- Pengaduan & Agenda Section -->
    <section id="info-publik" class="info-section">
      <div class="container">
        <div class="section-title" data-aos="fade-up">
          <h2>Informasi Publik</h2>
          <p class="text-muted mt-3">
            Pengaduan masyarakat dan agenda kegiatan terkini
          </p>
        </div>

        <div class="row g-4">
          <!-- Pengaduan Masyarakat -->
          <div class="col-lg-6">
            <div class="info-card" data-aos="fade-up" data-aos-delay="0">
              <h4>
                <i class="fas fa-bullhorn"></i>
                Pengaduan Masyarakat
              </h4>

              <!-- Stats -->
              <div class="stats-grid">
                <div class="stat-box">
                  <h3>{{ $totalPengaduan }}</h3>
                  <p>Total Pengaduan</p>
                </div>
                <div class="stat-box green">
                  <h3>{{ $pengaduanSelesai }}</h3>
                  <p>Terselesaikan</p>
                </div>
                <div class="stat-box orange">
                  <h3>{{ $pengaduanProses }}</h3>
                  <p>Dalam Proses</p>
                </div>
                <div class="stat-box blue">
                  <h3>{{ $pengaduanBaru }}</h3>
                  <p>Pengaduan Baru</p>
                </div>
              </div>

              <!-- Recent Complaints -->
              <h6 class="mb-3" style="font-weight: 600; color: #666">
                Pengaduan Terbaru
              </h6>
              <div class="pengaduan-list">
                @forelse($pengaduanTerbaru as $p)
                  <div class="pengaduan-list-item">
                    <div class="header">
                      <h6>
                        <a href="{{ route('pengaduan.detail', $p->id) }}" class="text-decoration-none text-dark">
                          {{ $p->pengaduan }}
                        </a>
                      </h6>
                      @if($p->status == 2)
                        <span class="badge-pengaduan badge-selesai">Selesai</span>
                      @elseif($p->status == 1)
                        <span class="badge-pengaduan badge-proses">Proses</span>
                      @else
                        <span class="badge-pengaduan badge-baru">Baru</span>
                      @endif
                    </div>
                    <div class="meta">
                      <span><i class="fas fa-user"></i> {{ $p->nama }}</span>
                      <span><i class="fas fa-map-marker-alt"></i> {{ $p->kode_kecamatan }}</span>
                      <span><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($p->tanggal_pengaduan)->format('d M Y') }}</span>
                    </div>
                  </div>
                @empty
                  <p class="text-muted">Belum ada pengaduan.</p>
                @endforelse
              </div>

              <!-- Action Buttons -->
              <div class="mt-4 d-grid gap-2">
                <a href="{{ route('pengaduan.form') }}" class="quick-action-btn">
                  <i class="fas fa-plus-circle"></i> Buat Pengaduan Baru
                </a>
                <a href="{{ route('pengaduan.list') }}" class="btn-link-custom justify-content-center">
                  Lihat Semua Pengaduan <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Agenda Kegiatan -->
          <div class="col-lg-6">
            <div class="info-card" data-aos="fade-up" data-aos-delay="100">
              <h4>
                <i class="fas fa-calendar-alt"></i>
                Agenda Kegiatan
              </h4>

              <!-- Calendar Info -->
              <div
                class="mb-3 p-3"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                      border-radius: 12px; color: white;">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h5 class="mb-0" style="font-weight: 700">
                      {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </h5>
                    <small style="opacity: 0.9">
                      {{ $agendas->count() }} Kegiatan Terjadwal
                    </small>
                  </div>
                  <div class="text-end">
                    <i class="fas fa-calendar-check" style="font-size: 36px; opacity: 0.3"></i>
                  </div>
                </div>
              </div>

              <!-- Upcoming Events -->
              <h6 class="mb-3" style="font-weight: 600; color: #666">
                Agenda Mendatang
              </h6>

              <div class="agenda-list">
                @forelse ($agendas as $index => $agenda)
                  @php
                    $colors = [
                      'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                      'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                      'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                      'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                      'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                      'linear-gradient(135deg, #30cfd0 0%, #330867 100%)',
                    ];
                    $color = $colors[$index % count($colors)];
                    $tanggal = \Carbon\Carbon::parse($agenda->tanggal);
                  @endphp

                  <div class="agenda-list-item">
                    <div class="agenda-date-mini" style="background: {{ $color }}">
                      <div class="day">{{ $tanggal->format('d') }}</div>
                      <div class="month">{{ $tanggal->translatedFormat('M') }}</div>
                    </div>

                    <div class="agenda-info">
                      <h6>{{ $agenda->agenda }}</h6>
                      <div class="meta">
                        <span>
                          <i class="fas fa-clock"></i>
                          {{ $agenda->jam_mulai }} - {{ $agenda->jam_selesai }}
                        </span>
                        <span>
                          <i class="fas fa-map-marker-alt"></i> {{ $agenda->tempat }}
                        </span>
                      </div>
                    </div>
                  </div>
                @empty
                  <p class="text-muted">Belum ada agenda kegiatan.</p>
                @endforelse
              </div>

              <!-- Action Buttons -->
              <div class="mt-4 d-grid gap-2">
                <a href="{{ url('agenda') }}" class="btn-link-custom justify-content-center">
                  Lihat Semua Agenda <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Berita Section -->
    <section id="berita" class="section-padding">
      <div class="container">
        <div class="section-title text-center mb-5" data-aos="fade-up">
          <h2>Berita Terkini</h2>
          <p class="text-muted mt-3">Informasi dan berita terbaru dari kami</p>
        </div>

        <div class="row g-4 justify-content-center">
          @forelse ($beritas as $index => $berita)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
              <div class="berita-card bg-white shadow-sm rounded-4 overflow-hidden h-100 d-flex flex-column">
                <div class="berita-img">
                  <img
                    src="{{ asset('storage/' . $berita->thumb) }}"
                    alt="{{ $berita->judul }}"
                    class="w-100"
                    style="height: 200px; object-fit: cover;"
                  />
                </div>
                <div class="berita-content p-3 flex-fill d-flex flex-column justify-content-between">
                  <div>
                    <div class="berita-date text-muted mb-2">
                      <i class="far fa-calendar me-1"></i>
                      {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
                    </div>
                    <h5 class="fw-bold mb-2">{{ $berita->judul }}</h5>
                    <p class="text-muted">
                      {{ Str::limit(strip_tags($berita->deskripsi ?? $berita->isi), 100) }}
                    </p>
                  </div>
                  <div>
                    <a href="{{ url('berita/' . $berita->slug) }}" class="btn-read-more mt-2 d-inline-block">
                      Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="text-center py-5">
              <p class="text-muted">Belum ada berita tersedia.</p>
            </div>
          @endforelse
        </div>

        <div class="text-center mt-5">
          <a href="{{ url('/berita') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-newspaper me-2"></i> Lihat Semua Berita
          </a>
        </div>
      </div>
    </section>

    <!-- Galeri Foto & Video Section -->
    <section id="galeri" class="galeri-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Galeri Media</h2>
                <p class="text-muted mt-3">
                    Dokumentasi kegiatan dan aktivitas Diskominfo Kabupaten Sumbawa
                </p>
            </div>

            <!-- Tabs -->
            <div class="galeri-tabs" data-aos="fade-up">
                <button class="galeri-tab active" data-tab="foto">
                    <i class="fas fa-images"></i> Foto
                </button>
                <button class="galeri-tab" data-tab="video">
                    <i class="fas fa-video"></i> Video
                </button>
            </div>

            <!-- Photo Gallery -->
            <div class="photo-grid active" id="photoGallery" data-aos="fade-up">
                @forelse($kategoriFotos as $kategori)
                    @if($kategori->fotos->first())
                    <div class="photo-item" onclick="openLightbox('{{ Storage::url($kategori->fotos->first()->gambar) }}')">
                        <img src="{{ Storage::url($kategori->fotos->first()->gambar) }}" 
                            alt="{{ $kategori->nama_kategori }}" />
                        <div class="zoom-icon">
                            <i class="fas fa-search-plus"></i>
                        </div>
                        <div class="photo-overlay">
                            <h6>
                                <a href="{{ route('galeri.foto.detail', $kategori->slug) }}" 
                                  style="color: white; text-decoration: none;"
                                  onclick="event.stopPropagation();">
                                    {{ $kategori->nama_kategori }}
                                </a>
                            </h6>
                            <div class="meta">
                                <span>
                                    <i class="fas fa-calendar"></i> 
                                    {{ \Carbon\Carbon::parse($kategori->tanggal)->format('d M Y') }}
                                </span>
                                <span>
                                    <i class="fas fa-eye"></i> 
                                    {{ number_format($kategori->hits) }} views
                                </span>
                                <span>
                                    <i class="fas fa-images"></i> 
                                    {{ $kategori->fotos->count() }} foto
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-images" style="font-size: 80px; color: #e0e0e0;"></i>
                        <p class="mt-3 text-muted">Belum ada foto tersedia</p>
                    </div>
                @endforelse
            </div>

            <!-- Video Gallery -->
            <div class="video-grid" id="videoGallery" data-aos="fade-up">
                @forelse($videos as $video)
                <div class="video-item">
                    <div class="video-thumbnail" onclick="playVideo('{{ $video->url }}', '{{ addslashes($video->judul) }}')">
                        @php
                            // Extract video ID from YouTube URL
                            $videoId = null;
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $video->url, $matches)) {
                                $videoId = $matches[1];
                            }
                        @endphp
                        
                        @if($videoId)
                            <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" 
                                alt="{{ $video->judul }}"
                                onerror="this.src='https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg'" />
                        @else
                            <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=400&h=250&fit=crop" 
                                alt="{{ $video->judul }}" />
                        @endif
                        
                        <div class="play-button">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <div class="video-info">
                        <h6>{{ $video->judul }}</h6>
                        <div class="video-meta">
                            <span>
                                <i class="fas fa-calendar"></i> 
                                {{ \Carbon\Carbon::parse($video->tanggal)->format('d M Y') }}
                            </span>
                            <span>
                                <i class="fas fa-eye"></i> 
                                {{ number_format($video->hits) }} views
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-video" style="font-size: 80px; color: #e0e0e0;"></i>
                        <p class="mt-3 text-muted">Belum ada video tersedia</p>
                    </div>
                @endforelse
            </div>

            <!-- Load More Button -->
            @if($kategoriFotos->count() >= 9 || $videos->count() >= 6)
            <div class="load-more-btn">
                <a href="{{ route('galeri.index') }}" class="btn" style="background: none; border: none; color: inherit;">
                    <i class="fas fa-images me-2"></i> Lihat Semua Galeri
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div class="lightbox-modal" id="lightboxModal">
        <div class="lightbox-close" onclick="closeLightbox()">
            <i class="fas fa-times"></i>
        </div>
        <div class="lightbox-content">
            <img src="" alt="Lightbox Image" id="lightboxImage" />
        </div>
    </div>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" style="background: #000; border: none; border-radius: 15px; overflow: hidden;">
                <div class="modal-header" style="border: none; padding: 15px 20px; background: rgba(0,0,0,0.5);">
                    <h5 class="modal-title" style="color: white; font-weight: 600;" id="videoModalLabel"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 0;">
                    <div class="ratio ratio-16x9">
                        <iframe id="videoIframe" src="" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Lightbox Functions
        function openLightbox(imageSrc) {
            const lightbox = document.getElementById('lightboxModal');
            const lightboxImage = document.getElementById('lightboxImage');
            lightboxImage.src = imageSrc;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightboxModal');
            lightbox.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close lightbox on background click
        document.getElementById('lightboxModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        // Close lightbox with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });

        // Play Video Function
        function playVideo(url, title) {
            console.log('Playing video:', url, title);
            
            // Convert YouTube URL to embed URL
            let embedUrl = url;
            
            try {
                // Handle different YouTube URL formats
                if (url.includes('youtube.com/watch?v=')) {
                    const videoId = url.split('v=')[1].split('&')[0];
                    embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
                } else if (url.includes('youtu.be/')) {
                    const videoId = url.split('youtu.be/')[1].split('?')[0];
                    embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
                } else if (url.includes('youtube.com/embed/')) {
                    embedUrl = url.includes('?') ? url + '&autoplay=1' : url + '?autoplay=1';
                }
                
                console.log('Embed URL:', embedUrl);
                
                // Set modal content
                document.getElementById('videoModalLabel').textContent = title;
                document.getElementById('videoIframe').src = embedUrl;
                
                // Show modal using Bootstrap 5
                const modalElement = document.getElementById('videoModal');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
                
                // Clear iframe when modal is hidden
                modalElement.addEventListener('hidden.bs.modal', function () {
                    document.getElementById('videoIframe').src = '';
                }, { once: true });
                
            } catch (error) {
                console.error('Error playing video:', error);
                alert('Gagal memutar video. Silakan coba lagi.');
            }
        }

        // Gallery Tabs
        document.addEventListener('DOMContentLoaded', function() {
            const galeriTabs = document.querySelectorAll('.galeri-tab');
            const photoGallery = document.getElementById('photoGallery');
            const videoGallery = document.getElementById('videoGallery');

            galeriTabs.forEach((tab) => {
                tab.addEventListener('click', function () {
                    // Remove active class from all tabs
                    galeriTabs.forEach((t) => t.classList.remove('active'));
                    this.classList.add('active');

                    const tabType = this.getAttribute('data-tab');

                    // Toggle galleries
                    if (tabType === 'foto') {
                        photoGallery.style.display = 'grid';
                        photoGallery.classList.add('active');
                        videoGallery.style.display = 'none';
                        videoGallery.classList.remove('active');
                    } else {
                        photoGallery.style.display = 'none';
                        photoGallery.classList.remove('active');
                        videoGallery.style.display = 'grid';
                        videoGallery.classList.add('active');
                    }
                });
            });
        });
    </script>

    <!-- Link Terkait -->
    <section class="section-padding bg-light">
      <div class="container">
        <div class="section-title" data-aos="fade-up">
          <h2>Link Terkait</h2>
          <p class="text-muted mt-3">Tautan website instansi terkait</p>
        </div>

        <div class="row g-4 justify-content-center">
          @forelse($links as $index => $item)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6"
                data-aos="zoom-in"
                data-aos-delay="{{ $index * 50 }}">
              @if(!empty($item->link))
                <a href="{{ $item->link }}" target="_blank" class="link-card">
              @else
                <div class="link-card">
              @endif

                  <img
                    src="{{ asset('storage/' . $item->thumb) }}"
                    alt="{{ $item->judul }}"
                    class="img-fluid rounded-circle mb-2"
                  />
                  <p>{{ $item->judul }}</p>

              @if(!empty($item->link))
                </a>
              @else
                </div>
              @endif
            </div>
          @empty
            <div class="text-center">
              <p class="text-muted">Belum ada link terkait yang tersedia.</p>
            </div>
          @endforelse
        </div>
      </div>
    </section>

</div>
