<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SitemapController extends Controller
{
    public function index()
    {
        // Define static URLs for the sitemap
        $urls = [
            ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => '/about', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/contact', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        // Add dynamic URLs (e.g., from a database)
        // Example: Fetch posts or products from the database
        /*
        $posts = \App\Models\Post::all();
        foreach ($posts as $post) {
            $urls[] = [
                'loc' => "/posts/{$post->slug}",
                'priority' => '0.7',
                'changefreq' => 'weekly',
            ];
        }
        */

        // Create XML content for the sitemap
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . url($url['loc']) . '</loc>';
            $xml .= '<priority>' . $url['priority'] . '</priority>';
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        // Save the XML to the public directory
        Storage::disk('public')->put('sitemap.xml', $xml);

        // Return a response indicating success
        return response()->json(['message' => 'Sitemap generated successfully']);
    }
}
