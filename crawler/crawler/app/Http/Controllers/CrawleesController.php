<?php

namespace App\Http\Controllers;

use App\Models\Crawlees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CrawleeStoreRequest;
use App\Services\CrawlerService;
use App\Services\BrowserShotService;
use Illuminate\Support\Facades\Log;

class CrawleesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $browserShotService = null;

    public function __construct(BrowserShotService $browserShotService)
    {
        $this->browserShotService = $browserShotService;
    }

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
        $crawlerService = new CrawlerService($url);
        if (!$crawlerService->getCrawler()) {
            return response()->json([
                'code' => 200,
                'message' => 'Invalid URL',
                'data' => []
            ], 200); 
        }

        $webDescription = $crawlerService->getDescription();
        $webTitle = $crawlerService->getTitle();
        $webBody = $crawlerService->getBody();
        $screenshotPath = $this->browserShotService->getScreenShot($url);
        if (!$screenshotPath) {
            return response()->json([
                'code' => 200,
                'message' => 'Screenshot Error.',
                'data' => []
            ], 200); 
        }
        $crawledData = [
            'url' => $url,
            'contents' => json_encode([
                'title' => $webTitle,
                'description' => $webDescription,
                'body' => $webBody
            ]),
            'screenshot_path' => $screenshotPath
        ];
        try {
            DB::beginTransaction();
            $crawledData = Crawlees::create($crawledData);
            DB::commit();
            
            $crawledData['contents'] = json_decode($crawledData['contents']);
            return response()->json([
                'code' => 201,
                'message' => 'Success',
                'data' => $crawledData
            ], 201);

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
