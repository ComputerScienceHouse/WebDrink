<select data-placeholder="Choose an item..." class="chzn-select" tabindex="2" style="width: 200px;" name="select_item" id="select_item">
    <option value=""></option>
<?php
    foreach($items as $item)
    {
        if($item_id != null && $item_id == $item['item_id'])
        {
?>
    <option value="<?=$item['item_id']?>" selected><?=$item['item_name']?></option>
<?php
        }
        else
        {
?>
     <option value="<?=$item['item_id']?>"><?=$item['item_name']?></option>
<?php
        }

    }
?>
</select>