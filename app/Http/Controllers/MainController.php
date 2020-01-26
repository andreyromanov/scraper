<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;

class MainController extends Controller
{

    public function scrape(Request $request){

    	$url = $request->get('url');

    	$client = new Client();

    	$response = $client->request('GET', $url);

    	$response_status_code = $response->getStatusCode();
    	$html = $response->getBody()->getContents();

    	if($response_status_code == 200){
			$dom = HtmlDomParser::str_get_html($html);

			$song_items = $dom->find('li[class="chart-list__element"]'); 
			
			$count = 1;
			foreach ($song_items as $song_item) {
				if($count == 2){
					$song_title = $song_item->find('span[class="chart-element__information__song"]', 0);
					dd(trim($song_title->text()));
				}
				
				$count++;
			}
    	}
    }

}
