<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <!-- Primary Meta Tags -->
    <title>{{ $title ?? ($profilWeb->nama ?? 'Dinas Komunikasi dan Informatika - Kabupaten Sumbawa') }}</title>
    <meta name="title" content="{{ $title ?? ($profilWeb->nama ?? 'Dinas Komunikasi dan Informatika - Kabupaten Sumbawa') }}" />
    <meta name="description" content="{{ $description ?? ($profilWeb->deskripsi ?? 'Dinas Komunikasi dan Informatika Kabupaten Sumbawa - Mewujudkan Sumbawa Digital') }}" />
    <meta name="keywords" content="{{ $keywords ?? ($profilWeb->keyword ?? 'diskominfo, sumbawa, kabupaten sumbawa, pemerintah sumbawa, layanan publik, e-government') }}" />
    <meta name="author" content="{{ $profilWeb->nama ?? 'Diskominfo Kabupaten Sumbawa' }}" />
    <meta name="robots" content="index, follow" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $ogType ?? 'website' }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="{{ $ogTitle ?? ($title ?? ($profilWeb->nama ?? 'Diskominfo Kabupaten Sumbawa')) }}" />
    <meta property="og:description" content="{{ $ogDescription ?? ($description ?? ($profilWeb->deskripsi ?? 'Dinas Komunikasi dan Informatika Kabupaten Sumbawa')) }}" />
    <meta property="og:image" content="{{ $ogImage ?? ($profilWeb && $profilWeb->logo ? Storage::url($profilWeb->logo) : asset('img/default-og.jpg')) }}" />
    <meta property="og:site_name" content="{{ $profilWeb->nama ?? 'Diskominfo Kabupaten Sumbawa' }}" />
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{ url()->current() }}" />
    <meta property="twitter:title" content="{{ $twitterTitle ?? ($ogTitle ?? ($title ?? ($profilWeb->nama ?? 'Diskominfo Kabupaten Sumbawa'))) }}" />
    <meta property="twitter:description" content="{{ $twitterDescription ?? ($ogDescription ?? ($description ?? ($profilWeb->deskripsi ?? 'Dinas Komunikasi dan Informatika Kabupaten Sumbawa'))) }}" />
    <meta property="twitter:image" content="{{ $twitterImage ?? ($ogImage ?? ($profilWeb && $profilWeb->logo ? Storage::url($profilWeb->logo) : asset('img/default-og.jpg'))) }}" />
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />
    
    <!-- Favicon -->
    @if($profilWeb && $profilWeb->logo)
    <link rel="icon" type="image/x-icon" href="{{ Storage::url($profilWeb->logo) }}" />
    <link rel="apple-touch-icon" href="{{ Storage::url($profilWeb->logo) }}" />
    @else
    <link rel="icon" type="image/x-icon" href="{{ asset('image/logo-sumbawa.png') }}" />
    @endif

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

    @livewireStyles
  </head>
  <body>
    <!-- Header dengan Logo dan Nama Perangkat Daerah -->
    <header class="top-header">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-8">
            <div class="logo-section">
              @if($profilWeb && $profilWeb->logo)
                <img src="{{ Storage::url($profilWeb->logo) }}" alt="{{ $profilWeb->nama }}" />
              @else
                <img src="{{ asset('image/logo-sumbawa.png') }}" alt="Logo Kabupaten Sumbawa" />
              @endif
              <div class="header-title">
                <h1>{{ $profilWeb->nama ?? 'Nama Perangkat Daerah' }}</h1>
                <p>Kabupaten Sumbawa</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 text-end">
            <div class="header-contact">
              <!-- <p class="mb-2">
                <i class="fas fa-phone me-2"></i> {{ $profilWeb->telp ?? '(0371) 123456' }}
              </p>
              <p class="mb-0">
                <i class="fas fa-envelope me-2"></i> {{ $profilWeb->email ?? 'nama_pd@sumbawakab.go.id' }}
              </p> -->
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Navigation Menu dengan Submenu -->
    <nav class="navbar navbar-expand-lg sticky-top">
      <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a wire:navigatee href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                <i class="fas fa-home me-1"></i> Beranda
              </a>
            </li>

            <!-- Profil with Submenu -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-info-circle me-1"></i> Profil
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" wire:navigatee href="{{ url('/tentang-kami') }}">Tentang Kami</a></li>
                <li><a class="dropdown-item" wire:navigatee href="{{ url('/visi-misi') }}">Visi & Misi</a></li>
                <li><a class="dropdown-item" wire:navigatee href="{{ url('/struktur-organisasi') }}">Struktur Organisasi</a></li>
                <li><a class="dropdown-item" wire:navigatee href="{{ url('/tugas-fungsi') }}">Tugas & Fungsi</a></li>
                <li><a class="dropdown-item" wire:navigatee href="{{ url('/bidang') }}">Bidang</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a wire:navigatee href="{{ url('/layanan') }}" class="nav-link {{ request()->is('layanan*') ? 'active' : '' }}">
                <i class="fas fa-concierge-bell me-1"></i> Layanan
              </a>
            </li>

            <li class="nav-item">
              <a wire:navigatee href="{{ url('/berita') }}" class="nav-link {{ request()->is('berita*') ? 'active' : '' }}">
                <i class="fas fa-newspaper me-1"></i> Berita
              </a>
            </li>

            <!-- Informasi with Submenu -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-database me-1"></i> Informasi
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" wire:navigatee href="{{ url('/agenda') }}">Agenda Kegiatan</a></li>
                <li><a class="dropdown-item" wire:navigatee href="{{ url('/dokumen') }}">Dokumen Publik</a></li>
                <li><a class="dropdown-item" wire:navigatee href="{{ url('/lowongan-kerja') }}">Lowongan Kerja</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a wire:navigatee href="{{ url('/galeri') }}" class="nav-link {{ request()->is('galeri*') ? 'active' : '' }}">
                <i class="fas fa-images me-1"></i> Galeri
              </a>
            </li>

            <li class="nav-item">
              <a wire:navigatee href="{{ url('/kontak') }}" class="nav-link {{ request()->is('kontak*') ? 'active' : '' }}">
                <i class="fas fa-phone-alt me-1"></i> Kontak
              </a>
            </li>
          </ul>
          <div class="d-flex">
            <input class="form-control-cari me-2" type="search" placeholder="Cari..." style="width: 200px" />
            <button class="btn btn-outline-primary" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </div>
    </nav>
    
    {{ $slot }}

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 mb-4">
            <h5 class="footer-title">{{ $profilWeb->nama ?? 'Nama Perangkat Daerah' }}</h5>
            <p class="footer-text">
              {{ $profilWeb->deskripsi ?? 'Kabupaten Sumbawa' }}
            </p>
            <div class="social-icons mt-3">
              @if($profilWeb && $profilWeb->facebook)
                <a href="{{ $profilWeb->facebook }}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
              @endif
              @if($profilWeb && $profilWeb->twitter)
                <a href="{{ $profilWeb->twitter }}" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
              @endif
              @if($profilWeb && $profilWeb->instagram)
                <a href="{{ $profilWeb->instagram }}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
              @endif
              @if($profilWeb && $profilWeb->youtube)
                <a href="{{ $profilWeb->youtube }}" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
              @endif
            </div>
          </div>

          <div class="col-lg-2 col-md-6 mb-4">
            <h5 class="footer-title">Menu Cepat</h5>
            <ul class="footer-links">
              <li><a href="{{ url('/') }}">Beranda</a></li>
              <li><a href="{{ url('/tentang-kami') }}">Tentang Kami</a></li>
              <li><a href="{{ url('/layanan') }}">Layanan</a></li>
              <li><a href="{{ url('/berita') }}">Berita</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 mb-4">
            <h5 class="footer-title">Layanan</h5>
            <ul class="footer-links">
              <li><a href="{{ url('/layanan') }}">Layanan Publik</a></li>
              <li><a href="{{ url('/pengaduan-baru') }}">Pengaduan</a></li>
              <li><a href="{{ url('/dokumen') }}">Dokumen Publik</a></li>
              <li><a href="{{ url('/galeri') }}">Galeri</a></li>
            </ul>
          </div>

          <div class="col-lg-3 mb-4">
            <h5 class="footer-title">Kontak</h5>
            <ul class="footer-contact">
              <li>
                <i class="fas fa-map-marker-alt"></i>
                <span>{{ $profilWeb->alamat ?? 'Jl. Garuda No. 1, Sumbawa Besar' }}</span>
              </li>
              <li>
                <i class="fas fa-phone"></i>
                <span>{{ $profilWeb->telp ?? '(0371) 123456' }}</span>
              </li>
              <li>
                <i class="fas fa-envelope"></i>
                <span>{{ $profilWeb->email ?? 'diskominfo@sumbawakab.go.id' }}</span>
              </li>
            </ul>
          </div>
        </div>

        <hr class="footer-divider" />

        <div class="row">
          <div class="col-md-6 text-center text-md-start">
            <p class="footer-copyright">
              &copy; {{ date('Y') }} Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Sumbawa.
            </p>
          </div>
          <div class="col-md-6 text-center text-md-end">
            <p class="footer-visitor">
              <i class="fas fa-users me-2"></i> Pengunjung: <strong>{{ number_format($totalVisitors ?? 0) }}</strong>
              <span class="ms-3">
                  <i class="fas fa-calendar-day me-1"></i> Hari Ini: <strong>{{ number_format($todayVisitors ?? 0) }}</strong>
              </span>
            </p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="btn btn-primary" id="backToTop" style="position: fixed; bottom: 30px; right: 30px; display: none; z-index: 999; width: 50px; height: 50px; border-radius: 50%; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);">
      <i class="fas fa-arrow-up"></i>
    </a>

    @livewireScripts

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom JS -->
    <script>
      // Initialize Hero Swiper
      const heroSwiper = new Swiper(".hero-swiper", {
        loop: true,
        speed: 800,
        autoplay: { delay: 5000, disableOnInteraction: false },
        effect: "fade",
        fadeEffect: { crossFade: true },
        pagination: { el: ".hero-swiper .swiper-pagination", clickable: true },
        navigation: {
          nextEl: ".hero-swiper .swiper-button-next",
          prevEl: ".hero-swiper .swiper-button-prev",
        },
      });

      // Initialize Staff Swiper
      const staffSwiper = new Swiper(".staff-swiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: { delay: 3000, disableOnInteraction: false },
        pagination: { el: ".staff-swiper .swiper-pagination", clickable: true },
        navigation: {
          nextEl: ".staff-swiper .swiper-button-next",
          prevEl: ".staff-swiper .swiper-button-prev",
        },
        breakpoints: {
          640: { slidesPerView: 2 },
          768: { slidesPerView: 3 },
          1024: { slidesPerView: 4 },
        },
      });

      // Submenu Functionality
      document.querySelectorAll(".dropdown-submenu").forEach(function (element) {
        element.addEventListener("click", function (e) {
          let submenu = this.querySelector(".dropdown-menu");
          if (submenu) {
            e.preventDefault();
            e.stopPropagation();
            if (submenu.style.display === "block") {
              submenu.style.display = "none";
            } else {
              document.querySelectorAll(".dropdown-submenu .dropdown-menu").forEach(function (sub) {
                sub.style.display = "none";
              });
              submenu.style.display = "block";
            }
          }
        });
      });

      // Back to Top Button
      const backToTop = document.getElementById("backToTop");
      window.addEventListener("scroll", () => {
        if (window.pageYOffset > 300) {
          backToTop.style.display = "block";
        } else {
          backToTop.style.display = "none";
        }
      });

      backToTop.addEventListener("click", (e) => {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: "smooth" });
      });

      // Active Menu on Scroll
      window.addEventListener("scroll", () => {
        let current = "";
        const sections = document.querySelectorAll("section[id]");
        sections.forEach((section) => {
          const sectionTop = section.offsetTop;
          const sectionHeight = section.clientHeight;
          if (pageYOffset >= sectionTop - 200) {
            current = section.getAttribute("id");
          }
        });

        document.querySelectorAll(".navbar-nav .nav-link").forEach((link) => {
          link.classList.remove("active");
          if (link.getAttribute("href").includes(current)) {
            link.classList.add("active");
          }
        });
      });

      // Smooth Scroll for Navigation Links
      document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
          const href = this.getAttribute("href");
          if (href !== "#" && href.length > 1) {
            const target = document.querySelector(href);
            if (target) {
              e.preventDefault();
              window.scrollTo({ top: target.offsetTop - 70, behavior: "smooth" });
            }
          }
        });
      });

      // Gallery Tabs
      const galeriTabs = document.querySelectorAll(".galeri-tab");
      const photoGallery = document.getElementById("photoGallery");
      const videoGallery = document.getElementById("videoGallery");

      galeriTabs.forEach((tab) => {
        tab.addEventListener("click", function () {
          galeriTabs.forEach((t) => t.classList.remove("active"));
          this.classList.add("active");
          const tabType = this.getAttribute("data-tab");
          if (tabType === "foto") {
            photoGallery.style.display = "grid";
            videoGallery.style.display = "none";
          } else {
            photoGallery.style.display = "none";
            videoGallery.style.display = "grid";
          }
        });
      });

      // Lightbox for Photos
      const photoItems = document.querySelectorAll(".photo-item");
      const lightboxModal = document.getElementById("lightboxModal");
      const lightboxImage = document.getElementById("lightboxImage");

      photoItems.forEach((item) => {
        item.addEventListener("click", function () {
          const imgSrc = this.querySelector("img").src;
          lightboxImage.src = imgSrc;
          lightboxModal.classList.add("active");
        });
      });

      function closeLightbox() {
        lightboxModal.classList.remove("active");
      }

      lightboxModal.addEventListener("click", function (e) {
        if (e.target === lightboxModal) {
          closeLightbox();
        }
      });

      document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
          closeLightbox();
        }
      });

      // Load More Button
      const loadMoreBtn = document.querySelector(".load-more-btn button");
      if (loadMoreBtn) {
        loadMoreBtn.addEventListener("click", function () {
          this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memuat...';
          setTimeout(() => {
            this.innerHTML = '<i class="fas fa-check me-2"></i> Semua konten telah dimuat';
            this.disabled = true;
            this.style.opacity = "0.6";
          }, 1500);
        });
      }
    </script>
    <script>
      // Initialize AOS
      AOS.init({ duration: 1000, once: true, offset: 100 });

      // Re-initialize setiap kali DOM Livewire diperbarui
      document.addEventListener("livewire:navigated", () => {
        AOS.refreshHard();
      });
    </script>
  </body>
</html>
