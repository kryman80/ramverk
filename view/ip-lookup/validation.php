<h2>Validation result</h2>
<?php if ($isIPValid): ?>
    <table class="table-ramverk">
        <tr>
            <th>IP</th>
            <th>Type</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>City</th>
            <th>Country</th>
        </tr>
        <?php if ($api) : ?>
            <tr>
                <td style="color: green;"><?= json_encode($ipstack->ip) ?></td>
                <td><?= json_encode($ipstack->type) ?></td>
                <td><?= json_encode($ipstack->latitude) ?></td>
                <td><?= json_encode($ipstack->longitude) ?></td>
                <td><?= json_encode($ipstack->city) ?></td>
                <td><?= json_encode($ipstack->country_name) ?></td>
            </tr>
        <?php else: ?>
        <tr>
            <td style="color: green;"><?= $ipstack->ip ?></td>
            <td><?= $ipstack->type ?></td>
            <td><?= $ipstack->latitude ?></td>
            <td><?= $ipstack->longitude ?></td>
            <td><?= $ipstack->city ?></td>
            <td><?= $ipstack->country_name ?></td>
        </tr>
        <?php endif; ?>
    </table>
<?php else: ?>
    <p style="color: red;">
        <?= $api ? '"IPv' . $version . '": ' . json_encode($ip)
        : "IPv" . $version . " " . $ip ?> is invalid.
    </p>
<?php endif; ?>