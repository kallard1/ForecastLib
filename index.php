<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Forecast</title>
</head>
<body>
<?php

include('lib/Forecast.php');

use Forecast\Forecast;

$city = "Lille";
$country = "fr";

if (isset($_POST['treatment'])) {
    $city = isset($_POST['city']) ? $_POST['city'] : "Lille";
    $country = isset($_POST['country']) ? $_POST['country'] : 'fr';
}

$forecast = Forecast::getWeatherByCity($city, $country);

?>

<div class="container">
    <div class="forecast-container">
        <?php if ($forecast->cod === "404"): ?>
            <div class="forecast-error">
                <h4><?= $forecast->message ?></h4>
            </div>
        <?php else: ?>
            <div class="forecast-icon">
                <div class="icon">
                    <img src="//openweathermap.org/img/wn/<?= $forecast->weather[0]->icon ?>.png"
                         alt="<?= $forecast->weather[0]->description ?>">
                </div>
                <div class="description"><?= $forecast->weather[0]->description ?></div>
            </div>
            <div class="forecast-data">
                <div class="forecast-city"><?= $forecast->name ?>, <?= $forecast->sys->country ?></div>
                <div class="forecast-values">
                    Temperature: <span class="temperature-badge <?= Forecast::temperatureBadgeColor(
                        Forecast::kelvinToCelsius($forecast->main->temp)
                    ) ?>"><?= Forecast::kelvinToCelsius($forecast->main->temp) ?></span> -
                    Pressure: <span class="pressure-badge gray"><?= $forecast->main->pressure ?> hPa</span> -
                    Humidity: <span class="humidity-badge blue"><?= $forecast->main->humidity ?>%</span>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <form method="POST">
        <label for="city">City</label>
        <input type="text" id="city" name="city" value="<?= $city; ?>"/>

        <label for="country">Country</label>
        <input type="text" id="country" name="country" maxlength="2" value="<?= $country; ?>"/>
        <button type="submit" name="treatment">Submit</button>
    </form>
</div>
</body>
</html>
