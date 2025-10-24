<?php

namespace App\Services;

use App\Models\Visitor;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

class VisitorTracker
{
    protected $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    /**
     * Track visitor
     */
    public function track()
    {
        $ipAddress = $this->getIpAddress();
        $today = now()->toDateString();

        // Check if visitor exists today
        $visitor = Visitor::where('ip_address', $ipAddress)
            ->where('visit_date', $today)
            ->first();

        if ($visitor) {
            // Update page views for existing visitor
            $visitor->increment('page_views');
        } else {
            // Create new visitor record
            Visitor::create([
                'ip_address' => $ipAddress,
                'user_agent' => Request::userAgent(),
                'device' => $this->getDevice(),
                'browser' => $this->getBrowser(),
                'platform' => $this->getPlatform(),
                'page_url' => Request::fullUrl(),
                'referrer' => Request::header('referer'),
                'visit_date' => $today,
                'page_views' => 1,
            ]);
        }
    }

    /**
     * Get visitor IP address
     */
    protected function getIpAddress()
    {
        foreach (['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'] as $key) {
            if (array_key_exists($key, $_SERVER)) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return Request::ip();
    }

    /**
     * Get device type
     */
    protected function getDevice()
    {
        if ($this->agent->isMobile()) {
            return 'mobile';
        } elseif ($this->agent->isTablet()) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }

    /**
     * Get browser name
     */
    protected function getBrowser()
    {
        return $this->agent->browser();
    }

    /**
     * Get platform/OS
     */
    protected function getPlatform()
    {
        return $this->agent->platform();
    }
}
