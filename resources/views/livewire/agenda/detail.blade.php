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

    @php
        $tanggal = \Carbon\Carbon::parse($agenda->tanggal);
        $isToday = $tanggal->isToday();
        $isPast = $tanggal->isPast() && !$isToday;
        $daysUntil = $tanggal->diffInDays(now(), false);
    @endphp

    <!-- Page Header -->
    <section class="page-header">
        <div class="container position-relative">
            <h1 data-aos="fade-up">{{ $agenda->agenda }}</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('agenda.index') }}">Agenda</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($agenda->agenda, 30) }}</li>
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
                    <!-- Agenda Detail Card -->
                    <div class="agenda-detail-card" data-aos="fade-up">
                        <!-- Featured Image -->
                        @if($agenda->gambar)
                        <div class="agenda-featured-image">
                            <img src="{{ Storage::url($agenda->gambar) }}" alt="{{ $agenda->agenda }}">
                            
                            <!-- Status Overlay -->
                            @if($isToday)
                            <div class="agenda-status-overlay today">
                                <i class="fas fa-circle me-2"></i> Sedang Berlangsung
                            </div>
                            @elseif($isPast)
                            <div class="agenda-status-overlay completed">
                                <i class="fas fa-check-circle me-2"></i> Telah Selesai
                            </div>
                            @else
                            <div class="agenda-status-overlay upcoming">
                                <i class="fas fa-calendar-plus me-2"></i> {{ abs($daysUntil) }} Hari Lagi
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Content -->
                        <div class="agenda-detail-content">
                            <!-- Title -->
                            <h2>{{ $agenda->agenda }}</h2>

                            <!-- Event Info Grid -->
                            <div class="event-info-grid">
                                <div class="event-info-item">
                                    <div class="event-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="event-text">
                                        <strong>Tanggal</strong>
                                        <p>{{ $tanggal->translatedFormat('l, d F Y') }}</p>
                                    </div>
                                </div>

                                <div class="event-info-item">
                                    <div class="event-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="event-text">
                                        <strong>Waktu</strong>
                                        <p>{{ substr($agenda->jam_mulai, 0, 5) }} - {{ substr($agenda->jam_selesai, 0, 5) }} WITA</p>
                                    </div>
                                </div>

                                <div class="event-info-item">
                                    <div class="event-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="event-text">
                                        <strong>Lokasi</strong>
                                        <p>{{ $agenda->tempat }}</p>
                                    </div>
                                </div>

                                <div class="event-info-item">
                                    <div class="event-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div class="event-text">
                                        <strong>Status</strong>
                                        <p>
                                            @if($isToday)
                                                <span class="badge bg-warning">Sedang Berlangsung</span>
                                            @elseif($isPast)
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-primary">Mendatang</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($agenda->deskripsi)
                            <div class="event-description">
                                <h3><i class="fas fa-align-left me-2"></i> Deskripsi Kegiatan</h3>
                                <div class="description-content">
                                    {!! nl2br($agenda->deskripsi) !!}
                                </div>
                            </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="event-actions">
                                <a href="{{ route('agenda.index') }}" class="btn-action tertiary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Countdown Card -->
                    @if(!$isPast)
                    <div class="countdown-card" data-aos="fade-up">
                        <h4><i class="fas fa-hourglass-half me-2"></i> Hitung Mundur</h4>
                        @if($isToday)
                        <div class="countdown-display today">
                            <div class="countdown-icon">
                                <i class="fas fa-circle"></i>
                            </div>
                            <div class="countdown-text">
                                <h3>Sedang Berlangsung</h3>
                                <p>Kegiatan berlangsung hari ini</p>
                            </div>
                        </div>
                        @else
                        <div class="countdown-display">
                            <div class="countdown-number">{{ abs($daysUntil) }}</div>
                            <div class="countdown-label">Hari Lagi</div>
                            <div class="countdown-detail">
                                {{ $tanggal->diffForHumans() }}
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Info Box -->
                    <div class="info-box-agenda" data-aos="fade-up" data-aos-delay="100">
                        <h4><i class="fas fa-info-circle me-2"></i> Informasi Kontak</h4>
                        <div class="contact-info-list">
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <strong>Telepon</strong>
                                    <p>(0371) 123456</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <strong>Email</strong>
                                    <p>agenda@sumbawakab.go.id</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <strong>Alamat</strong>
                                    <p>Kantor Diskominfo Sumbawa</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Agenda -->
                    @if($agendaTerkait->count() > 0)
                    <div class="related-agenda-box" data-aos="fade-up" data-aos-delay="200">
                        <h4><i class="fas fa-calendar-alt me-2"></i> Agenda Terkait</h4>
                        <div class="related-agenda-list">
                            @foreach($agendaTerkait as $terkait)
                                @php
                                    $terkaitTanggal = \Carbon\Carbon::parse($terkait->tanggal);
                                @endphp
                                <a href="{{ route('agenda.detail', $terkait->slug) }}" class="related-agenda-item">
                                    <div class="related-date-mini">
                                        <div class="mini-day">{{ $terkaitTanggal->format('d') }}</div>
                                        <div class="mini-month">{{ $terkaitTanggal->translatedFormat('M') }}</div>
                                    </div>
                                    <div class="related-info">
                                        <h5>{{ $terkait->agenda }}</h5>
                                        <p>
                                            <i class="fas fa-clock me-1"></i>
                                            {{ substr($terkait->jam_mulai, 0, 5) }}
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ Str::limit($terkait->tempat, 20) }}
                                        </p>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        function addToCalendar() {
            const title = '{{ $agenda->agenda }}';
            const description = '{{ strip_tags($agenda->deskripsi) }}';
            const location = '{{ $agenda->tempat }}';
            const startDate = '{{ $tanggal->format("Ymd") }}';
            const startTime = '{{ str_replace(":", "", $agenda->jam_mulai) }}';
            const endTime = '{{ str_replace(":", "", $agenda->jam_selesai) }}';
            
            const googleCalendarUrl = `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(title)}&dates=${startDate}T${startTime}/${startDate}T${endTime}&details=${encodeURIComponent(description)}&location=${encodeURIComponent(location)}`;
            
            window.open(googleCalendarUrl, '_blank');
        }

        function shareEvent() {
            const title = '{{ $agenda->agenda }}';
            const url = window.location.href;
            
            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                }).catch(console.error);
            } else {
                // Fallback: Copy to clipboard
                navigator.clipboard.writeText(url).then(() => {
                    alert('Link agenda telah disalin ke clipboard!');
                });
            }
        }
    </script>
    @endpush
</div>
