<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Sangria\JSONResponse;
use GuzzleHttp\Client;

use Validator;
use Log;
use stdClass;
use Session;
use Exception;
use DB;


class GetRestaurants extends Controller
{

    public function geo(Request $request)
    {

        try{


            $validator = Validator::make($request->all(), [
                'lat' => 'required',
                'lon'  => 'required',
            ]);

            if ($validator->fails()){
                $response = "Invalid Parameters";
                return JSONResponse::response(400, $response);
            }

            $lat = $request->input('lat');
            $lon = $request->input('lon');
            $key = env('USER_KEY');
            $client = new Client();
            $res = $client->request('GET','https://developers.zomato.com/api/v2.1/geocode', [
                'headers' => [
                    'user-key' => $key,
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'lat' => $lat,
                    'lon' => $lon,
                ]
            ]);
            $body = $res->getBody();
            $body = json_decode($body);
            $message = $body->nearby_restaurants;
            $restaurants = [];
            $origins = $lat.','.$lon;
            $string='';
            foreach ($message as $rest) {
                $res = new stdClass();
                $res->id = $rest->restaurant->id;
                $res->name = $rest->restaurant->name;
                $res->location = $rest->restaurant->location;
                $res->cuisines = $rest->restaurant->cuisines;
                $res->rating= $rest->restaurant->user_rating;
                if($string==''){
                    $string=$res->location->latitude.','.$res->location->longitude;
                }
                else{
                    $string=$string.'|'.$res->location->latitude.','.$res->location->longitude;
                }
                //$res->rating = $rest->restaurant->aggregate->rating;
                array_push($restaurants,$res);
            }
            $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins='.$origins.'&destinations='.$string.'&key='.env('DIST_KEY');
            $res = $client->request('GET',$url);
            $body = $res->getBody();
            $body = json_decode($body)->rows[0]->elements;
            $distmatrix = [];
            foreach ($body as $res) {
                $travel = new stdClass();
                $travel->dist = $res->distance->text;
                $travel->duration = $res->duration->text;
                array_push($distmatrix,$travel);
            }
            for($i=0;$i<sizeof($restaurants);$i++){
                $restaurants[$i]->travel = $distmatrix[$i];
            }
            $status_code = 200;
            return JSONResponse::response($status_code, $restaurants);
        }
        catch (Exception $e){
            Log::error($e->getMessage());
            return JSONResponse::response(500,$e->getMessage());
        }
    }

    public function senti(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'res_id' => 'required',
            'dist'  => 'required',
            'dur' => 'required',
        ]);

        if ($validator->fails()){
            $response = "Invalid Parameters";
            return JSONResponse::response(400, $response);
        }

        $res_id   = $request->input('res_id');
        $dist     = $request->input('dist');
        $dur      = $request->input('dur');

        try{
            $key = env('USER_KEY');



            $client = new Client();
            $res = $client->request('GET','https://developers.zomato.com/api/v2.1/restaurant', [
                'headers' => [
                    'user-key' => $key,
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'res_id' => $res_id,
                ]
            ]);


            $body = $res->getBody();
            $curr_res = json_decode($body);
            $name = $curr_res->name;
            $address = $curr_res->location->address;
            $cuisines = $curr_res->cuisines;
            $cost_per_person = ($curr_res->average_cost_for_two)/2;


            $client = new Client();
            $res = $client->request('GET','https://developers.zomato.com/api/v2.1/reviews', [
                'headers' => [
                    'user-key' => $key,
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'res_id' => $res_id,
                    'start' => 0,
                    'count' => 100
                ]
            ]);
            $body = $res->getBody();
            $reviews = json_decode($body)->user_reviews;
            $string = '';
            foreach ($reviews as $review) {
                $string = $string.$review->review->review_text.PHP_EOL;
            }
            $url = "https://gateway.watsonplatform.net/natural-language-understanding/api/v1/analyze?version=2017-02-27&text=".$string."&features=sentiment,keywords,emotion";

            $client = new Client();
            $res = $client->request('GET',$url,['auth' => [env('username'), env('password')]]);
            $body = $res->getBody();
            $body = json_decode($body);
            $keywords = [];
            $keywords_json = $body->keywords;
            for($i=0;$i<10;$i++){
                array_push($keywords, $keywords_json[$i]->text);
            }
            $overall_score = ($body->sentiment->document->score+1)*50;
            $emotion = $body->emotion->document->emotion;
            $status_code = 200;
            $message = new stdClass();
            $message->name = $name;
            $message->address = $address;
            $message->duration = $dur;
            $message->distance = $dist;
            $message->cost = $cost_per_person;
            $message->score = $overall_score;
            $message->keywords = $keywords;
            $message->cuisines = $cuisines;
            $message->emotion = $emotion;
            return JSONResponse::response($status_code, $message);
        }
        catch (Exception $e){
            Log::error($e->getMessage());
            return JSONResponse::response(500);
        }
    }

}
