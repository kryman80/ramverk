<h1>Look up information about an IP via REST API</h1>

<div class="div-container">
    <h2>Manual</h2>
    <div class="div-left">        
        <p>
            Make sure to use the format as is written in the examples below.
            <br />
            ip4 255.255.255.255
            <br />
            ip6 2001:0db8:85a3:0000:0000:8a2e:0370:7334
        </p>
    </div>
    <div class="div-right">
        <h3>Test routes</h3>
        <p>
            Each route gets particular information about the IP.
        </p>
        <ul>
            <li><a href="api-json?ip=<?= $ip ?>&route=all">All information</a></li>
            <li><a href="api-json?ip=<?= $ip ?>&route=ip">IP address and type</a></li>
            <li><a href="api-json?ip=<?= $ip ?>&route=country">Country</a></li>
            <li><a href="api-json?ip=<?= $ip ?>&route=city">City</a></li>
            <li><a href="api-json?ip=<?= $ip ?>&route=latlong">Latitude and longitude</a></li>
        </ul>
    </div>

    <div class="div-form">
        <form method="index">
            <input type="text" name="ip" value="ip4 <?= $ip ?>" />
            <input type="submit" value="Submit IP" />
        </form>
    </div>
</div>