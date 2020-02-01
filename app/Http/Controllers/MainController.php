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
    				'Accept' => '*/*',
    				'Content-type' => 'application/json'
    			],
    			'query' =>[
						  "category_ids" =>  [
						    0 => "",
						    1 => "56b23bfe4a047d39e90001ea"
						  ],
						  "follower_max" => "1000000",
						  "follower_min" => "5000",
						  "is_claimed" => "true",
						  "limit" => "1000",
						  "location_ids" => [
						    0 => ""
						  ],
						  "offset" => "0",
						  "page" => "0",
						  "ranking_score" => "true",
						  "search_type" => "influencer"
						]
    		]);

    	$response_status_code = $response->getStatusCode();
    	$html = $response->getBody()->getContents();

    	dd($html);

    	$trimed = substr($html, 42, -43);
    	$cleaned = str_replace("\\n", "", $trimed);
    	$cleaned = str_replace("\\", "", $cleaned);

    	

    	if($response_status_code == 200){
			$dom = HtmlDomParser::str_get_html($cleaned);

			$song_items = $dom->find('div[class="influencer-card"]');

			//dd($song_items); 
			
			$count = 1;
			foreach ($song_items as $song_item) {
				if($count == 1){
					//$song_title = $song_item->find('span[class="chart-element__information__song"]', 0)->text();

					$song_artist = $song_item->find('h4', 0)->find('a', 0)->text();
					

					//dd(trim($song_artist));
				}
				
				$count++;
			}
    	}
    }


        public function grammar(Request $request){

    	$url = 'http://learn-chinese.ru/index/0-6';

    	$client = new Client();

    	$response = $client->request('GET', $url);

    	$response_status_code = $response->getStatusCode();

    	$html = $response->getBody()->getContents();

    	if($response_status_code == 200){

			$dom = HtmlDomParser::str_get_html($html);

			$title = $dom->find('div[class="article-title"]',0)->text(); 
			//dd($title);
			$song_items = $dom->find('div[class="content"]',0)->text(); 
			
			//dd($song_items);
			/*foreach ($song_items as $song_item) {
				
					$song_title = $song_item->find('span[class="chart-element__information__song"]', 0)->text();

					$song_artist = $song_item->find('span[class="chart-element__information__artist"]', 0)->text();
			}*/
    	}

    	return view('grammar.index', [
    		'title' => $title,
    		'text' => $song_items
    	]);
    }

        public function Promusic(Request $request){

    	$url = $request->get('url');

    	$client = new Client();

    	$response = $client->request('GET', $url,
    		[
    			'headers' => [
    				'Accept' => '*/*',
    				'Content-type' => 'application/json',
    				'verify' => false
    			],
    			'verify' => false
    		]);

    	$response_status_code = $response->getStatusCode();
    	$html = $response->getBody()->getContents();

    	dd($html);

    	$trimed = substr($html, 42, -43);
    	$cleaned = str_replace("\\n", "", $trimed);
    	$cleaned = str_replace("\\", "", $cleaned);

    	

    	if($response_status_code == 200){
			$dom = HtmlDomParser::str_get_html($cleaned);

			$song_items = $dom->find('div[class="influencer-card"]');

			//dd($song_items); 
			
			$count = 1;
			foreach ($song_items as $song_item) {
				if($count == 1){
					//$song_title = $song_item->find('span[class="chart-element__information__song"]', 0)->text();

					$song_artist = $song_item->find('h4', 0)->find('a', 0)->text();
					

					//dd(trim($song_artist));
				}
				
				$count++;
			}
    	}
    }

}
