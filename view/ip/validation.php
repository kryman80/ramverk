<h2>Validation result</h2>

<p>
    <span style="color: <?= $result ? "green" : "red" ?>">Ip<?= $ip4 ? "4" : "6" ?>: <?= $ip; ?></span>
</p>
<p>
    Hostname -- Returns the host name on <span style="color: green">success</span>, the unmodified ip_address on failure, or <span style="color: red">FALSE</span> on malformed input.
    <br />
    <?= $hostname ?>
</p>