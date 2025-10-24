<div>
    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri</a></li>
                    <li class="breadcrumb-item active">{{ $kategori->nama_kategori }}</li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="page-title" data-aos="fade-up">
                <h1>{{ $kategori->nama_kategori }}</h1>
                <p>
                    <i class="fas fa-calendar-alt me-2"></i> 
                    {{ \Carbon\Carbon::parse($kategori->tanggal)->format('d F Y') }}
                    <span class="ms-3">
                        <i class="fas fa-eye me-2"></i> 
                        {{ number_format($kategori->hits) }} views
                    </span>
                    <span class="ms-3">
                        <i class="fas fa-images me-2"></i> 
                        {{ $kategori->fotos->count() }} foto
                    </span>
                </p>
            </div>

            <!-- Photo Grid -->
            <div class="photo-grid">
                @foreach($kategori->fotos as $foto)
                <div class="photo-item" data-aos="fade-up">
                    <img src="{{ Storage::url($foto->gambar) }}" alt="{{ $foto->judul }}" />
                    <div class="zoom-icon">
                        <i class="fas fa-search-plus"></i>
                    </div>
                    <div class="photo-overlay">
                        <h6>{{ $foto->judul }}</h6>
                    </div>
                </div>
                @endforeach
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
</div>
