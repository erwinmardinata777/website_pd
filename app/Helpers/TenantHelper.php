<?php

namespace App\Helpers;

class TenantHelper
{
    /**
     * Get main domain URL
     */
    public static function getMainDomainUrl(): string
    {
        $scheme = request()->getScheme();
        return $scheme . '://web-pd.sumbawakab.go.id';
    }

    /**
     * Get current tenant URL
     */
    public static function getCurrentTenantUrl(): ?string
    {
        $tenant = config('app.current_tenant');
        $subdomain = config('app.current_subdomain');
        
        if (!$tenant || !$subdomain) {
            return null;
        }

        $scheme = request()->getScheme();
        return $scheme . '://' . $subdomain . '.sumbawakab.go.id';
    }

    /**
     * Get tenant URL by subdomain
     */
    public static function getTenantUrl(string $subdomain): string
    {
        $scheme = request()->getScheme();
        return $scheme . '://' . $subdomain . '.sumbawakab.go.id';
    }

    /**
     * Check if current request is from main domain
     */
    public static function isMainDomain(): bool
    {
        return config('app.is_main_domain', false);
    }

    /**
     * Get current tenant
     */
    public static function getCurrentTenant()
    {
        return config('app.current_tenant');
    }
}
