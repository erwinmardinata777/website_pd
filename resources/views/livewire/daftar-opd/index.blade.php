<div>
    <style>
        /* Container & Layout */
        .container {
            max-width: 1280px;
        }

        /* Alert Styles */
        .alert-warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
        }

        /* Card Styles */
        .card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Badge Styles */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-blue {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-green {
            background-color: #d1fae5;
            color: #065f46;
        }

        /* Button Styles */
        .btn-primary {
            display: block;
            width: 100%;
            text-align: center;
            background-color: #2563eb;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateX(2px);
        }

        .btn-reset {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border: 1px solid transparent;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.375rem;
            color: #1d4ed8;
            background-color: #dbeafe;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-reset:hover {
            background-color: #bfdbfe;
        }

        /* Input Styles */
        .form-input, .form-select {
            width: 100%;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            ring: 2px;
            ring-color: #3b82f680;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        /* Grid */
        .grid {
            display: grid;
            gap: 1.5rem;
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        @media (min-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        /* Code/Subdomain Display */
        .code-block {
            display: flex;
            align-items: center;
            font-size: 0.75rem;
            color: #4b5563;
            background-color: #f9fafb;
            padding: 0.5rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .code-block code {
            font-family: 'Courier New', monospace;
            font-size: 0.75rem;
            word-break: break-all;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 0;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .empty-state svg {
            margin: 0 auto;
            height: 4rem;
            width: 4rem;
            color: #9ca3af;
        }

        .empty-state h3 {
            margin-top: 1rem;
            font-size: 1.125rem;
            font-weight: 500;
            color: #111827;
        }

        .empty-state p {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        /* Header */
        .page-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.875rem;
            }
        }

        /* Line Clamp */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .min-h-14 {
            min-height: 3.5rem;
        }

        /* SVG Icon */
        .icon {
            width: 1rem;
            height: 1rem;
            display: inline-block;
            vertical-align: middle;
        }

        .icon-sm {
            width: 0.75rem;
            height: 0.75rem;
        }

        .icon-lg {
            width: 1.5rem;
            height: 1.5rem;
        }

        /* Transitions */
        .transition-all {
            transition: all 0.3s ease;
        }

        .transition-transform {
            transition: transform 0.2s ease;
        }

        .group:hover .group-hover\:translate-x-1 {
            transform: translateX(0.25rem);
        }

        /* Utilities */
        .flex {
            display: flex;
        }

        .flex-shrink-0 {
            flex-shrink: 0;
        }

        .items-center {
            align-items: center;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: 700;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-medium {
            font-weight: 500;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-3 {
            margin-bottom: 0.75rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mb-8 {
            margin-bottom: 2rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .mt-6 {
            margin-top: 1.5rem;
        }

        .mr-1 {
            margin-right: 0.25rem;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }

        .ml-1 {
            margin-left: 0.25rem;
        }

        .ml-3 {
            margin-left: 0.75rem;
        }

        .p-2 {
            padding: 0.5rem;
        }

        .p-4 {
            padding: 1rem;
        }

        .p-6 {
            padding: 1.5rem;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .py-12 {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .rounded {
            border-radius: 0.25rem;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .border {
            border-width: 1px;
        }

        .border-gray-100 {
            border-color: #f3f4f6;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .break-all {
            word-break: break-all;
        }

        /* Colors */
        .text-gray-500 {
            color: #6b7280;
        }

        .text-gray-600 {
            color: #4b5563;
        }

        .text-gray-700 {
            color: #374151;
        }

        .text-gray-800 {
            color: #1f2937;
        }

        .text-gray-900 {
            color: #111827;
        }

        .text-gray-400 {
            color: #9ca3af;
        }

        .text-yellow-700 {
            color: #a16207;
        }

        .text-yellow-400 {
            color: #facc15;
        }

        .bg-white {
            background-color: #ffffff;
        }

        .bg-gray-50 {
            background-color: #f9fafb;
        }

        .bg-yellow-50 {
            background-color: #fef3c7;
        }

        .border-yellow-400 {
            border-color: #facc15;
        }

        .border-l-4 {
            border-left-width: 4px;
        }

        /* Focus ring */
        .focus\:ring-2:focus {
            --tw-ring-offset-shadow: 0 0 0 0px #fff;
            --tw-ring-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow);
        }

        .focus\:ring-blue-500:focus {
            --tw-ring-color: rgba(59, 130, 246, 0.5);
        }

        .focus\:border-blue-500:focus {
            border-color: #3b82f6;
        }

        .focus\:outline-none:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        /* Shadow */
        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Col span */
        .col-span-full {
            grid-column: 1 / -1;
        }

        /* Gap */
        .gap-4 {
            gap: 1rem;
        }

        .gap-6 {
            gap: 1.5rem;
        }
    </style>

    <div>
        <!-- Alert untuk subdomain tidak ditemukan -->
        @if(request()->has('from'))
            <!-- <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="icon text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Subdomain tidak ditemukan!</strong> 
                            OPD yang Anda cari tidak tersedia. Silakan pilih dari daftar OPD di bawah ini.
                        </p>
                    </div>
                </div>
            </div> -->
        @endif

        <!-- Header -->
        <div class="page-header">
            <a href="">
                <img src="{{ asset('image/logo-sumbawa.png') }}" alt="Logo Kabupaten Sumbawa" class="mx-auto mb-4" style="width: 100px;">
            </a>
            <h1 class="page-title">
                Daftar Organisasi Perangkat Daerah
            </h1>
        </div>
        <div class="container">
            <!-- Filter & Search -->
            <div class="card p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="form-label">
                            <svg class="icon mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cari OPD
                        </label>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Cari nama OPD atau subdomain..."
                            class="form-input"
                        >
                    </div>

                    <!-- Filter Status -->
                    <div>
                        <label class="form-label">
                            <svg class="icon mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Filter Jenis
                        </label>
                        <select 
                            wire:model.live="filterStatus"
                            class="form-select"
                        >
                            <option value="">Semua Jenis</option>
                            <option value="1">OPD</option>
                            <option value="2">Kecamatan</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- OPD Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse($opdList as $item)
                    <div class="card border border-gray-100 overflow-hidden">
                        <div class="p-6">
                            <!-- Badge Jenis -->
                            <div class="mb-3">
                                <span class="badge {{ $item->opd->status == 1 ? 'badge-blue' : 'badge-green' }}">
                                    <svg class="icon-sm mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $item->opd->status == 1 ? 'OPD' : 'Kecamatan' }}
                                </span>
                            </div>

                            <!-- Nama OPD -->
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 min-h-14">
                                {{ $item->opd->nama_opd }}
                            </h3>

                            <!-- Subdomain -->
                            <div class="code-block">
                                <svg class="icon mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                    </path>
                                </svg>
                                <code>{{ $item->subdomain }}.sumbawakab.go.id</code>
                            </div>

                            <!-- Button Kunjungi -->
                            <a 
                                href="https://{{ $item->subdomain }}.sumbawakab.go.id" 
                                target="_blank"
                                class="btn-primary group"
                            >
                                Kunjungi Website
                                <svg class="icon ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <h3>Tidak ada OPD ditemukan</h3>
                            <p>Coba ubah filter atau kata kunci pencarian Anda.</p>
                            @if($search || $filterStatus)
                                <button 
                                    wire:click="$set('search', ''); $set('filterStatus', '')"
                                    class="btn-reset mt-4"
                                >
                                    <svg class="icon mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Reset Filter
                                </button>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($opdList->hasPages())
                <div class="mt-6">
                    {{ $opdList->links() }}
                </div>
            @endif

        </div>
    </div>
</div>
