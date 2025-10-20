<div>
  <!-- Page Header -->
  <section class="page-header">
    <div class="container position-relative">
      <h1 data-aos="fade-up">Berita & Artikel</h1>
      <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
          <li class="breadcrumb-item active">Berita</li>
        </ol>
      </nav>
    </div>
  </section>

  <!-- Content Section -->
  <section class="content-section">
    <div class="container">
      <!-- Search & Sort Bar -->
      <!-- <div class="search-sort-bar mb-4" data-aos="fade-up">
        <div class="row align-items-center">
          <div class="col-md-8 mb-3 mb-md-0">
            <div class="search-box d-flex align-items-center">
              <i class="fas fa-search me-2"></i>
              <input
                type="text"
                placeholder="Cari berita atau artikel..."
                wire:model.debounce.500ms="search"
                class="form-control"
              />
            </div>
          </div>
          <div class="col-md-4">
            <select class="form-select" wire:model="sort">
              <option value="terbaru">Terbaru</option>
              <option value="terpopuler">Terpopuler</option>
              <option value="terlama">Terlama</option>
            </select>
          </div>
        </div>
      </div> -->

      <div class="row">
        <div class="col-lg-12">
          <div class="row justify-content-center">
            @forelse($beritas as $berita)
              <div class="col-md-4 mb-4" data-aos="fade-up">
                <div class="news-card">
                  <div class="news-image">
                    <img
                      src="{{ asset('storage/'.$berita->thumb) }}"
                      alt="{{ $berita->judul }}"
                    />
                    <!-- <div class="news-category">
                      {{ ucfirst($berita->kategori ?? 'Berita') }}
                    </div> -->
                  </div>
                  <div class="news-content">
                    <div class="news-date">
                      <i class="fas fa-calendar-alt"></i>
                      {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
                    </div>
                    <h3 class="news-title">
                      {{ $berita->judul }}
                    </h3>
                    <p class="news-excerpt">
                      {{ Str::limit(strip_tags($berita->deskripsi), 150) }}
                    </p>
                    <div class="news-footer">
                      <div class="news-author">
                        <img
                          src="https://randomuser.me/api/portraits/men/{{ rand(1,70) }}.jpg"
                          alt="Author"
                        />
                        <span>{{ $berita->penulis ?? 'Admin Diskominfo' }}</span>
                      </div>
                      <a href="{{ url('berita/'.$berita->slug) }}" class="read-more">
                        Baca <i class="fas fa-arrow-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12 text-center py-5">
                <h5>Tidak ada berita ditemukan.</h5>
              </div>
            @endforelse
          </div>

        <div class="custom-pagination mt-4 d-flex justify-content-center align-items-center gap-2">
            {{-- Tombol Sebelumnya --}}
            @if ($beritas->onFirstPage())
                <button class="page-btn disabled"><i class="fas fa-chevron-left"></i></button>
            @else
                <button wire:click="previousPage" class="page-btn"><i class="fas fa-chevron-left"></i></button>
            @endif

            {{-- Nomor Halaman --}}
            @foreach ($beritas->getUrlRange(1, $beritas->lastPage()) as $page => $url)
                @if ($page == $beritas->currentPage())
                    <button class="page-btn active">{{ $page }}</button>
                @else
                    <button wire:click="gotoPage({{ $page }})" class="page-btn">{{ $page }}</button>
                @endif
            @endforeach

            {{-- Tombol Berikutnya --}}
            @if ($beritas->hasMorePages())
                <button wire:click="nextPage" class="page-btn"><i class="fas fa-chevron-right"></i></button>
            @else
                <button class="page-btn disabled"><i class="fas fa-chevron-right"></i></button>
            @endif
        </div>

        </div>
      </div>
    </div>
  </section>
</div>
