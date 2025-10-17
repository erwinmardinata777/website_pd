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
                src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&h=400&fit=crop"
                alt="Profil"
              />
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-left">
            <div class="profil-content">
              <h3 class="mb-4" style="color: #1e3c72; font-weight: 700">
                Dinas Komunikasi dan Informatika
              </h3>

              <h5 style="color: #2a5298; font-weight: 600">Visi</h5>
              <p style="color: #555; line-height: 1.8">
                "Terwujudnya Teknologi Informasi dan Komunikasi yang Inovatif
                untuk Mendukung Kabupaten Sumbawa yang Maju, Sejahtera, dan
                Berdaya Saing"
              </p>

              <h5 class="mt-4" style="color: #2a5298; font-weight: 600">
                Misi
              </h5>
              <ul style="color: #555; line-height: 1.8">
                <li>
                  Meningkatkan infrastruktur teknologi informasi dan komunikasi
                </li>
                <li>Mengembangkan sistem e-government yang terintegrasi</li>
                <li>Meningkatkan literasi digital masyarakat</li>
                <li>Mewujudkan transparansi dan akuntabilitas pemerintahan</li>
                <li>Mendorong inovasi digital untuk pelayanan publik</li>
              </ul>

              <a href="#" class="btn btn-primary mt-3">
                <i class="fas fa-info-circle me-2"></i> Selengkapnya
              </a>
            </div>
          </div>
        </div>

        <!-- Struktur Organisasi dengan Swiper (Bisa Digeser) -->
        <div class="mt-5">
          <h3 class="text-center mb-4" style="color: #1e3c72; font-weight: 700">
            Struktur Organisasi
          </h3>

          <div class="swiper staff-swiper">
            <div class="swiper-wrapper">
              <!-- Staff 1 -->
              <div class="swiper-slide">
                <div class="staff-card">
                  <img
                    src="https://randomuser.me/api/portraits/men/32.jpg"
                    alt="Kepala Dinas"
                  />
                  <h6>Drs. Ahmad Yani, M.Si</h6>
                  <p class="text-muted">Kepala Dinas</p>
                  <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                  </div>
                </div>
              </div>

              <!-- Staff 2 -->
              <div class="swiper-slide">
                <div class="staff-card">
                  <img
                    src="https://randomuser.me/api/portraits/men/45.jpg"
                    alt="Sekretaris"
                  />
                  <h6>H. Budi Santoso, S.Kom</h6>
                  <p class="text-muted">Sekretaris</p>
                  <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                  </div>
                </div>
              </div>

              <!-- Staff 3 -->
              <div class="swiper-slide">
                <div class="staff-card">
                  <img
                    src="https://randomuser.me/api/portraits/women/44.jpg"
                    alt="Kabid"
                  />
                  <h6>Sri Wahyuni, S.T, M.T</h6>
                  <p class="text-muted">Kabid E-Government</p>
                  <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                  </div>
                </div>
              </div>

              <!-- Staff 4 -->
              <div class="swiper-slide">
                <div class="staff-card">
                  <img
                    src="https://randomuser.me/api/portraits/men/52.jpg"
                    alt="Kabid"
                  />
                  <h6>Ir. Muhammad Ridwan</h6>
                  <p class="text-muted">Kabid Infrastruktur TIK</p>
                  <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                  </div>
                </div>
              </div>

              <!-- Staff 5 -->
              <div class="swiper-slide">
                <div class="staff-card">
                  <img
                    src="https://randomuser.me/api/portraits/women/65.jpg"
                    alt="Kabid"
                  />
                  <h6>Dra. Siti Nurhaliza, M.Kom</h6>
                  <p class="text-muted">Kabid Aplikasi Informatika</p>
                  <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                  </div>
                </div>
              </div>

              <!-- Staff 6 -->
              <div class="swiper-slide">
                <div class="staff-card">
                  <img
                    src="https://randomuser.me/api/portraits/men/68.jpg"
                    alt="Kabid"
                  />
                  <h6>Agus Supriyanto, S.Sos</h6>
                  <p class="text-muted">Kabid Komunikasi Publik</p>
                  <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <!-- Pagination -->
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
                  <h3>248</h3>
                  <p>Total Pengaduan</p>
                </div>
                <div class="stat-box green">
                  <h3>187</h3>
                  <p>Terselesaikan</p>
                </div>
                <div class="stat-box orange">
                  <h3>45</h3>
                  <p>Dalam Proses</p>
                </div>
                <div class="stat-box blue">
                  <h3>16</h3>
                  <p>Pengaduan Baru</p>
                </div>
              </div>

              <!-- Recent Complaints -->
              <h6 class="mb-3" style="font-weight: 600; color: #666">
                Pengaduan Terbaru
              </h6>
              <div class="pengaduan-list">
                <div class="pengaduan-list-item">
                  <div class="header">
                    <h6>Jalan Rusak di Kecamatan Sumbawa</h6>
                    <span class="badge-pengaduan badge-proses">Proses</span>
                  </div>
                  <div class="meta">
                    <span><i class="fas fa-user"></i> Ahmad Rizki</span>
                    <span><i class="fas fa-map-marker-alt"></i> Sumbawa</span>
                    <span><i class="fas fa-calendar"></i> 14 Okt 2025</span>
                  </div>
                </div>

                <div class="pengaduan-list-item">
                  <div class="header">
                    <h6>Pelayanan Administrasi Lambat</h6>
                    <span class="badge-pengaduan badge-proses">Proses</span>
                  </div>
                  <div class="meta">
                    <span><i class="fas fa-user"></i> Siti Nurhaliza</span>
                    <span
                      ><i class="fas fa-map-marker-alt"></i> Moyo Hilir</span
                    >
                    <span><i class="fas fa-calendar"></i> 13 Okt 2025</span>
                  </div>
                </div>

                <div class="pengaduan-list-item">
                  <div class="header">
                    <h6>Masalah Jaringan Internet Desa</h6>
                    <span class="badge-pengaduan badge-baru">Baru</span>
                  </div>
                  <div class="meta">
                    <span><i class="fas fa-user"></i> Budi Santoso</span>
                    <span><i class="fas fa-map-marker-alt"></i> Plampang</span>
                    <span><i class="fas fa-calendar"></i> 15 Okt 2025</span>
                  </div>
                </div>

                <div class="pengaduan-list-item">
                  <div class="header">
                    <h6>Lampu Penerangan Jalan Mati</h6>
                    <span class="badge-pengaduan badge-selesai">Selesai</span>
                  </div>
                  <div class="meta">
                    <span><i class="fas fa-user"></i> Muhammad Yusuf</span>
                    <span
                      ><i class="fas fa-map-marker-alt"></i> Unter Iwes</span
                    >
                    <span><i class="fas fa-calendar"></i> 12 Okt 2025</span>
                  </div>
                </div>

                <div class="pengaduan-list-item">
                  <div class="header">
                    <h6>Kebersihan Pasar Tradisional</h6>
                    <span class="badge-pengaduan badge-selesai">Selesai</span>
                  </div>
                  <div class="meta">
                    <span><i class="fas fa-user"></i> Dewi Sartika</span>
                    <span
                      ><i class="fas fa-map-marker-alt"></i> Sumbawa Besar</span
                    >
                    <span><i class="fas fa-calendar"></i> 11 Okt 2025</span>
                  </div>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="mt-4 d-grid gap-2">
                <a href="#" class="quick-action-btn">
                  <i class="fas fa-plus-circle"></i> Buat Pengaduan Baru
                </a>
                <a href="#" class="btn-link-custom justify-content-center">
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

        <!-- Featured Media -->
        <div class="featured-media" data-aos="fade-up">
          <div class="featured-content">
            <img
              src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1200&h=450&fit=crop"
              alt="Featured"
            />
            <div class="featured-overlay">
              <span class="badge"
                ><i class="fas fa-star me-2"></i> Highlight</span
              >
              <h3>Launching Smart City Command Center 2025</h3>
              <p>
                <i class="fas fa-calendar-alt me-2"></i> 25 Oktober 2025 |
                <i class="fas fa-map-marker-alt ms-3 me-2"></i> Kantor Bupati
                Sumbawa
              </p>
            </div>
          </div>
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
          <div class="photo-item">
            <img
              src="https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=400&h=300&fit=crop"
              alt="Workshop Digital"
            />
            <div class="zoom-icon">
              <i class="fas fa-search-plus"></i>
            </div>
            <div class="photo-overlay">
              <h6>Workshop Digital Marketing</h6>
              <div class="meta">
                <span><i class="fas fa-calendar"></i> 10 Okt 2025</span>
                <span><i class="fas fa-eye"></i> 245 views</span>
              </div>
            </div>
          </div>

          <div class="photo-item">
            <img
              src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=300&fit=crop"
              alt="Rapat Koordinasi"
            />
            <div class="zoom-icon">
              <i class="fas fa-search-plus"></i>
            </div>
            <div class="photo-overlay">
              <h6>Rapat Koordinasi E-Government</h6>
              <div class="meta">
                <span><i class="fas fa-calendar"></i> 08 Okt 2025</span>
                <span><i class="fas fa-eye"></i> 189 views</span>
              </div>
            </div>
          </div>

          <div class="photo-item">
            <img
              src="https://images.unsplash.com/photo-1531482615713-2afd69097998?w=400&h=300&fit=crop"
              alt="Pelatihan ASN"
            />
            <div class="zoom-icon">
              <i class="fas fa-search-plus"></i>
            </div>
            <div class="photo-overlay">
              <h6>Pelatihan Keamanan Siber ASN</h6>
              <div class="meta">
                <span><i class="fas fa-calendar"></i> 05 Okt 2025</span>
                <span><i class="fas fa-eye"></i> 312 views</span>
              </div>
            </div>
          </div>

          <div class="photo-item">
            <img
              src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400&h=300&fit=crop"
              alt="Team Building"
            />
            <div class="zoom-icon">
              <i class="fas fa-search-plus"></i>
            </div>
            <div class="photo-overlay">
              <h6>Team Building Diskominfo</h6>
              <div class="meta">
                <span><i class="fas fa-calendar"></i> 03 Okt 2025</span>
                <span><i class="fas fa-eye"></i> 276 views</span>
              </div>
            </div>
          </div>

          <div class="photo-item">
            <img
              src="https://images.unsplash.com/photo-1542744094-3a31f272c490?w=400&h=300&fit=crop"
              alt="Sosialisasi"
            />
            <div class="zoom-icon">
              <i class="fas fa-search-plus"></i>
            </div>
            <div class="photo-overlay">
              <h6>Sosialisasi Aplikasi Layanan</h6>
              <div class="meta">
                <span><i class="fas fa-calendar"></i> 01 Okt 2025</span>
                <span><i class="fas fa-eye"></i> 198 views</span>
              </div>
            </div>
          </div>

          <div class="photo-item">
            <img
              src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400&h=300&fit=crop"
              alt="Seminar"
            />
            <div class="zoom-icon">
              <i class="fas fa-search-plus"></i>
            </div>
            <div class="photo-overlay">
              <h6>Seminar Literasi Digital</h6>
              <div class="meta">
                <span><i class="fas fa-calendar"></i> 28 Sep 2025</span>
                <span><i class="fas fa-eye"></i> 342 views</span>
              </div>
            </div>
          </div>

          <div class="photo-item">
            <img
              src="https://images.unsplash.com/photo-1560439514-4e9645039924?w=400&h=300&fit=crop"
              alt="Kunjungan"
            />
            <div class="zoom-icon">
              <i class="fas fa-search-plus"></i>
            </div>
            <div class="photo-overlay">
              <h6>Kunjungan Kominfo Pusat</h6>
              <div class="meta">
                <span><i class="fas fa-calendar"></i> 25 Sep 2025</span>
                <span><i class="fas fa-eye"></i> 425 views</span>
              </div>
            </div>
          </div>

          <div class="photo-item">
            <img
              src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=400&h=300&fit=crop"
              alt="Launching"
            />
            <div class="zoom-icon">
              <i class="fas fa-search-plus"></i>
            </div>
            <div class="photo-overlay">
              <h6>Launching Website Baru</h6>
              <div class="meta">
                <span><i class="fas fa-calendar"></i> 20 Sep 2025</span>
                <span><i class="fas fa-eye"></i> 567 views</span>
              </div>
            </div>
          </div>

          <div class="photo-item">
            <img
              src="https://images.unsplash.com/photo-1591115765373-5207764f72e7?w=400&h=300&fit=crop"
              alt="Monitoring"
            />
            <div class="zoom-icon">
              <i class="fas fa-search-plus"></i>
            </div>
            <div class="photo-overlay">
              <h6>Monitoring Sistem IT</h6>
              <div class="meta">
                <span><i class="fas fa-calendar"></i> 18 Sep 2025</span>
                <span><i class="fas fa-eye"></i> 156 views</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Video Gallery -->
        <div class="video-grid" id="videoGallery" data-aos="fade-up">
          <div class="video-item">
            <div class="video-thumbnail">
              <img
                src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=400&h=250&fit=crop"
                alt="Video"
              />
              <div class="play-button">
                <i class="fas fa-play"></i>
              </div>
              <div class="video-duration">12:34</div>
            </div>
            <div class="video-info">
              <h6>Tutorial Penggunaan Aplikasi Smart City</h6>
              <div class="video-meta">
                <span><i class="fas fa-calendar"></i> 12 Okt 2025</span>
                <span><i class="fas fa-eye"></i> 1,234 views</span>
                <span><i class="fas fa-thumbs-up"></i> 89 likes</span>
              </div>
            </div>
          </div>

          <div class="video-item">
            <div class="video-thumbnail">
              <img
                src="https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?w=400&h=250&fit=crop"
                alt="Video"
              />
              <div class="play-button">
                <i class="fas fa-play"></i>
              </div>
              <div class="video-duration">08:15</div>
            </div>
            <div class="video-info">
              <h6>Profil Dinas Kominfo Kabupaten Sumbawa</h6>
              <div class="video-meta">
                <span><i class="fas fa-calendar"></i> 10 Okt 2025</span>
                <span><i class="fas fa-eye"></i> 2,456 views</span>
                <span><i class="fas fa-thumbs-up"></i> 156 likes</span>
              </div>
            </div>
          </div>

          <div class="video-item">
            <div class="video-thumbnail">
              <img
                src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=250&fit=crop"
                alt="Video"
              />
              <div class="play-button">
                <i class="fas fa-play"></i>
              </div>
              <div class="video-duration">15:42</div>
            </div>
            <div class="video-info">
              <h6>Workshop Digital Marketing untuk UMKM</h6>
              <div class="video-meta">
                <span><i class="fas fa-calendar"></i> 08 Okt 2025</span>
                <span><i class="fas fa-eye"></i> 987 views</span>
                <span><i class="fas fa-thumbs-up"></i> 67 likes</span>
              </div>
            </div>
          </div>

          <div class="video-item">
            <div class="video-thumbnail">
              <img
                src="https://images.unsplash.com/photo-1487611459768-bd414656ea10?w=400&h=250&fit=crop"
                alt="Video"
              />
              <div class="play-button">
                <i class="fas fa-play"></i>
              </div>
              <div class="video-duration">10:28</div>
            </div>
            <div class="video-info">
              <h6>Sosialisasi E-Government untuk OPD</h6>
              <div class="video-meta">
                <span><i class="fas fa-calendar"></i> 05 Okt 2025</span>
                <span><i class="fas fa-eye"></i> 756 views</span>
                <span><i class="fas fa-thumbs-up"></i> 45 likes</span>
              </div>
            </div>
          </div>

          <div class="video-item">
            <div class="video-thumbnail">
              <img
                src="https://images.unsplash.com/photo-1551818255-e6e10975bc17?w=400&h=250&fit=crop"
                alt="Video"
              />
              <div class="play-button">
                <i class="fas fa-play"></i>
              </div>
              <div class="video-duration">07:52</div>
            </div>
            <div class="video-info">
              <h6>Pelatihan Keamanan Siber untuk ASN</h6>
              <div class="video-meta">
                <span><i class="fas fa-calendar"></i> 03 Okt 2025</span>
                <span><i class="fas fa-eye"></i> 1,523 views</span>
                <span><i class="fas fa-thumbs-up"></i> 112 likes</span>
              </div>
            </div>
          </div>

          <div class="video-item">
            <div class="video-thumbnail">
              <img
                src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=400&h=250&fit=crop"
                alt="Video"
              />
              <div class="play-button">
                <i class="fas fa-play"></i>
              </div>
              <div class="video-duration">20:15</div>
            </div>
            <div class="video-info">
              <h6>Dokumentasi Launching Aplikasi Pelaporan Bencana</h6>
              <div class="video-meta">
                <span><i class="fas fa-calendar"></i> 01 Okt 2025</span>
                <span><i class="fas fa-eye"></i> 1,890 views</span>
                <span><i class="fas fa-thumbs-up"></i> 178 likes</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Load More Button -->
        <div class="load-more-btn">
          <button>
            <i class="fas fa-sync-alt me-2"></i> Muat Lebih Banyak
          </button>
        </div>
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
