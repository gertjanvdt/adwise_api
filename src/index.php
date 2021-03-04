<?php
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $city = $_POST['search'];
    $weather = getWeather($city);
    $cityInfo = getCityInfo($city);
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
?>
<form method="POST">
    <input type="text" name="search" placeholder="<?php echo $city ?>">
    <input type="submit">
</form>


<div>
    <div>
        <h3>Weather info</h3>
        <h5>Overcast: <?php echo $weather->weather['0']->description ?></h5>
        <h5>Min temperature: <?php echo $weather->main->temp_min ?> °C</h5>
        <h5>Max temperature: <?php echo $weather->main->temp_max ?> °C</h5>
        <h5>Wind speed: <?php echo $weather->wind->speed ?> m/s</h5>
    </div>
    <div>
        <h3>City info</h3>
        <h5>Country: <?php echo $cityInfo->country->name ?></h5>
        <h5>Population: <?php echo $cityInfo->population ?></h5>
        <h5>Elevation: <?php echo $cityInfo->elevation ?> meters</h5>
        <h5>Timezone: <?php echo $cityInfo->timezoneId ?></h5>
    </div>
</div>