<div>
    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('berita') }}">Berita</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($berita->judul, 50) }}</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Article Header -->
                    <div class="article-header" data-aos="fade-up">
                        <span class="article-category">Berita</span>
                        <h1 class="article-title">{{ $berita->judul }}</h1>

                        <div class="article-meta">
                            <div class="meta-author">
                                <!-- <img src="{{ asset('images/default-avatar.jpg') }}" alt="{{ $berita->penulis }}" /> -->
                                <div>
                                    <strong>{{ $berita->penulis }}</strong><br />
                                    <small>Penulis</small>
                                </div>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ \Carbon\Carbon::parse($berita->tanggal)->format('d F Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-eye"></i>
                                <span>{{ number_format($berita->hits) }} views</span>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    @if($berita->thumb)
                    <img src="{{ Storage::url($berita->thumb) }}" alt="{{ $berita->judul }}" class="featured-image"
                        data-aos="fade-up" />
                    @endif

                    <!-- Article Content -->
                    <div class="article-content" data-aos="fade-up">
                        <!-- Deskripsi -->
                        @if($berita->deskripsi)
                        <p><strong>{{ $berita->deskripsi }}</strong></p>
                        @endif

                        <!-- Isi Berita -->
                        {!! $berita->isi !!}

                        <!-- Tags (jika ada) -->
                        {{-- <div class="article-tags">
                            <a href="#" class="tag">#Berita</a>
                            <a href="#" class="tag">#Diskominfo</a>
                            <a href="#" class="tag">#KabupatenSumbawa</a>
                        </div> --}}
                    </div>

                    <!-- Share Section -->
                    <div class="share-section" data-aos="fade-up">
                        <h5><i class="fas fa-share-alt me-2"></i> Bagikan Artikel Ini</h5>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank" class="share-btn facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($berita->judul) }}"
                                target="_blank" class="share-btn twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}"
                                target="_blank" class="share-btn whatsapp">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                target="_blank" class="share-btn linkedin">
                                <i class="fab fa-linkedin-in"></i> LinkedIn
                            </a>
                            <a href="#" class="share-btn copy" onclick="copyLink()">
                                <i class="fas fa-link"></i> Copy Link
                            </a>
                        </div>
                    </div>

                    <!-- Author Box -->
                    <!-- <div class="author-box" data-aos="fade-up">
                        <img src="{{ asset('images/default-avatar.jpg') }}" alt="{{ $berita->penulis }}" />
                        <div class="author-info">
                            <h4>{{ $berita->penulis }}</h4>
                            <p>
                                Penulis di Dinas Komunikasi dan Informatika Kabupaten Sumbawa.
                            </p>
                            <div class="author-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div> -->

                    <!-- Comments Section -->
                    <!-- <div class="comments-section" data-aos="fade-up">
                        <h4><i class="fas fa-comments me-2"></i> Komentar</h4>

                        <div class="comment-form">
                            <h5>Tinggalkan Komentar</h5>
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Nama Lengkap *" required />
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" placeholder="Email *" required />
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control" rows="5" placeholder="Tulis komentar Anda..."
                                            required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary" style="
                              background: linear-gradient(
                                135deg,
                                #667eea 0%,
                                #764ba2 100%
                              );
                              border: none;
                              padding: 12px 30px;
                              border-radius: 10px;
                            ">
                                            <i class="fas fa-paper-plane me-2"></i> Kirim Komentar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> -->

                    <!-- Related Posts -->
                    @if($beritaTerkait->count() > 0)
                    <div class="related-posts" data-aos="fade-up">
                        <h4><i class="fas fa-newspaper me-2"></i> Berita Terkait</h4>
                        <div class="row">
                            @foreach($beritaTerkait as $terkait)
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('berita.detail', $terkait->slug) }}" class="related-card">
                                    @if($terkait->thumb)
                                    <img src="{{ Storage::url($terkait->thumb) }}" alt="{{ $terkait->judul }}" />
                                    @else
                                    <img src="{{ asset('images/default-news.jpg') }}" alt="{{ $terkait->judul }}" />
                                    @endif
                                    <div class="related-content">
                                        <h6>{{ Str::limit($terkait->judul, 50) }}</h6>
                                        <div class="related-date">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ \Carbon\Carbon::parse($terkait->tanggal)->format('d M Y') }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Popular Posts Widget -->
                    @if($beritaPopuler->count() > 0)
                    <div class="sidebar-widget" data-aos="fade-up">
                        <h5><i class="fas fa-fire me-2"></i> Berita Populer</h5>
                        @foreach($beritaPopuler as $populer)
                        <a href="{{ route('berita.detail', $populer->slug) }}" class="popular-post">
                            @if($populer->thumb)
                            <img src="{{ Storage::url($populer->thumb) }}" alt="{{ $populer->judul }}" />
                            @else
                            <img src="{{ asset('images/default-news.jpg') }}" alt="{{ $populer->judul }}" />
                            @endif
                            <div class="popular-post-content">
                                <h6>{{ Str::limit($populer->judul, 60) }}</h6>
                                <div class="popular-post-date">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($populer->tanggal)->format('d M Y') }}
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    <!-- Back to Top -->
    <div class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    @push('scripts')
    <script>
        // Back to Top
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Copy Link Function
        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link berhasil disalin!');
            });
        }
    </script>
    @endpush
</div>
