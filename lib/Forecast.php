<?php

namespace Forecast;

class Forecast
{
    const ROUND_FLOAT = 3;

    /**
     * Get weather by city.
     *
     * @param string $city
     * @param string $country
     *
     * @return mixed
     */
    public static function getWeatherByCity($city, $country = 'fr')
    {
        if ($_ENV["FORECAST_API_KEY"]) {
            $api_key = $_ENV['FORECAST_API_KEY'];
        } else {
            die("You must set API key");
        }

        $curl = curl_init();
        curl_setopt(
            $curl,
            CURLOPT_URL,
            "https://api.openweathermap.org/data/2.5/weather?q=${city},${country}&appid=".$api_key
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);

        return json_decode($response);
    }

    /**
     * Convert Degrees Kelvin to Degree Celsius.
     *
     * @param $temp
     *
     * @return string
     */
    public static function kelvinToCelsius($temp)
    {
        return round((float) $temp - 273.15, self::ROUND_FLOAT)." °C";
    }

    /**
     * Convert Degrees Celsius to Degree Kelvin
     *
     * @param $temp
     *
     * @return string
     */
    public static function celsiusToKelvin($temp)
    {
        return round((float) $temp + 273.15, self::ROUND_FLOAT)." K";
    }

    /**
     * Convert Degrees Kelvin to Degree Fahrenheit.
     *
     * @param $temp
     *
     * @return string
     */
    public static function kelvinToFahrenheit($temp)
    {
        return round((float) $temp * 9 / 5 - 459.67, self::ROUND_FLOAT)." °F";
    }

    /**
     * Convert Degree Fahrenheit to Degrees Kelvin.
     *
     * @param $temp
     *
     * @return string
     */
    public static function fahrenheitToKelvin($temp)
    {
        return round(((float) $temp + 459.67) * 5 / 9, self::ROUND_FLOAT)." K";
    }

    /**
     * Defini la couleur du badge en fonction de la température
     *
     * @param $temp
     *
     * @return string
     */
    public static function temperatureBadgeColor($temp) {
        if ((float) substr($temp, 0, -3) > 25.0) {
            $badgeColor = "red";
        } else if ((float) substr($temp, 0, -3) < 10.0) {
            $badgeColor = "blue";
        } else {
            $badgeColor = "green";
        }

        return $badgeColor;
    }
}
