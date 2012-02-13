<div class="tab-content global-tab" tab_content_id="machines">
<?php
    foreach($machines as $machine)
    {
?>
    <div class="machine">
        <h2><?=$machine['display_name']?></h2>
        <table class="machine-table" id="<?=$machine['machine_id']?>">
            <tr>
                <th>Slot</th>
                <th>Name</th>
                <th>Price</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
            <?php
                foreach($machine['slots'] as $slot)
                {
            ?>
            <tr slot_id="<?=$slot['slot_num']?>">
                <td><div class="slot" field_name="slot_num" slot_id="<?=$slot['slot_num']?>" machine_id="<?=$machine['machine_id']?>" contenteditable="false"><?=$slot['slot_num']?></div></td>
                <td><div class="slot" field_name="item_id" slot_id="<?=$slot['slot_num']?>" machine_id="<?=$machine['machine_id']?>" item_id="<?=$slot['item_id']?>" contenteditable="false"><?=$slot['item_name']?></div></td>
                <td><div class="item" field_name="price" slot_id="<?=$slot['slot_num']?>" machine_id="<?=$machine['machine_id']?>" contenteditable="false"><?=$slot['item_price']?></div></td>
                <td><div class="slot" field_name="available" slot_id="<?=$slot['slot_num']?>" machine_id="<?=$machine['machine_id']?>" contenteditable="false"><?=$slot['available']?></div></td>
                <td>
                <?php
                if($slot['available'] > 0 && $slot['status'] == 'enabled' && $_SESSION['loggedIn']['drink_credits'] >= $slot['item_price'])
                {
                ?>
                    <input type="button" class="action-button green" action="drop" machine_alias="<?=$machine['alias']?>" machine_id="<?=$machine['machine_id']?>" slot_id="<?=$slot['slot_num']?>" value="Drop">
                <?php
                }
                else
                {
                ?>
                    <input type="button" disabled="true" class="action-button disabled" action="drop" machine_alias="<?=$machine['alias']?>" machine_id="<?=$machine['machine_id']?>" slot_id="<?=$slot['slot_num']?>" value="Drop">

                <?php
                }

                if($_SESSION['loggedIn']['drink_admin'])
                {
                ?>
                    <input type="button" class="action-button orange" action="edit" machine_id="<?=$machine['machine_id']?>" slot_id="<?=$slot['slot_num']?>" value="Edit">
                    <input type="button" class="action-button red" action="delete" machine_id="<?=$machine['machine_id']?>" slot_id="<?=$slot['slot_num']?>" value="Delete">
                <?php
                    if($slot['status'] == 'disabled')
                    {
                        echo '<input type="button" class="action-button green" action="enable" machine_id="'.$machine['machine_id'].'" slot_id="'.$slot['slot_num'].'" value="Enable">';
                    }
                    else
                    {
                        echo '<input type="button" class="action-button orange" action="disable" machine_id="'.$machine['machine_id'].'" slot_id="'.$slot['slot_num'].'" value="Disable">';
                    }
                ?>

                <?php
                    }
                ?>
                </td>
            </tr>
            <?php
                }
            ?>
        </table>
        <?php
            if($_SESSION['loggedIn']['drink_admin'])
            {
        ?>
            <input type="button" class="action-button green" action="new_slot" machine_id="<?=$machine['machine_id']?>" value="+ New Slot">
        <?php
            }
        ?>
    </div>
<?php
    }
?>
</div>