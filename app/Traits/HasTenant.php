<?php

namespace App\Traits;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Builder;

trait HasTenant
{
    /**
     * Boot the trait
     */
    protected static function bootHasTenant()
    {
        // Auto-fill opds_id saat creating
        static::creating(function ($model) {
            // Skip jika di admin panel dan user adalah super admin
            if (request()->is('admin/*') && auth()->check() && auth()->user()->opds_id === null) {
                // Super admin bisa create tanpa opds_id
                return;
            }

            if (auth()->check() && auth()->user()->opds_id && !$model->opds_id) {
                $model->opds_id = auth()->user()->opds_id;
            }
        });

        // ✅ JANGAN apply global scope jika di admin panel
        if (!request()->is('admin') && !request()->is('admin/*')) {
            static::addGlobalScope(new TenantScope);
        }
    }

    /**
     * Query tanpa tenant scope (untuk admin)
     */
    public function scopeWithoutTenant(Builder $builder)
    {
        return $builder->withoutGlobalScope(TenantScope::class);
    }

    /**
     * Query untuk tenant tertentu
     */
    public function scopeForTenant(Builder $builder, $tenantId)
    {
        return $builder->withoutGlobalScope(TenantScope::class)
                      ->where('opds_id', $tenantId);
    }

    /**
     * Query semua data (untuk super admin)
     */
    public function scopeAllTenants(Builder $builder)
    {
        return $builder->withoutGlobalScope(TenantScope::class);
    }
}
