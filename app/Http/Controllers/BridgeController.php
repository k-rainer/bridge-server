<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class BridgeController extends Controller
{
    
	function bridge(Request $request, $uri) {

        $uri = env('BACKENDHOST') . '/' . $uri;
        $method = $request->method();
        $params = ($method == 'POST') ? [ 'form_params' => $request->all() ] : [ 'query' => $request->all() ];
        $cacheKey = 'bridge:' . sha1($method . $uri . implode('', $request->all()));

        try {

            $backendResponseBody = null;
            if(cache()->exists($cacheKey)) {

                $backendResponseBody = cache()->get($cacheKey);

            }
            else {

                $backendResponse = guzzle()
                    ->request($method, $uri, $params);

                $backendResponseBody = $backendResponse->getBody();

                cache()->set($cacheKey, $backendResponseBody);

            }

            return response($backendResponseBody, 200);

        }
        catch(\Exception $ex) {

            throw $ex;

            return response('Exception', 500);

        } 
        catch(\GuzzleHttp\Exception\RequestException $ex) {

            return response('Request Exception', 500);

        }
        catch(\GuzzleHttp\Exception\ConnectException $ex) {

            return response('Connect Exception', 500);

        }

    }

}
