<?php
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $city = $_POST['search'];
    $weather = getWeather($city);
    $cityInfo = getCityInfo($city);
    $allInfo = new allCityInfo($weather->weather['0']->description, $weather->main->temp_min, $weather->main->temp_max, $weather->wind->speed, $cityInfo->country->name, $cityInfo->population, $cityInfo->elevation, $cityInfo->timezoneId);
    echo json_encode($allInfo);
}


class allCityInfo
{
    public $overcast;
    public $minTemp;
    public $maxTemp;
    public $windSpeed;
    public $country;
    public $population;
    public $elevation;
    public $timezone;

    public function __construct($overcast, $minTemp, $maxTemp, $windSpeed, $country, $population, $elevation, $timezone)
    {
        $this->overcast = $overcast;
        $this->minTemp = $minTemp;
        $this->maxTemp = $maxTemp;
        $this->windSpeed = $windSpeed;
        $this->country = $country;
        $this->population = $population;
        $this->elevation = $elevation;
        $this->timezone = $timezone;
    }
}


function getWeather($city)
{
    $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=738fa2cbba9ebdaa9a30a221b7377bdb&units=metric";
    $result = file_get_contents($url);
    $json_result = json_decode($result);
    return $json_result;
}

function getCityInfo($city)
{

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://spott.p.rapidapi.com/places?type=CITY&limit=10&skip=0&q=$city",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: spott.p.rapidapi.com",
            "x-rapidapi-key: f355805314msh00951f90f080db0p193c33jsnc61f21af39fd"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $cityInfo = json_decode($response);
        return $cityInfo[0];
    }
}
