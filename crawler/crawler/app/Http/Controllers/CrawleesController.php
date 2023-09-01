<?php

namespace App\Http\Controllers;

use App\Models\Crawlees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CrawleeStoreRequest;
use App\Services\CrawlerService;


class CrawleesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'code' => 200,
            'message' => '',
            'data' => []
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrawleeStoreRequest $request)
    {
        $url = $request->get('url');
        $crawler = (new CrawlerService($url))->getCrawler();
        if (!$crawler) {
            return response()->json([
                'code' => 200,
                'message' => 'Invalid URL',
                'data' => []
            ], 200); 
        }

        $web_description = $crawler->getDescription();
        $web_title = $crawler->getTitle();
        $web_body = $crawler->getBody();

        $crawled_data = [
            'url' => $url,
            'contents' => json_encode([
                'title' => $web_title,
                'description' => $web_description ? $web_description[0] : '',
                'body' => $web_body
            ]),
        ];

        try {
            DB::beginTransaction();
            $crawled_data = Crawlees::create($crawled_data);
            DB::commit();
            
            $crawled_data['contents'] = json_decode($crawled_data['contents']);
            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => $crawled_data
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            log::error('Fail to create Crawlee data.', ['message' => $e->getMessage()]);
            return response()->json([
                'code' => 200,
                'message' => 'Fail',
                'data' => []
            ], 200); 
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Crawlees $crawlees)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Crawlees $crawlees)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Crawlees $crawlees)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crawlees $crawlees)
    {
        //
    }
}
