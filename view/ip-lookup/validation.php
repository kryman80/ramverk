<h2>Validation result</h2>

<?php if ($isIPValid): ?>
    <table>
        <tr>
            <th>Version of IP</th>
            <th></th>
        </tr>
    </table>
<?php else: ?>
    <p style="color: red;">IPv<?= $version ?>: <?= $ip ?> is invalid.</p>
<?php endif; ?>