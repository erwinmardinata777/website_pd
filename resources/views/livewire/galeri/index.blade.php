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
            <h1 data-aos="fade-up">Galeri Media</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Galeri</li>
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
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div class="stat-number">{{ \App\Models\KategoriFoto::count() }}</div>
                    <div class="stat-label">Album Foto</div>
                </div>

                <div class="stat-card info">
                    <div class="stat-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="stat-number">{{ \App\Models\Foto::count() }}</div>
                    <div class="stat-label">Total Foto</div>
                </div>

                <div class="stat-card warning">
                    <div class="stat-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="stat-number">{{ \App\Models\Video::count() }}</div>
                    <div class="stat-label">Total Video</div>
                </div>

                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-number">
                        {{ number_format(\App\Models\KategoriFoto::sum('hits') + \App\Models\Video::sum('hits')) }}
                    </div>
                    <div class="stat-label">Total Views</div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-bar" data-aos="fade-up">
                <div class="galeri-tabs">
                    <button wire:click="setTab('foto')" 
                            class="galeri-tab {{ $activeTab === 'foto' ? 'active' : '' }}">
                        <i class="fas fa-images"></i> Album Foto ({{ \App\Models\KategoriFoto::count() }})
                    </button>
                    <button wire:click="setTab('video')" 
                            class="galeri-tab {{ $activeTab === 'video' ? 'active' : '' }}">
                        <i class="fas fa-video"></i> Video ({{ \App\Models\Video::count() }})
                    </button>
                </div>
            </div>

            <!-- Photo Gallery Section -->
            @if($activeTab === 'foto')
                <div class="photo-grid" data-aos="fade-up">
                    @forelse($kategoriFotos as $index => $kategori)
                        @if($kategori->fotos->first())
                        <div class="photo-item" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                            <a href="{{ route('galeri.foto.detail', $kategori->slug) }}">
                                <img src="{{ Storage::url($kategori->fotos->first()->gambar) }}" 
                                     alt="{{ $kategori->nama_kategori }}" />
                                <div class="zoom-icon">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                                <div class="photo-overlay">
                                    <h6>{{ $kategori->nama_kategori }}</h6>
                                    <div class="meta">
                                        <span>
                                            <i class="fas fa-calendar"></i> 
                                            {{ \Carbon\Carbon::parse($kategori->tanggal)->format('d M Y') }}
                                        </span>
                                        <span>
                                            <i class="fas fa-images"></i> 
                                            {{ $kategori->fotos->count() }} foto
                                        </span>
                                    </div>
                                    <div class="meta mt-2">
                                        <span>
                                            <i class="fas fa-eye"></i> 
                                            {{ number_format($kategori->hits) }} views
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif
                    @empty
                        <div class="empty-state" data-aos="fade-up">
                            <i class="fas fa-images"></i>
                            <h4>Belum Ada Album Foto</h4>
                            <p>Album foto akan ditampilkan di sini</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination for Photos -->
                @if($kategoriFotos->hasPages())
                <div class="pagination-wrapper mt-5">
                    {{ $kategoriFotos->links() }}
                </div>
                @endif
            @endif

            <!-- Video Gallery Section -->
            @if($activeTab === 'video')
                <div class="video-grid active" data-aos="fade-up">
                    @forelse($videos as $index => $video)
                    <div class="video-item" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                        <div class="video-thumbnail" onclick="playVideo('{{ $video->url }}', '{{ $video->judul }}')">
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
                        <div class="empty-state" data-aos="fade-up">
                            <i class="fas fa-video"></i>
                            <h4>Belum Ada Video</h4>
                            <p>Video akan ditampilkan di sini</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination for Videos -->
                @if($videos->hasPages())
                <div class="pagination-wrapper mt-5">
                    {{ $videos->links() }}
                </div>
                @endif
            @endif
        </div>
    </section>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" style="background: #000; border: none; border-radius: 20px; overflow: hidden;">
                <div class="modal-header" style="border: none; padding: 20px 25px; background: rgba(0,0,0,0.8);">
                    <h5 class="modal-title" style="color: white; font-weight: 600;" id="videoModalLabel"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 0;">
                    <div class="ratio ratio-16x9">
                        <iframe id="videoIframe" src="" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Play Video Function
        function playVideo(url, title) {
            // Convert YouTube URL to embed URL
            let embedUrl = url;
            
            // Handle different YouTube URL formats
            if (url.includes('youtube.com/watch?v=')) {
                const videoId = url.split('v=')[1].split('&')[0];
                embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            } else if (url.includes('youtu.be/')) {
                const videoId = url.split('youtu.be/')[1].split('?')[0];
                embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            } else if (url.includes('youtube.com/embed/')) {
                embedUrl = url + '?autoplay=1';
            }
            
            // Set modal content
            document.getElementById('videoModalLabel').textContent = title;
            document.getElementById('videoIframe').src = embedUrl;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('videoModal'));
            modal.show();
        }

        // Clear iframe when modal is hidden
        document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('videoIframe').src = '';
        });
    </script>
</div>
