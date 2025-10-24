<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'device',
        'browser',
        'platform',
        'page_url',
        'referrer',
        'visit_date',
        'page_views',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    // Get total unique visitors
    public static function getTotalVisitors()
    {
        return self::distinct('ip_address')->count('ip_address');
    }

    // Get total page views
    public static function getTotalPageViews()
    {
        return self::sum('page_views');
    }

    // Get today visitors
    public static function getTodayVisitors()
    {
        return self::whereDate('visit_date', today())
            ->distinct('ip_address')
            ->count('ip_address');
    }

    // Get this month visitors
    public static function getMonthVisitors()
    {
        return self::whereYear('visit_date', date('Y'))
            ->whereMonth('visit_date', date('m'))
            ->distinct('ip_address')
            ->count('ip_address');
    }

    // Get visitors by date range
    public static function getVisitorsByDateRange($startDate, $endDate)
    {
        return self::whereBetween('visit_date', [$startDate, $endDate])
            ->distinct('ip_address')
            ->count('ip_address');
    }
}
