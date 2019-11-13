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
        <tr>
            <td style="color: green;"><?= $ipstack->ip ?></td>
            <td><?= $ipstack->type ?></td>
            <td><?= $ipstack->latitude ?></td>
            <td><?= $ipstack->longitude ?></td>
            <td><?= $ipstack->city ?></td>
            <td><?= $ipstack->country_name ?></td>
        </tr>
    </table>
<?php else: ?>
    <p style="color: red;">IPv<?= $version ?>: <?= $ip ?> is invalid.</p>
<?php endif; ?>