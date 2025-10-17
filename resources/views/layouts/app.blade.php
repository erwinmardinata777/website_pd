<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dinas Komunikasi dan Informatika - Kabupaten Sumbawa</title>

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />

    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet"
    />

    <!-- Swiper CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

    <style>
      * {
        font-family: "Poppins", sans-serif;
      }

      /* Header Style */
      .top-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 30px 0;
        color: white;
      }

      .logo-section {
        display: flex;
        align-items: center;
        gap: 20px;
      }

      .logo-section img {
        width: 80px;
        height: 80px;
      }

      .header-title h1 {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
      }

      .header-title p {
        font-size: 16px;
        margin: 0;
        opacity: 0.9;
      }

      /* Navigation Menu with Submenu */
      .navbar {
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 0;
      }

      .navbar-nav .nav-link {
        color: #333;
        font-weight: 500;
        padding: 18px 20px !important;
        transition: all 0.3s;
      }

      .navbar-nav .nav-link:hover {
        color: #2a5298;
        background-color: #f8f9fa;
      }

      .navbar-nav .nav-link.active {
        color: #2a5298;
        border-bottom: 3px solid #2a5298;
      }

      /* Submenu Styling */
      .dropdown-menu {
        border: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 10px 0;
      }

      .dropdown-item {
        padding: 10px 20px;
        transition: all 0.3s;
      }

      .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #2a5298;
        padding-left: 25px;
      }

      /* Multi-level Dropdown */
      .dropdown-submenu {
        position: relative;
      }

      .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
        display: none;
      }

      .dropdown-submenu:hover > .dropdown-menu {
        display: block;
      }

      .dropdown-item.dropdown-toggle::after {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
      }

      /* Swiper Slider Styling */
      .hero-swiper {
        width: 100%;
        height: 600px;
      }

      .hero-swiper .swiper-slide {
        position: relative;
        background-size: cover;
        background-position: center;
      }

      .hero-swiper .swiper-slide::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
      }

      .slide-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
        z-index: 10;
        width: 80%;
        max-width: 900px;
      }

      .slide-content h2 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
      }

      .slide-content p {
        font-size: 20px;
        margin-bottom: 30px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
      }

      .swiper-button-next,
      .swiper-button-prev {
        color: white;
        background: rgba(255, 255, 255, 0.2);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        transition: all 0.3s;
      }

      .swiper-button-next:hover,
      .swiper-button-prev:hover {
        background: rgba(255, 255, 255, 0.4);
      }

      .swiper-button-next::after,
      .swiper-button-prev::after {
        font-size: 20px;
      }

      .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: white;
        opacity: 0.5;
      }

      .swiper-pagination-bullet-active {
        opacity: 1;
        background: #2a5298;
      }

      /* Section Title */
      .section-title {
        text-align: center;
        margin-bottom: 50px;
      }

      .section-title h2 {
        font-size: 36px;
        font-weight: 700;
        color: #1e3c72;
        position: relative;
        display: inline-block;
        padding-bottom: 15px;
      }

      .section-title h2:after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border-radius: 2px;
      }

      /* Layanan Cards */
      .layanan-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
        height: 100%;
        border: 1px solid #f0f0f0;
      }

      .layanan-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
      }

      .layanan-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .layanan-icon i {
        font-size: 36px;
        color: white;
      }

      .layanan-card h4 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
      }

      .layanan-card p {
        color: #666;
        font-size: 15px;
        line-height: 1.6;
      }

      /* Profil Section */
      .profil-section {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 80px 0;
      }

      .profil-content {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      }

      .profil-img {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      }

      .profil-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      /* Staff Swiper Slider */
      .staff-swiper {
        padding: 20px 0 50px 0;
      }

      .staff-card {
        background: white;
        padding: 30px 20px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        height: 100%;
      }

      .staff-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      }

      .staff-card img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
        border: 5px solid #f0f0f0;
      }

      .staff-card h6 {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
      }

      .staff-card p {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
      }

      .staff-card .social-links a {
        display: inline-block;
        width: 35px;
        height: 35px;
        background: #f8f9fa;
        border-radius: 50%;
        line-height: 35px;
        margin: 0 5px;
        color: #666;
        transition: all 0.3s;
      }

      .staff-card .social-links a:hover {
        background: #2a5298;
        color: white;
      }

      /* Berita Cards */
      .berita-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
        height: 100%;
      }

      .berita-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
      }

      .berita-img {
        height: 200px;
        overflow: hidden;
      }

      .berita-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
      }

      .berita-card:hover .berita-img img {
        transform: scale(1.1);
      }

      .berita-content {
        padding: 20px;
      }

      .berita-date {
        color: #2a5298;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 10px;
      }

      .berita-content h5 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
      }

      .berita-content p {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
      }

      .btn-read-more {
        color: #2a5298;
        font-weight: 500;
        text-decoration: none;
      }

      .btn-read-more:hover {
        color: #1e3c72;
      }

      /* Link Terkait */
      .link-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
        text-decoration: none;
        display: block;
        height: 100%;
      }

      .link-card:hover {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        transform: translateY(-5px);
      }

      .link-card img {
        width: 80px;
        height: 80px;
        margin-bottom: 15px;
        object-fit: contain;
      }

      .link-card p {
        margin: 0;
        font-weight: 500;
        color: #333;
      }

      .link-card:hover p {
        color: white;
      }

      /* Footer */
      .footer {
        background: #1a1a2e;
        color: white;
        padding: 50px 0 20px;
      }

      .footer h5 {
        font-weight: 600;
        margin-bottom: 20px;
      }

      .footer ul {
        list-style: none;
        padding: 0;
      }

      .footer ul li {
        margin-bottom: 10px;
      }

      .footer ul li a {
        color: #ccc;
        text-decoration: none;
        transition: color 0.3s;
      }

      .footer ul li a:hover {
        color: white;
      }

      .social-icons a {
        display: inline-block;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        text-align: center;
        line-height: 40px;
        margin-right: 10px;
        color: white;
        transition: all 0.3s;
      }

      .social-icons a:hover {
        background: #2a5298;
        transform: translateY(-3px);
      }

      .section-padding {
        padding: 80px 0;
      }

      /* Responsive */
      @media (max-width: 768px) {
        .hero-swiper {
          height: 400px;
        }

        .slide-content h2 {
          font-size: 32px;
        }

        .slide-content p {
          font-size: 16px;
        }
      }
      /* Pengaduan & Agenda Section */
      .info-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      }

      .info-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        height: 100%;
      }

      .info-card h4 {
        font-size: 22px;
        font-weight: 700;
        color: #1e3c72;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .info-card h4 i {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
      }

      /* Stats Cards */
      .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 25px;
      }

      .stat-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px;
        border-radius: 15px;
        color: white;
        text-align: center;
      }

      .stat-box h3 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 5px;
      }

      .stat-box p {
        font-size: 13px;
        margin: 0;
        opacity: 0.9;
      }

      .stat-box.green {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
      }

      .stat-box.orange {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
      }

      .stat-box.blue {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
      }

      /* Pengaduan List */
      .pengaduan-list-item {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s;
      }

      .pengaduan-list-item:last-child {
        border-bottom: none;
      }

      .pengaduan-list-item:hover {
        background: #f8f9fa;
        padding-left: 20px;
      }

      .pengaduan-list-item .header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 8px;
      }

      .pengaduan-list-item h6 {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        margin: 0;
        flex: 1;
      }

      .pengaduan-list-item .meta {
        font-size: 12px;
        color: #666;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
      }

      .pengaduan-list-item .meta span {
        display: flex;
        align-items: center;
        gap: 5px;
      }

      .pengaduan-list-item .meta i {
        color: #667eea;
      }

      .badge-pengaduan {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
      }

      .badge-baru {
        background: #e3f2fd;
        color: #1976d2;
      }

      .badge-proses {
        background: #fff3e0;
        color: #f57c00;
      }

      .badge-selesai {
        background: #e8f5e9;
        color: #388e3c;
      }

      /* Agenda List */
      .agenda-list-item {
        display: flex;
        gap: 15px;
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s;
      }

      .agenda-list-item:last-child {
        border-bottom: none;
      }

      .agenda-list-item:hover {
        background: #f8f9fa;
      }

      .agenda-date-mini {
        min-width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
      }

      .agenda-date-mini .day {
        font-size: 24px;
        font-weight: 700;
        line-height: 1;
      }

      .agenda-date-mini .month {
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
      }

      .agenda-info {
        flex: 1;
      }

      .agenda-info h6 {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        margin: 0 0 8px 0;
      }

      .agenda-info .meta {
        font-size: 12px;
        color: #666;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
      }

      .agenda-info .meta span {
        display: flex;
        align-items: center;
        gap: 5px;
      }

      .agenda-info .meta i {
        color: #667eea;
      }

      .btn-link-custom {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s;
      }

      .btn-link-custom:hover {
        color: #764ba2;
        gap: 10px;
      }

      .quick-action-btn {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 2px solid #667eea;
        background: white;
        color: #667eea;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s;
        cursor: pointer;
      }

      .quick-action-btn:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
      }

      .empty-state {
        text-align: center;
        padding: 30px;
        color: #999;
      }

      .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.3;
      }

      /* Galeri Section */
      .galeri-section {
        padding: 80px 0;
        background: white;
      }

      .galeri-tabs {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 40px;
        flex-wrap: wrap;
      }

      .galeri-tab {
        background: white;
        border: 2px solid #e0e0e0;
        padding: 12px 35px;
        border-radius: 50px;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
      }

      .galeri-tab:hover {
        border-color: #667eea;
        color: #667eea;
        transform: translateY(-2px);
      }

      .galeri-tab.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
      }

      .galeri-tab i {
        font-size: 16px;
      }

      /* Photo Gallery Grid */
      .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
      }

      .photo-item {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        cursor: pointer;
        height: 250px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
      }

      .photo-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
      }

      .photo-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
      }

      .photo-item:hover img {
        transform: scale(1.1);
      }

      .photo-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(
          to top,
          rgba(0, 0, 0, 0.8) 0%,
          transparent 100%
        );
        padding: 20px;
        transform: translateY(100%);
        transition: transform 0.3s;
      }

      .photo-item:hover .photo-overlay {
        transform: translateY(0);
      }

      .photo-overlay h6 {
        color: white;
        font-size: 15px;
        font-weight: 600;
        margin: 0 0 5px 0;
      }

      .photo-overlay .meta {
        color: rgba(255, 255, 255, 0.8);
        font-size: 12px;
        display: flex;
        gap: 15px;
      }

      .photo-overlay .meta i {
        margin-right: 5px;
      }

      .zoom-icon {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s;
        color: #667eea;
      }

      .photo-item:hover .zoom-icon {
        opacity: 1;
      }

      /* Video Gallery Grid */
      .video-grid {
        display: none;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
      }

      .video-grid.active {
        display: grid;
      }

      .video-item {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        background: #000;
      }

      .video-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
      }

      .video-thumbnail {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
      }

      .video-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
      }

      .video-item:hover .video-thumbnail img {
        transform: scale(1.1);
      }

      .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
      }

      .play-button i {
        font-size: 28px;
        color: #667eea;
        margin-left: 5px;
      }

      .video-item:hover .play-button {
        transform: translate(-50%, -50%) scale(1.1);
        background: white;
      }

      .video-duration {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 4px 10px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: 600;
      }

      .video-info {
        padding: 20px;
        background: white;
      }

      .video-info h6 {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin: 0 0 10px 0;
        line-height: 1.4;
      }

      .video-meta {
        display: flex;
        gap: 15px;
        color: #666;
        font-size: 13px;
        flex-wrap: wrap;
      }

      .video-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
      }

      .video-meta i {
        color: #667eea;
      }

      /* Featured Section */
      .featured-media {
        margin-bottom: 40px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      }

      .featured-content {
        position: relative;
        height: 450px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      }

      .featured-content img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .featured-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 40px;
        background: linear-gradient(
          to top,
          rgba(0, 0, 0, 0.9) 0%,
          transparent 100%
        );
        color: white;
      }

      .featured-overlay .badge {
        background: #667eea;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 10px;
        display: inline-block;
      }

      .featured-overlay h3 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
      }

      .featured-overlay p {
        font-size: 16px;
        opacity: 0.9;
        margin-bottom: 0;
      }

      /* Load More */
      .load-more-btn {
        text-align: center;
        margin-top: 40px;
      }

      .load-more-btn button {
        padding: 14px 40px;
        background: white;
        border: 2px solid #667eea;
        border-radius: 50px;
        color: #667eea;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
      }

      .load-more-btn button:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
      }

      /* Lightbox Modal */
      .lightbox-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        justify-content: center;
        align-items: center;
      }

      .lightbox-modal.active {
        display: flex;
      }

      .lightbox-content {
        max-width: 90%;
        max-height: 90%;
        position: relative;
      }

      .lightbox-content img {
        max-width: 100%;
        max-height: 90vh;
        object-fit: contain;
      }

      .lightbox-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: white;
        font-size: 24px;
        transition: all 0.3s;
      }

      .lightbox-close:hover {
        background: rgba(255, 255, 255, 0.3);
      }

      @media (max-width: 768px) {
        .photo-grid {
          grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
          gap: 15px;
        }

        .video-grid {
          grid-template-columns: 1fr;
        }

        .featured-content {
          height: 300px;
        }

        .featured-overlay h3 {
          font-size: 24px;
        }
      }
    </style>

    @livewireStyles

  </head>
  <body>
    @livewire('navbar')
    
    {{ $slot }}

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 mb-4">
            <h5>Dinas Komunikasi dan Informatika</h5>
            <p class="text-muted">
              Kabupaten Sumbawa, Provinsi Nusa Tenggara Barat
            </p>
            <div class="social-icons mt-3">
              <a href="#"><i class="fab fa-facebook-f"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 mb-4">
            <h5>Menu Cepat</h5>
            <ul>
              <li><a href="#beranda">Beranda</a></li>
              <li><a href="#profil">Profil</a></li>
              <li><a href="#layanan">Layanan</a></li>
              <li><a href="#berita">Berita</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 mb-4">
            <h5>Layanan</h5>
            <ul>
              <li><a href="#">Perizinan Online</a></li>
              <li><a href="#">Pengaduan</a></li>
              <li><a href="#">Informasi Publik</a></li>
              <li><a href="#">Download</a></li>
            </ul>
          </div>

          <div class="col-lg-3 mb-4">
            <h5>Kontak</h5>
            <ul class="list-unstyled">
              <li class="mb-2">
                <i class="fas fa-map-marker-alt me-2"></i>
                Jl. Garuda No. 1, Sumbawa Besar
              </li>
              <li class="mb-2">
                <i class="fas fa-phone me-2"></i>
                (0371) 123456
              </li>
              <li class="mb-2">
                <i class="fas fa-envelope me-2"></i>
                diskominfo@sumbawakab.go.id
              </li>
            </ul>
          </div>
        </div>

        <hr class="mt-4 mb-4" style="border-color: rgba(255, 255, 255, 0.1)" />

        <div class="row">
          <div class="col-md-6 text-center text-md-start">
            <p class="mb-0 text-muted">
              &copy; 2025 Diskominfo Kabupaten Sumbawa. All Rights Reserved.
            </p>
          </div>
          <div class="col-md-6 text-center text-md-end">
            <p class="mb-0 text-muted">
              <i class="fas fa-users me-2"></i> Pengunjung:
              <strong>125,432</strong>
            </p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Back to Top Button -->
    <a
      href="#"
      class="btn btn-primary"
      id="backToTop"
      style="
        position: fixed;
        bottom: 30px;
        right: 30px;
        display: none;
        z-index: 999;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
      "
    >
      <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom JS -->
    <script>
      // Initialize AOS
      AOS.init({
        duration: 1000,
        once: true,
        offset: 100,
      });

      // Initialize Hero Swiper
      const heroSwiper = new Swiper(".hero-swiper", {
        loop: true,
        speed: 800,
        autoplay: {
          delay: 5000,
          disableOnInteraction: false,
        },
        effect: "fade",
        fadeEffect: {
          crossFade: true,
        },
        pagination: {
          el: ".hero-swiper .swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".hero-swiper .swiper-button-next",
          prevEl: ".hero-swiper .swiper-button-prev",
        },
      });

      // Initialize Staff Swiper (Bisa Digeser)
      const staffSwiper = new Swiper(".staff-swiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        pagination: {
          el: ".staff-swiper .swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".staff-swiper .swiper-button-next",
          prevEl: ".staff-swiper .swiper-button-prev",
        },
        breakpoints: {
          640: {
            slidesPerView: 2,
          },
          768: {
            slidesPerView: 3,
          },
          1024: {
            slidesPerView: 4,
          },
        },
      });

      // Submenu Functionality
      document
        .querySelectorAll(".dropdown-submenu")
        .forEach(function (element) {
          element.addEventListener("click", function (e) {
            let submenu = this.querySelector(".dropdown-menu");
            if (submenu) {
              e.preventDefault();
              e.stopPropagation();

              // Toggle submenu
              if (submenu.style.display === "block") {
                submenu.style.display = "none";
              } else {
                // Hide all other submenus
                document
                  .querySelectorAll(".dropdown-submenu .dropdown-menu")
                  .forEach(function (sub) {
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
        window.scrollTo({
          top: 0,
          behavior: "smooth",
        });
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
              window.scrollTo({
                top: target.offsetTop - 70,
                behavior: "smooth",
              });
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
          // Remove active class
          galeriTabs.forEach((t) => t.classList.remove("active"));
          this.classList.add("active");

          const tabType = this.getAttribute("data-tab");

          // Toggle galleries
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

      // Close lightbox on background click
      lightboxModal.addEventListener("click", function (e) {
        if (e.target === lightboxModal) {
          closeLightbox();
        }
      });

      // Close lightbox with ESC key
      document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
          closeLightbox();
        }
      });

      // Video Player (simulasi)
      const videoItems = document.querySelectorAll(".video-item");

      videoItems.forEach((item) => {
        item.addEventListener("click", function () {
          const videoTitle = this.querySelector("h6").textContent;
          alert(
            "Memutar video: " +
              videoTitle +
              "\n\nDalam implementasi nyata, ini akan membuka video player atau YouTube embed."
          );
        });
      });

      // Load More Button
      document
        .querySelector(".load-more-btn button")
        .addEventListener("click", function () {
          this.innerHTML =
            '<i class="fas fa-spinner fa-spin me-2"></i> Memuat...';

          // Simulasi loading
          setTimeout(() => {
            this.innerHTML =
              '<i class="fas fa-check me-2"></i> Semua konten telah dimuat';
            this.disabled = true;
            this.style.opacity = "0.6";
          }, 1500);
        });
    </script>
    @livewireScripts
  </body>
</html>
