<h1>Weather Prognoses</h1>

<h2>Manual</h2>
<p>
    Enter in respective order latitude and longitude coordinates in the field with a comma as a separator without any white space. Minus sign (subtraction operator) is accepted as a negative value. If more digits after the dot sign "." is entered, the value will be cropped to a maximum of four decimals as is. Mandatory format:
    <br />
    42.3601 [latitude]
    <br />
    -71.0589 [longitude]
</p>

<form>
    <input type="text" name="weather" placeholder="latitude,longitude" />
    <input type="submit" name="submit-weather" value="Submit" />
</form>

<p>
    <a href="https://darksky.net/poweredby/">Powered by Dark Sky</a>
</p>