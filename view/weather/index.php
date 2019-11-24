<h1>Weather Prognoses</h1>

<h2>Manual</h2>
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
    <table class="table-ramverk">
        <tr>
            <th>Latitude / Longitude</th>
            <th>Date</th>
        </tr>
        <?php foreach ($chResponse as $value) : ?>
        <?php $date = date("Y/m/d", $value["daily"]["data"][0]["time"]) ?>
        <tr>
            <td><?= $value["latitude"] . " / " . $value["longitude"] ?></td>
            <td><?= $date ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
<?php endif; ?>    

<p>
    <a href="https://darksky.net/poweredby/">Powered by Dark Sky</a>
</p>