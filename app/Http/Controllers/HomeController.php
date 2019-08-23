<?php

namespace App\Http\Controllers;

use App\Services\ViacepService;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getCepInformation(Request $request)
    {
        $viaApi = new ViacepService();
        try {
            $weatherApi = new WeatherService();
            $address = $viaApi->getCepInformation($request->input('cep'));
            $weather = $weatherApi->getWeatherInformation($address['bairro'], $address['uf']);
            return response()->json(['address' => $address, 'weather' => $weather]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
