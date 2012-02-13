<table class="machine-table">
    <tr>
        <th>Time</th>
        <th>User</th>
        <th>Admin</th>
        <th>Amount</th>
        <th>Direction</th>
        <th>Reason</th>
    </tr>
    <?php
        foreach($money as $mon)
        {
    ?>
        <tr>
            <td><?=format_date_($mon['time'])?></td>
            <td><?=$mon['username']?></td>
            <td><?=$mon['admin']?></td>
            <td><?=$mon['amount']?></td>
            <td><?=$mon['direction']?></td>
            <td><?=$mon['reason']?></td>
        </tr>

    <?php
        }
    ?>
</table>