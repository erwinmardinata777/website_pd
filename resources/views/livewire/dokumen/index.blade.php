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
            <h1 data-aos="fade-up">Dokumen Publik</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Dokumen Publik</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Filter Bar -->
            <div class="filter-bar" data-aos="fade-up">
                <div class="row">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" 
                                   wire:model.live.debounce.500ms="search" 
                                   placeholder="Cari dokumen..." />
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <select class="form-select" wire:model.live="filterKategori">
                            <option value="">Semua Kategori</option>
                            @foreach($allKategoris as $kategori)
                                <option value="{{ $kategori->id }}">
                                    {{ $kategori->judul }} ({{ $kategori->dokumens_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Dokumen Tables by Kategori -->
            @forelse($kategoris as $kategoriIndex => $kategori)
                @if($kategori->dokumens->count() > 0)
                <div class="kategori-section" data-aos="fade-up" data-aos-delay="{{ $kategoriIndex * 100 }}">
                    <!-- Kategori Header -->
                    <div class="kategori-header">
                        <div class="kategori-title">
                            <i class="fas fa-folder-open me-2"></i>
                            <h3>{{ $kategori->judul }}</h3>
                            <span class="kategori-count">{{ $kategori->dokumens->count() }} Dokumen</span>
                        </div>
                    </div>

                    <!-- Dokumen Table -->
                    <div class="table-responsive">
                        <table class="dokumen-table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 8%;">Tipe</th>
                                    <th style="width: 37%;">Nama Dokumen</th>
                                    <th style="width: 12%;">Tanggal</th>
                                    <th style="width: 10%;">Unduhan</th>
                                    <th style="width: 10%;">Views</th>
                                    <th style="width: 18%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategori->dokumens as $index => $dokumen)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="file-badge file-badge-{{ $dokumen->type_file }}">
                                            @switch($dokumen->type_file)
                                                @case('pdf')
                                                    <i class="fas fa-file-pdf"></i>
                                                    @break
                                                @case('doc')
                                                @case('docx')
                                                    <i class="fas fa-file-word"></i>
                                                    @break
                                                @case('xls')
                                                @case('xlsx')
                                                    <i class="fas fa-file-excel"></i>
                                                    @break
                                                @case('ppt')
                                                @case('pptx')
                                                    <i class="fas fa-file-powerpoint"></i>
                                                    @break
                                                @default
                                                    <i class="fas fa-file-alt"></i>
                                            @endswitch
                                            {{ strtoupper($dokumen->type_file) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dokumen-info">
                                            <strong class="dokumen-name">{{ $dokumen->judul }}</strong>
                                            @if($dokumen->deskripsi)
                                            <small class="dokumen-desc">{{ Str::limit($dokumen->deskripsi, 80) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-alt me-1 text-muted"></i>
                                        {{ \Carbon\Carbon::parse($dokumen->tanggal)->format('d M Y') }}
                                    </td>
                                    <td>
                                        <i class="fas fa-download me-1 text-success"></i>
                                        {{ number_format($dokumen->download) }}
                                    </td>
                                    <td>
                                        <i class="fas fa-eye me-1 text-info"></i>
                                        {{ number_format($dokumen->hits) }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group-action">
                                            @if($dokumen->text)
                                            <button type="button"
                                                    class="btn-action btn-preview-small" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#previewModal{{ $dokumen->id }}"
                                                    title="Preview Dokumen">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @else
                                            <button wire:click="downloadDokumen({{ $dokumen->id }})" 
                                                    class="btn-action btn-download-small"
                                                    wire:loading.attr="disabled"
                                                    wire:target="downloadDokumen({{ $dokumen->id }})"
                                                    title="Unduh Dokumen">
                                                <span wire:loading.remove wire:target="downloadDokumen({{ $dokumen->id }})">
                                                    <i class="fas fa-download"></i>
                                                </span>
                                                <span wire:loading wire:target="downloadDokumen({{ $dokumen->id }})">
                                                    <i class="fas fa-spinner fa-spin"></i>
                                                </span>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            @empty
                <div class="empty-state" data-aos="fade-up">
                    <i class="fas fa-file-alt"></i>
                    <h4>Tidak Ada Dokumen</h4>
                    <p>
                        @if($search)
                            Tidak ada dokumen yang sesuai dengan pencarian "{{ $search }}"
                        @elseif($filterKategori)
                            Tidak ada dokumen dalam kategori ini
                        @else
                            Belum ada dokumen yang tersedia
                        @endif
                    </p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Preview Modals (Outside the table loop) -->
    @foreach($kategoris as $kategori)
        @foreach($kategori->dokumens as $dokumen)
            @if($dokumen->text)
            <div class="modal fade" id="previewModal{{ $dokumen->id }}" tabindex="-1" aria-labelledby="previewModalLabel{{ $dokumen->id }}" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title-wrapper">
                                <h5 class="modal-title" id="previewModalLabel{{ $dokumen->id }}">
                                    <i class="fas fa-file-alt me-2"></i>{{ $dokumen->judul }}
                                </h5>
                                <div class="modal-subtitle">
                                    <span class="badge bg-primary me-2">{{ strtoupper($dokumen->type_file) }}</span>
                                    <span class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($dokumen->tanggal)->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="document-preview">
                                {!! $dokumen->text !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Tutup
                            </button>
                            <button wire:click="downloadDokumen({{ $dokumen->id }})" 
                                    class="btn btn-primary"
                                    data-bs-dismiss="modal">
                                <i class="fas fa-download me-2"></i>Unduh Dokumen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    @endforeach

    @push('scripts')
    <script>
        // Ensure modals work properly with Livewire
        document.addEventListener('livewire:init', () => {
            // Re-initialize Bootstrap modals after Livewire updates
            Livewire.hook('morph.updated', () => {
                // Dispose old modals
                const modals = document.querySelectorAll('.modal');
                modals.forEach(modal => {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) {
                        bsModal.dispose();
                    }
                });
            });
        });

        // Handle modal close when clicking backdrop
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                const modal = bootstrap.Modal.getInstance(e.target);
                if (modal) {
                    modal.hide();
                }
            }
        });

        // Handle ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('.modal.show');
                openModals.forEach(modal => {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) {
                        bsModal.hide();
                    }
                });
            }
        });
    </script>
    @endpush
</div>
