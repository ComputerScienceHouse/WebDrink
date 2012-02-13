<div class="tab-content global-tab" tab_content_id="user_drops">
    <h2>Your Drop History</h2>
    <table class="machine-table">
        <tr>
            <th>Time</th>
            <th>Slot</th>
            <th>Machine</th>
            <th>Item Name</th>
            <th>Item Price</th>
            <th>Status</th>
        </tr>
        <?php
            foreach($user_drops as $drop)
            {
        ?>
            <tr>
                <td><?=format_date_($drop['time'])?></td>
                <td><?=$drop['slot']?></td>
                <td><?=$drop['display_name']?></td>
                <td><?=$drop['item_name']?></td>
                <td><?=$drop['current_item_price']?></td>
                <td><?=$drop['status']?></td>
            </tr>

        <?php
            }
        ?>
    </table>
</div>