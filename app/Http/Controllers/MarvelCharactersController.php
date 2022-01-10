<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Cache;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MarvelCharactersController extends Controller
{
    private $client;

    public function __construct()
    {

        $ts = time();
        $hash = md5($ts . config('marvel.private_key') . config('marvel.public_key'));

        $this->client = new Client([
            'base_uri' => 'http://gateway.marvel.com/v1/public/',
            'query' => [
                'apikey' => config('marvel.public_key'),
                'ts' => $ts,
                'hash' => $hash,
            ],
        ]);

    }
    public function characters(Request $request)
    {
        //gets the array of charatcters from the cache
        $characters = Cache::get('characters');

        $current_page = LengthAwarePaginator::resolveCurrentPage();

        if (is_null($current_page)) {
            $current_page = 1;

        }

        $characters_collection = new Collection($characters);

        $items_per_page = 8;

        $current_page_results = $characters_collection->slice(($current_page - 1) * $items_per_page, $items_per_page)->all();
        $paginated_results = new LengthAwarePaginator($current_page_results, count($characters_collection), $items_per_page);

        return view('characters', ['paginated_results' => $paginated_results, 'characters' => $characters]);

    }
}
