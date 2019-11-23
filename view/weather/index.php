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

<p>
    <?= is_null($isInputValid) ? null : ($isInputValid == false) ? "The format is wrong: " . $latLong : null ?>
</p>

<p>
    <a href="https://darksky.net/poweredby/">Powered by Dark Sky</a>
</p>