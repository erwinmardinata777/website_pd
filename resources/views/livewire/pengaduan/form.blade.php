<div>
<style>
/* ==================== LOADING STATES ==================== */

/* Loading Overlay */
.loading-overlay {
  position: relative;
}

.loading-spinner-inline {
  margin-top: 8px;
  color: #667eea;
  font-size: 14px;
  font-weight: 600;
}

.loading-spinner-inline i {
  margin-right: 8px;
}

/* File Upload Loading */
.file-upload-loading {
  text-align: center;
  padding: 40px 20px;
}

/* Wire Loading - Prevent Content Jump */
[wire\:loading\.class="loading-overlay"] {
  opacity: 1 !important;
  transition: opacity 0.3s ease;
}

/* Smooth Transition */
[wire\:loading\.remove] {
  transition: opacity 0.2s ease-in-out;
}

[wire\:loading] [wire\:loading\.remove] {
  opacity: 0;
  pointer-events: none;
}

/* Button Loading State */
.btn-submit:disabled,
.btn-reset:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

/* Select Loading State */
select:disabled {
  background-color: #f8f9fa;
  cursor: not-allowed;
  opacity: 0.7;
}

/* Loading Spinner Animation */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.fa-spin {
  animation: spin 1s linear infinite;
}

/* Prevent Layout Shift */
.form-select,
.form-control {
  min-height: 48px;
}

/* File Upload Smooth Transition */
.file-upload-wrapper {
  min-height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

.file-upload-wrapper > div {
  width: 100%;
}

</style>
    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Form Pengaduan</li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="page-title" data-aos="fade-up">
                <h1>Form Pengaduan Masyarakat</h1>
                <p>
                    Sampaikan aspirasi, keluhan, dan saran Anda untuk pelayanan yang lebih baik
                </p>
            </div>

            <div class="row">
                <!-- Main Form -->
                <div class="col-lg-8">
                    <!-- Alert Box -->
                    <div class="alert-box" data-aos="fade-up">
                        <h6><i class="fas fa-info-circle"></i> Ketentuan Pengaduan</h6>
                        <ul>
                            <li>Isi data dengan lengkap dan benar</li>
                            <li>Jelaskan kronologi kejadian dengan detail dan jelas</li>
                            <li>Lampirkan bukti pendukung jika ada (opsional)</li>
                            <li>Data pribadi Anda akan dijaga kerahasiaannya</li>
                            <li>Pengaduan akan ditindaklanjuti maksimal 3x24 jam</li>
                        </ul>
                    </div>

                    <!-- Form Card -->
                    <div class="form-card" data-aos="fade-up">
                        <form wire:submit.prevent="submit">
                            <!-- Nama Lengkap -->
                            <div class="mb-4">
                                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    wire:model="nama" placeholder="Masukkan nama lengkap Anda" />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nomor Telepon/WA -->
                            <div class="mb-4">
                                <label class="form-label">Nomor Telepon/WhatsApp <span
                                        class="required">*</span></label>
                                <input type="tel" class="form-control @error('telp') is-invalid @enderror"
                                    wire:model="telp" placeholder="08xx xxxx xxxx" />
                                @error('telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Pastikan nomor aktif untuk konfirmasi pengaduan
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-4">
                                <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" wire:model="alamat"
                                    rows="3" placeholder="Jalan, RT/RW, Kelurahan/Desa"></textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kecamatan & Desa -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Kecamatan <span class="required">*</span></label>
                                    <div wire:loading.class="loading-overlay" wire:target="kode_kecamatan">
                                        <select class="form-select @error('kode_kecamatan') is-invalid @enderror"
                                            wire:model.live="kode_kecamatan">
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach ($kecamatans as $kecamatan)
                                                <option value="{{ $kecamatan->kode_kecamatan }}">
                                                    {{ $kecamatan->nama_kecamatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div wire:loading wire:target="kode_kecamatan" class="loading-spinner-inline">
                                            <i class="fas fa-spinner fa-spin"></i> Memuat desa...
                                        </div>
                                    </div>
                                    @error('kode_kecamatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Kelurahan/Desa <span class="required">*</span></label>
                                    <div wire:loading.class="loading-overlay" wire:target="kode_kecamatan">
                                        <select class="form-select @error('kode_desa') is-invalid @enderror"
                                            wire:model="kode_desa" {{ empty($desas) ? 'disabled' : '' }}>
                                            <option value="">
                                                {{ empty($desas) ? 'Pilih Kecamatan terlebih dahulu' : 'Pilih Kelurahan/Desa' }}
                                            </option>
                                            @foreach ($desas as $desa)
                                                <option value="{{ $desa->kode_desa }}">{{ $desa->nama_desa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('kode_desa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Pilih kecamatan terlebih dahulu
                                    </div>
                                </div>
                            </div>

                            <!-- Judul Pengaduan -->
                            <div class="mb-4">
                                <label class="form-label">Judul Pengaduan <span class="required">*</span></label>
                                <input type="text" class="form-control @error('pengaduan') is-invalid @enderror"
                                    wire:model="pengaduan" placeholder="Ringkasan singkat pengaduan Anda"
                                    maxlength="200" />
                                @error('pengaduan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="char-counter">
                                    {{ strlen($pengaduan ?? '') }}/200
                                </div>
                            </div>

                            <!-- Kronologi/Detail Pengaduan -->
                            <div class="mb-4">
                                <label class="form-label">Kronologi/Detail Pengaduan <span
                                        class="required">*</span></label>
                                <textarea class="form-control @error('isi_pengaduan') is-invalid @enderror"
                                    wire:model="isi_pengaduan" rows="10"
                                    placeholder="Jelaskan secara detail kronologi kejadian yang Anda laporkan. Sertakan informasi seperti:
- Apa yang terjadi?
- Kapan kejadiannya?
- Dimana lokasinya?
- Siapa yang terlibat?
- Bagaimana kronologinya?" maxlength="2000"></textarea>
                                @error('isi_pengaduan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="char-counter">
                                    {{ strlen($isi_pengaduan ?? '') }}/2000
                                </div>
                                <div class="form-text">
                                    Minimal 50 karakter. Jelaskan dengan detail agar dapat segera ditindaklanjuti
                                </div>
                            </div>

                            <!-- Upload Bukti Pendukung -->
                            <div class="mb-4">
                                <label class="form-label">Upload Bukti Pendukung
                                    <span style="color: #999; font-weight: 400">(Opsional)</span>
                                </label>
                                <div class="file-upload-wrapper">
                                    <input type="file" wire:model="bukti" id="fileInput"
                                        accept="image/*,.pdf,.doc,.docx" class="@error('bukti') is-invalid @enderror" />
                                    
                                    <!-- Loading state -->
                                    <div wire:loading wire:target="bukti" class="file-upload-loading">
                                        <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #667eea;"></i>
                                        <p style="margin-top: 15px; color: #667eea; font-weight: 600;">Mengupload file...</p>
                                    </div>

                                    <!-- Default state (hide when loading) -->
                                    <div wire:loading.remove wire:target="bukti">
                                        <div class="file-upload-icon">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>
                                        <div class="file-upload-text">
                                            <strong>Klik atau seret file ke sini</strong><br />
                                            <small>Format: JPG, PNG, PDF, DOC (Maks. 2MB)</small>
                                        </div>
                                    </div>
                                </div>
                                
                                @error('bukti')
                                    <div class="text-danger mt-2" style="font-size: 14px;">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                                
                                @if ($bukti)
                                    <div class="mt-3 p-3" style="background: #e8f5e9; border-radius: 10px; border-left: 4px solid #28a745;">
                                        <i class="fas fa-check-circle" style="color: #28a745;"></i> 
                                        <strong>File terpilih:</strong> {{ $bukti->getClientOriginalName() }}
                                        <span style="color: #666; font-size: 13px;">
                                            ({{ number_format($bukti->getSize() / 1024, 2) }} KB)
                                        </span>
                                    </div>
                                @endif
                                
                                <div class="form-text mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Upload foto, video, atau dokumen sebagai bukti pendukung (bila ada)
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="text-center mt-5">
                                <button type="button" class="btn-reset me-3" wire:click="resetForm"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-redo me-2"></i> Reset Form
                                </button>
                                <button type="submit" class="btn-submit" wire:loading.attr="disabled" wire:target="submit">
                                    <span wire:loading.remove wire:target="submit">
                                        <i class="fas fa-paper-plane me-2"></i> Kirim Pengaduan
                                    </span>
                                    <span wire:loading wire:target="submit">
                                        <i class="fas fa-spinner fa-spin me-2"></i> Mengirim...
                                    </span>
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <small class="text-muted">
                                    <i class="fas fa-lock me-1"></i>
                                    Data Anda dijamin aman dan terlindungi
                                </small>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Info Box -->
                    <div class="info-box" data-aos="fade-up">
                        <h5><i class="fas fa-info-circle"></i> Informasi Penting</h5>

                        <div class="info-item">
                            <i class="fas fa-user-shield"></i>
                            <div class="info-item-text">
                                <strong>Privasi Terjamin</strong>
                                <p>
                                    Data Anda akan dijaga kerahasiaannya sesuai UU Perlindungan Data Pribadi
                                </p>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div class="info-item-text">
                                <strong>Respon Cepat</strong>
                                <p>Maksimal 3x24 jam kami akan merespon pengaduan Anda</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="fas fa-chart-line"></i>
                            <div class="info-item-text">
                                <strong>Tracking Status</strong>
                                <p>
                                    Pantau perkembangan pengaduan melalui nomor tiket yang diberikan
                                </p>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="fas fa-headset"></i>
                            <div class="info-item-text">
                                <strong>Kontak Bantuan</strong>
                                <p>
                                    WA: 0812-3456-7890<br />Email: pengaduan@sumbawakab.go.id
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="stats-box" data-aos="fade-up" data-aos-delay="100">
                        <h5 style="color: #1e3c72; font-weight: 700; margin-bottom: 25px">
                            <i class="fas fa-chart-bar me-2"></i> Statistik Pengaduan
                        </h5>
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-number">{{ \App\Models\Pengaduan::count() }}</div>
                                <div class="stat-label">Total Pengaduan</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number" style="color: #28a745">
                                    {{ \App\Models\Pengaduan::where('status', 'selesai')->count() }}
                                </div>
                                <div class="stat-label">Selesai</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number" style="color: #ffc107">
                                    {{ \App\Models\Pengaduan::where('status', 'proses')->count() }}
                                </div>
                                <div class="stat-label">Dalam Proses</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number" style="color: #17a2b8">
                                    {{ \App\Models\Pengaduan::where('status', 'baru')->count() }}
                                </div>
                                <div class="stat-label">Baru</div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-muted">Data per {{ now()->translatedFormat('F Y') }}</small>
                        </div>
                    </div>

                    <!-- Contact Box -->
                    <div class="stats-box" data-aos="fade-up" data-aos-delay="200">
                        <h5 style="color: #1e3c72; font-weight: 700; margin-bottom: 20px">
                            <i class="fas fa-phone-alt me-2"></i> Butuh Bantuan?
                        </h5>
                        <p style="color: #666; font-size: 14px; line-height: 1.6">
                            Jika mengalami kesulitan dalam mengisi form, hubungi kami:
                        </p>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-top: 15px">
                            <div style="margin-bottom: 10px">
                                <i class="fas fa-phone" style="color: #667eea; margin-right: 10px"></i>
                                <strong>(0371) 123456</strong>
                            </div>
                            <div style="margin-bottom: 10px">
                                <i class="fab fa-whatsapp" style="color: #25d366; margin-right: 10px"></i>
                                <strong>0812-3456-7890</strong>
                            </div>
                            <div>
                                <i class="fas fa-envelope" style="color: #667eea; margin-right: 10px"></i>
                                <strong>pengaduan@sumbawakab.go.id</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Action -->
                    <div class="stats-box" data-aos="fade-up" data-aos-delay="300"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white">
                        <h5 style="color: white; font-weight: 700; margin-bottom: 20px; border-bottom: none">
                            <i class="fas fa-bolt me-2"></i> Aksi Cepat
                        </h5>
                        <a href="{{ route('pengaduan.list') }}" class="btn w-100 mb-3"
                            style="background: white; color: #667eea; font-weight: 600; padding: 12px; border-radius: 10px; text-decoration: none; display: block">
                            <i class="fas fa-list me-2"></i> Lihat Daftar Pengaduan
                        </a>
                        <a href="#" class="btn w-100"
                            style="background: rgba(255, 255, 255, 0.2); color: white; font-weight: 600; padding: 12px; border-radius: 10px; text-decoration: none; display: block; border: 2px solid rgba(255, 255, 255, 0.3)">
                            <i class="fas fa-search me-2"></i> Cek Status Pengaduan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sweet Alert Scripts -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('pengaduanBerhasil', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Pengaduan Berhasil Dikirim!',
                    html: `
                        <div style="text-align: left; padding: 20px;">
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                                <p style="margin: 0 0 10px 0; color: #666;">Nomor Tiket Pengaduan Anda:</p>
                                <h3 style="color: #667eea; font-weight: 700; margin: 0; font-size: 28px;">${event.ticketNumber}</h3>
                            </div>
                            <p>Pengaduan Anda telah kami terima dan akan segera ditindaklanjuti oleh tim kami.</p>
                            <div style="background: #e8f5e9; padding: 15px; border-radius: 10px; margin: 15px 0;">
                                <p style="margin: 0; color: #2e7d32;"><strong>Pelapor:</strong> ${event.nama}</p>
                                <p style="margin: 5px 0 0 0; color: #2e7d32;"><strong>Lokasi:</strong> ${event.desa}, Kec. ${event.kecamatan}</p>
                            </div>
                            <hr>
                            <div style="font-size: 14px; color: #666;">
                                <p style="margin: 8px 0;"><i class="fas fa-check-circle" style="color: #28a745; margin-right: 10px;"></i> Nomor tiket telah dikirim ke nomor WhatsApp Anda</p>
                                <p style="margin: 8px 0;"><i class="fas fa-clock" style="color: #ffc107; margin-right: 10px;"></i> Respon maksimal 3x24 jam kerja</p>
                                <p style="margin: 8px 0;"><i class="fas fa-user-headset" style="color: #17a2b8; margin-right: 10px;"></i> Anda akan dihubungi jika diperlukan klarifikasi</p>
                            </div>
                        </div>
                    `,
                    confirmButtonText: '<i class="fas fa-check me-2"></i> Selesai',
                    confirmButtonColor: '#667eea',
                    width: 600
                });
            });

            Livewire.on('pengaduanGagal', (event) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengirim Pengaduan',
                    text: event.message,
                    confirmButtonColor: '#667eea'
                });
            });
        });
    </script>
    @endpush
</div>
