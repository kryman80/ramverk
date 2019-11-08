<h1>Validate an IP through REST API</h1>

<h2>How to use the API</h2>

<p>
    It is mandatory to specify the internet protocol with a whitespace before the address. Follow the formats below:
    <br />
    ip4 192.168.0.1
    <br />
    ip6 2001:0db8:85a3:0000:0000:8a2e:0370:7334
</p>

<form>
    <input type="text" name="api_ip-address" />
    <input type="submit" value="Submit" />
</form>

<h2>Testroutes</h2>

<p>
    <a href="api/json?ip4=192.168.0.1&ip6=2001:0db8:85a3:0000:0000:8a2e:0370:7334">IP 4 and 6</a href>
</p>