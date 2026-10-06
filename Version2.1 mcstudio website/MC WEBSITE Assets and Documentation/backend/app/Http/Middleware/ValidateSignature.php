<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Cache\CacheManager as Cache;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

class ValidateSignature extends Middleware
{
    /**
     * Cache manager
     *
     * @var \Illuminate\Cache\CacheManager
     */
    protected $cache;


    /**
     * Create a new ValidateSignature instance.
     *
     * @param  \Illuminate\Cache\CacheManager $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * The names of the query string parameters that should be ignored.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'fbclid',
        // 'utm_campaign',
        // 'utm_content',
        // 'utm_medium',
        // 'utm_source',
        // 'utm_term',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  bool $consume
     * @return \Illuminate\Http\Response
     *
     */
    public function handle($request, Closure $next, ...$args)
    {
        $consume = false; // Default value
        foreach ($args as $arg) {
            if ($arg === true || $arg === false) {
                $consume = $arg;
                break; // Found $consume, no need to continue searching
            }
        }
        if (($consume && $this->signatureConsumed($request)) || !$request->hasValidSignature()) {
            throw new InvalidSignatureException;
        }

        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        if ($consume && $response->isSuccessful()) {
            $this->consumeSignature($request);
        }


        return $response;
    }

    /**
     * Checks if the signature was consumed
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function signatureConsumed(Request $request)
    {
        return $this->cache->store('file')->has($this->cacheKey($request));
    }

    /**
     * Consumes the signature, marking it as unavailable
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function consumeSignature(Request $request)
    {
        $ttl = Carbon::createFromTimestamp($request->query('expires'));

        $this->cache->store('file')->put($this->cacheKey($request), null, $ttl);
    }

    /**
     * Return the cache Key to check
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    protected function cacheKey(Request $request)
    {
        return 'consumable|' . $request->query('signature');
    }

}
