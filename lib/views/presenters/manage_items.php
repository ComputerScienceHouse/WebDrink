<div class="tab-content global-tab" tab_content_id="manage_items">
    <h2>Manage Items</h2>
    <div class="machine">
        <h3>Add New Item</h3>
        <form name="new_item" id="new_item">
            <div class="div-row">
                <div class="field-name">
                    Item Name:
                </div>
                <div class=field-element">
                    <input type="text" name="item_name" id="item_name" required>
                </div>
            </div>
            <div class="div-row">
                <div class="field-name">
                    Item Price:
                </div>
                <div class="field-element">
                    <input type="text" name="item_price" id="item_price" required>
                </div>
            </div>
            <div class="div-row">
                <input type="submit" class="action-button green" value="Add">
            </div>
        </form>
    </div>
    <div class="machine">
        <h3>Current Items</h3>
        <table class="machine-table" id="current_items">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php
            foreach($items as $item)
            {
            ?>
            <tr item_id="<?=$item['item_id']?>">
                <td>
                    <div class="item" field_name="item_name" item_id="<?=$item['item_id']?>" contenteditable="false"><?=$item['item_name']?></div>
                </td>
                <td>
                    <div class="item" field_name="item_price" item_id="<?=$item['item_id']?>" contenteditable="false"><?=$item['item_price']?></div>
                </td>
                <td>
                    <input type="button" class="action-button orange" action="edit-item" item_id="<?=$item['item_id']?>" value="Edit">
                    <input type="button" class="action-button red" action="delete-item" item_id="<?=$item['item_id']?>" value="Delete">
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>
</div>