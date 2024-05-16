<?php
$apiKey = getenv('OPENWEATHERMAP_API_KEY');


$city = readline("Enter the city name: ");
$country = readline("Enter the country name: ");

$apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city . ',' . $country) . "&appid=$apiKey&units=metric";

$response = file_get_contents($apiUrl);
$directions = ['north', 'northeast', 'east', 'southeast', 'south', 'southwest', 'west', 'northwest'];

if ($response !== false) {

    $weatherData = json_decode($response);

    if (isset($weatherData->main->temp) && isset($weatherData->main->feels_like)
        && isset($weatherData->weather[0] ->description) && isset($weatherData->wind->speed) && isset($weatherData->wind->deg)) {
        $temperature = $weatherData->main->temp;
        $feelsLikeTemperature = $weatherData->main->feels_like;
        $windDirection = $weatherData->wind->deg;
        $degrees = ((round($windDirection * 8 / 360, 0) + 8) % 8);
        $windSpeed = $weatherData->wind->speed;
        $weatherDescription = $weatherData->weather[0]->description;

        echo "Current weather conditions in $city, $country are described as $weatherDescription.\n";
        echo "Temperature is: " . round($temperature, 1) . "°C, but it feels like " . round($feelsLikeTemperature, 1)."°C\n";
        echo "Wind is blowing from the " . $directions[$degrees] . " direction at " . round($windSpeed, 1) . " meter/s per second.\n";

    } else {
        echo "Weather data is incomplete or not available.";
    }
} else {
    echo "Failed to connect to OpenWeatherMap API.";
}