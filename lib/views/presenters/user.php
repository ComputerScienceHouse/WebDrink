<div class="user-info">
    <?=$cn?>
</div>
<div class="edit-credits">
    <form id="edit_user" name="edit_user" uid="<?=$uid?>">
        <span id="curr_credits"><?=$credits?></span> <input type="text" name="credits" id="credits">
        <select name="edit_type" id="edit_type">
            <option value="add">Add Credits</option>
            <option value="fixed">Fix Amount</option>
        </select>
        <input type="submit" value="Submit">
    </form>
</div>