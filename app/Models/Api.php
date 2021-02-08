<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use Illuminate\Support\Arr;

class Api extends Model
{
    use HasFactory;

    public function fetchNewsFromSource($newsSource)
    {
    	$urlParams = 'top-headlines?sources=' . $newsSource;
    	$response = (new Helper)->makeApiCalls($urlParams);

    	return Arr::get($response,'articles');
    }

    public function getAllSources()
    {
    	$urlParams = 'sources?';

    	$response = (new Helper)->makeApiCalls($urlParams);

    	return Arr::get($response,'sources');
    }
}
