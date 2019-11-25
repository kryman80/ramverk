<h1>Weather Prognoses</h1>

<h2>Manual</h2>
<p>The API will fetch a weather prognose of 30 days past.</p>
<p>
    Enter in respective order latitude and longitude coordinates in the field with a comma as a separator without any white space. Minus sign (subtraction operator) is accepted as a negative value. The digits after the dot sign "." (decimals), have no required limit. Mandatory format:
    <br />
    42.3601 [latitude]
    <br />
    -71.0589 [longitude]
</p>

<form>
    <input type="text" name="weather" placeholder="latitude,longitude" />
    <input type="submit" value="Submit" />
</form>

<?php if ($isInputValid == false) : ?>
<p class="error-message">
    The format is wrong! <?= $latLong ?>
</p>
<?php endif; ?>

<?php if ($chResponse) : ?>
    <?php if (isset($chResponse[0]["code"]) == 400) : ?>
        <p class="error-message">The given location is invalid!</p>
    <?php else : ?>
    <ul class="weather-list">
        <li>Latitude / Longitude: <?= $chResponse[0]["latitude"] . " / " . $chResponse[0]["longitude"] ?></li>
        <li>Timezone: <?= $chResponse[0]["timezone"] ?></li>        
    </ul>

    <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=<?= $longitude - 0.01 ?>%2C<?= $latitude ?>%2C<?= $longitude + 0.01 ?>%2C<?= $latitude ?>&amp;layer=mapnik&amp;marker=<?= $latitude ?>%2C<?= $longitude ?>" style="border: 1px solid black"></iframe><br/><small><a href="https://www.openstreetmap.org/?mlat=<?= $latitude ?>&amp;mlon=<?= $longitude ?>#map=16/<?= $latitude ?>/<?= $longitude ?>">View Larger Map</a></small>
    
    <table class="table-weather">
        <tr>
            <th>Date</th>
            <th>Weather</th>
            <th>Apparent Temperature High / Low</th>
            <th>Apparent Temperature Max / Min</th>
            <th>Ozone</th>
            <th>Humidity</th>
            <th>Wind Speed</th>
            <th>Summary</th>
        </tr>
        <?php foreach ($chResponse as $value) : ?>        
        
        <?php
            // Variables.
            $daily = $value["daily"]["data"][0];
            $date = date("Y/m/d H:i", $daily["time"]);
            $appTempHigh = $daily["apparentTemperatureHigh"];
            $appTempLow = $daily["apparentTemperatureLow"];
            $appTempMax = $daily["apparentTemperatureMax"];
            $appTempMin = $daily["apparentTemperatureMin"];
            $icon = $daily["icon"] == "clear-day" ? "fas fa-sun" : (
                $daily["icon"] == "clear-night" ? "fas fa-star" : (
                    $daily["icon"] == "rain" ? "fas fa-cloud-rain" : (
                        $daily["icon"] == "snow" ? "fas fa-snowflake" : (
                            $daily["icon"] == "sleet" ? "fas fa-skating" : (
                                $daily["icon"] == "wind" ? "fas fa-wind" : (
                                    $daily["icon"] == "fog" ? "fas fa-smog" : (
                                        $daily["icon"] == "cloudy" ? "fas fa-cloud" : (
                                            $daily["icon"] == "partly-cloudy-day" ? "fas fa-cloud-sun" : (
                                                $daily["icon"] == "partly-cloudy-night" ? "fas fa-cloud-moon" : $daily["icon"]
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    )
                )
            );
            $ozone = $daily["ozone"];
            $humidity = $daily["humidity"];
            $windSpeed = $daily["windSpeed"];
            $summary = $daily["summary"];
        ?>
        
        <tr>
            <td><?= $date ?></td>
            <td><i class="<?= $icon ?>"></i></td>
            <td><?= $appTempHigh . " / " . $appTempLow ?></td>
            <td><?= $appTempMax . " / " . $appTempMin ?></td>
            <td><?= $ozone ?></td>
            <td><?= $humidity ?></td>
            <td><?= $windSpeed ?></td>
            <td><?= $summary ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
<?php endif; ?>    

<p>
    <a href="https://darksky.net/poweredby/">Powered by Dark Sky</a>
</p>