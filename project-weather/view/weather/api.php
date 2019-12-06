<h1>Weather Prognoses Rest API</h1>

<h2>Manual</h2>
<p>
    The API will fetch a weather prognose of 30 days past. Every response will be in a JSON format.
</p>
<p>
    The input field accepts the name of the format of the response type separated by a white space followed by latitude and longitude coordinates respectively with a comma as a separator without any white space. The subtraction operator "-", is accepted as a negative value. The decimals after the dot sign ".", have no required limit. Mandatory format:
    <br />
    json 42.3601,-71.0589
</p>

<form>
    <input type="text" name="weather-api" placeholder="json latitude,longitude" />
    <input type="submit" value="Submit" />
</form>

<?php if ($invalidInput) : ?>
<p class="error-message">
    The format is wrong! <?= $input ?>
</p>
<?php endif; ?>

<p>
    <a href="https://darksky.net/poweredby/">Powered by Dark Sky</a>
</p>
