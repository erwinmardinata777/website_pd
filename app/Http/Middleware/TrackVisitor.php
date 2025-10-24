<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\VisitorTracker;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    protected $tracker;

    public function __construct(VisitorTracker $tracker)
    {
        $this->tracker = $tracker;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Track visitor
        try {
            $this->tracker->track();
        } catch (\Exception $e) {
            // Log error but don't break the application
            \Log::error('Visitor tracking error: ' . $e->getMessage());
        }

        return $next($request);
    }
}
