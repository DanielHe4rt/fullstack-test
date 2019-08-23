<?php
/**
 * Created by PhpStorm.
 * User: Daniel Reis
 * Date: 23-Aug-19
 * Time: 19:41
 */

namespace App\Services;


class ViacepService
{

    public $uri;

    public $reqType;

    public function __construct($reqType = "json")
    {
        $this->reqType = $reqType;
        $this->uri = env('VIACEP_BASE_URL');
    }

    public function getCepInformation(string $cep){
        $uri = $this->uri . "/{$cep}/" . $this->reqType;
        $data = json_decode(file_get_contents($uri),true);

        if(isset($data['erro'])){
            throw new \Exception('Cep não existe',404);
        }

        return $data;
    }
}
