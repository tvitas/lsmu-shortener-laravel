<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Short;

class ShortsRedirectController extends Controller
{
    public function index($short, Client $client)
    {
        $short = Short::where('identifier', $short)
            ->where('active', true)
            ->where('expires', '>=', now())
            ->get(['url'])
            ->first();
        if (!empty($short->url)) {
            $statusCodes = [200, 301, 302];
            $urlIsLive = $client->request('HEAD', $short->url, ['timeout' => 4, 'allow_redirects' => false]);
            $statusCode = $urlIsLive->getStatusCode();
            if (in_array($statusCode, $statusCodes)) {
                return redirect()->away($short->url, 301);
            }
        }
        return abort(404, 'Not found');
    }
}
