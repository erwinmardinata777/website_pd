<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // ✅ Bypass scope jika sedang di admin panel atau user adalah super admin
        if ($this->shouldBypassScope()) {
            return;
        }

        // ✅ Hanya apply filter jika ada tenant
        if ($tenant = app('tenant')) {
            \Log::info('TenantScope Applied', [
                'model' => get_class($model),
                'table' => $model->getTable(),
                'tenant_id' => $tenant->id,
            ]);
            
            $builder->where($model->getTable() . '.opds_id', $tenant->id);
        }
    }

    /**
     * Check if scope should be bypassed
     */
    protected function shouldBypassScope(): bool
    {
        // Bypass jika request dari admin panel
        if (request()->is('admin') || request()->is('admin/*')) {
            return true;
        }

        // Bypass jika user adalah super admin (opds_id = null)
        if (auth()->check() && auth()->user()->opds_id === null) {
            return true;
        }

        return false;
    }
}
