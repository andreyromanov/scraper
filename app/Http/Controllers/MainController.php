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
				if($count == 1){
					$song_title = $song_item->find('span[class="chart-element__information__song"]', 0)->text();

					$song_artist = $song_item->find('span[class="chart-element__information__artist"]', 0)->text();
					

					dd(trim($song_artist));
				}
				
				$count++;
			}
    	}
    }

        public function Proscrape(Request $request){

    	$url = $request->get('url');

    	$client = new Client();

    	$response = $client->request('GET', $url,
    		[
    			'headers' => [
    				'Accept' => '*/*'
    			]
    		]);

    	$response_status_code = $response->getStatusCode();
    	$html = $response->getBody()->getContents();

    	$trimed = substr($html, 42, -43);
    	$cleaned = str_replace("\\n", "", $trimed);
    	$cleaned = str_replace("\\", "", $cleaned);

    	//dd($cleaned);

    	if($response_status_code == 200){
			$dom = HtmlDomParser::str_get_html($cleaned);

			$song_items = $dom->find('div[class="influencer-card"]');

			dd($song_items); 
			
			$count = 1;
			foreach ($song_items as $song_item) {
				if($count == 1){
					//$song_title = $song_item->find('span[class="chart-element__information__song"]', 0)->text();

					$song_artist = $song_item->find('h4', 0)->find('a', 0)->text();
					

					dd(trim($song_artist));
				}
				
				$count++;
			}
    	}
    }

}
