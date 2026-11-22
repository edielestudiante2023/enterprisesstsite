<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SeoIndexing implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        helper(['url', 'seo']);
        if (seo_is_utility_page(uri_string()) || $response->getStatusCode() >= 400) {
            $response->setHeader('X-Robots-Tag', 'noindex, nofollow');
        }
    }
}
