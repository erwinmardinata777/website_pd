<div>
<section class="content-section">
  <div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('pengaduan.index') }}">Daftar Pengaduan</a></li>
        <li class="breadcrumb-item active">Detail Pengaduan</li>
      </ol>
    </nav>

    <div class="row">
      <!-- Main Content -->
      <div class="col-lg-8">
        <!-- Header -->
        <div class="header-card" data-aos="fade-up">
          <div class="ticket-number">
            <i class="fas fa-ticket-alt me-2"></i> #PGD{{ $pengaduan->id }}
          </div>

          <h1 class="pengaduan-title">{{ $pengaduan->pengaduan }}</h1>

          <span class="status-badge 
            @if($pengaduan->status == 0) status-baru
            @elseif($pengaduan->status == 1) status-proses
            @else status-selesai @endif">
            <i class="fas fa-inbox me-2"></i>
            Status: 
            @if($pengaduan->status == 0) Baru
            @elseif($pengaduan->status == 1) Proses
            @else Selesai @endif
          </span>

          <div class="meta-info">
            <div class="meta-item">
              <i class="fas fa-calendar-alt"></i>
              <span>Dilaporkan: {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengaduan)->translatedFormat('d F Y, H:i') }}</span>
            </div>
            <div class="meta-item">
              <i class="fas fa-map-marker-alt"></i>
              <span>{{ $pengaduan->alamat }}</span>
            </div>
            <div class="meta-item">
              <i class="fas fa-folder"></i>
              <span>{{ $pengaduan->kecamatan->nama_kecamatan ?? '-' }} - {{ $pengaduan->desa->nama_desa ?? '-' }}</span>
            </div>
          </div>
        </div>

        <!-- Detail Pengaduan -->
        <div class="content-card" data-aos="fade-up">
          <div class="section-title"><i class="fas fa-file-alt"></i> Detail Pengaduan</div>

          <div class="detail-row">
            <div class="detail-label">Judul Pengaduan</div>
            <div class="detail-value">{{ $pengaduan->pengaduan }}</div>
          </div>

          <div class="detail-row">
            <div class="detail-label">Lokasi</div>
            <div class="detail-value">{{ $pengaduan->alamat }}</div>
          </div>

          <div class="detail-row">
            <div class="detail-label">Kecamatan / Desa</div>
            <div class="detail-value">
              {{ $pengaduan->kecamatan->nama_kecamatan ?? '-' }} / {{ $pengaduan->desa->nama_desa ?? '-' }}
            </div>
          </div>

          <div class="detail-row">
            <div class="detail-label">Tanggal Pengaduan</div>
            <div class="detail-value">{{ \Carbon\Carbon::parse($pengaduan->tanggal_pengaduan)->translatedFormat('d F Y') }}</div>
          </div>
        </div>

        <!-- Kronologi -->
        <div class="content-card" data-aos="fade-up">
          <div class="section-title"><i class="fas fa-align-left"></i> Isi Pengaduan</div>
          <div class="detail-text">
            {!! nl2br(e($pengaduan->isi_pengaduan)) !!}
          </div>
        </div>

        <!-- Bukti -->
        @if($pengaduan->bukti)
        <div class="content-card" data-aos="fade-up">
          <div class="section-title"><i class="fas fa-image"></i> Bukti Pendukung</div>
          <div class="evidence-gallery">
            <a href="{{ asset('storage/'.$pengaduan->bukti) }}" target="_blank" class="evidence-item">
              <img src="{{ asset('storage/'.$pengaduan->bukti) }}" alt="Bukti" />
              <div class="evidence-overlay"><small>Lihat Bukti</small></div>
            </a>
          </div>
        </div>
        @endif

        <!-- Tanggapan -->
        <div class="content-card" data-aos="fade-up">
          <div class="section-title"><i class="fas fa-comments"></i> Tanggapan Pengaduan</div>
          @if($pengaduan->balasan->count() > 0)
            @foreach($pengaduan->balasan as $balas)
              <div class="response-card mb-3">
                <div class="response-header">
                  <div class="response-info">
                    <h5>Petugas</h5>
                    <small><i class="fas fa-calendar me-1"></i> 
                      {{ \Carbon\Carbon::parse($balas->tanggal_balas)->translatedFormat('d F Y, H:i') }}
                    </small>
                  </div>
                </div>
                <div class="response-text">
                  {{ $balas->tanggapan }}
                </div>
              </div>
            @endforeach
          @else
            <p class="text-muted">Belum ada tanggapan dari pihak terkait.</p>
          @endif
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="sidebar-card">
          <div class="sidebar-title">Aksi Cepat</div>
          <a href="{{ route('pengaduan.create') }}" class="btn w-100 mb-3 btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Buat Pengaduan Baru
          </a>
          <a href="{{ route('pengaduan.index') }}" class="btn w-100 btn-outline-primary">
            <i class="fas fa-list me-2"></i> Lihat Semua Pengaduan
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

</div>
