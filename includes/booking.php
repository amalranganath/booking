<?php

/**
 * Booking API class
 */
class Booking {

    const APIHOST = "booking-com.p.rapidapi.com";
    const APIKEY = "4c703f6d83msh0dabb6444ae3532p1307a6jsndc1f1b28ef0c";
    const LOCALE = "en-gb";

    private $base = "https://booking-com.p.rapidapi.com/v1";
    private $curl;

    public function __construct() {
        $this->curl = curl_init();
    }

    private function setOptions($url) {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: " . self::APIHOST,
                "X-RapidAPI-Key: " . self::APIKEY
            ],
        ]);
    }

    /**
     * Call API by given path and parameters
     * @param string $path
     * @param array $parameters
     * @return JSON
     */
    public function request($path, $parameters = []) {
        
        $params = array_merge(['locale' => self::LOCALE], $parameters);        
        $url = $this->base . $path . "?" . http_build_query($params);
        
        $this->setOptions($url);
        
        $response = curl_exec($this->curl);
        //var_dump($response);
        $err = curl_error($this->curl);
        curl_close($this->curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

}
