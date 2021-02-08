<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Api;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
    public function displayNews(Request $request)
    {
    	$response = $this->determineMethodHadler($request);

    	$api = new Api();

    	$response['news'] = $api->fetchNewsFromSource($response['sourceId']);
    	$response['newsSources'] = $this->fetchAllNewsSources();

    	return view('welcome',$response);
    }

    protected function determineMethodHadler($request)
    {
    	if($request->isMethod('get'))
    	{
    		$response['sourceName'] = config('app.default_news_source');
    		$response['sourceId'] = config('app.default_news_source_id');
    	} else 
    	{
            $request->validate([
                'source' => 'required|string',
            ]);
            
            $split_input = explode(':', $request->source);
            $response['sourceId'] = trim($split_input[0]);
            $response['sourceName'] = trim($split_input[1]);
        }
        return $response;
    }

    public function fetchAllNewsSources()
    {
    	$response = Cache::remember('allNewsSources',22 * 60, function(){
    		$api = new Api;

    		return $api->getAllSources();
    	});

    	return $response;
    }
}
