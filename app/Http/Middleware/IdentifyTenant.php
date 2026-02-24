<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Opd;

class IdentifyTenant
{
    /**
     * Paths yang di-exclude dari tenant identification
     */
    protected array $excludedPaths = [
        'admin',
        'admin/*',
        'livewire/*',
        'filament/*',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Skip middleware untuk path admin Filament
        foreach ($this->excludedPaths as $path) {
            if ($request->is($path)) {
                // Set flag untuk admin
                config(['app.is_admin_panel' => true]);
                return $next($request);
            }
        }

        $host = $request->getHost();
        $scheme = $request->getScheme();
        
        // Parse hostname
        $parts = explode('.', $host);
        
        // Jika domain utama (web-pd.sumbawakab.go.id)
        if ($parts[0] === 'web-pd' && count($parts) >= 3) {
            config(['app.current_tenant' => null]);
            config(['app.is_main_domain' => true]);
            config(['app.is_admin_panel' => false]);
            view()->share('currentTenant', null);
            view()->share('isMainDomain', true);
            
            return $next($request);
        }
        
        // Jika subdomain (bkpsdm.sumbawakab.go.id, dinkes.sumbawakab.go.id)
        if (count($parts) >= 3 && $parts[0] !== 'web-pd') {
            $subdomain = $parts[0];
            
            // Cari user berdasarkan subdomain
            $user = User::withoutGlobalScope(\App\Models\Scopes\TenantScope::class)
                        ->where('subdomain', $subdomain)
                        ->whereNotNull('opds_id')
                        ->with('opd')
                        ->first();
            
            // Jika subdomain tidak ditemukan, redirect ke domain utama
            if (!$user || !$user->opd) {
                return redirect()->away($scheme . '://web-pd.sumbawakab.go.id/daftar-opd?from=' . urlencode($subdomain));
            }
            
            // Set tenant OPD
            $opd = $user->opd;
            
            config(['app.current_tenant' => $opd]);
            config(['app.current_tenant_id' => $opd->id]);
            config(['app.current_subdomain' => $subdomain]);
            config(['app.is_main_domain' => false]);
            config(['app.is_admin_panel' => false]);
            
            view()->share('currentTenant', $opd);
            view()->share('currentSubdomain', $subdomain);
            view()->share('isMainDomain', false);
            
            app()->instance('tenant', $opd);
        }
        
        return $next($request);
    }
}
