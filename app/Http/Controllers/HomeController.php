<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function displayContent(Request $request)
    {
        $namesArray = $this->getAllTem();

        // Check for an error message in the response
        $error = isset($namesArray['error']) ? $namesArray['error'] : null;

        return view('home', ['namesArray' => $namesArray, 'error' => $error]);
    }

    public function getAllTem()
    {
        $response = Http::get('https://temtem-api.mael.tech/api/temtems/names');

        if ($response->ok()) {
            $temtemNames = explode(',', $response->body());

            $temtemData = [];

            foreach ($temtemNames as $temtemName) {
                $temtemResponse = Http::get('https://temtem-api.mael.tech/api/temtems/', [
                    'names' => $temtemName,
                ]);

                if ($temtemResponse->ok()) {
                    $temtem = $temtemResponse->json()[0];

                    $temtemData[$temtem['name']] = [
                        'types' => $temtem['types'],
                        'portraitWikiUrl' => $temtem['portraitWikiUrl'],
                    ];
                } else {
                    $temtemData[$temtemName] = ['error' => 'Failed to fetch data for this Temtem'];
                }
            }

            return $temtemData;
        } else {
            return ['error' => 'Failed to fetch Temtem names from the API'];
        }
    }



}
