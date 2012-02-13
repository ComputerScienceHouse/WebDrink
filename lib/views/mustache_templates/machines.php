{{#each machine}}
<div class="row">
    <div class="span12">
        <h2>{{display_name}}</h2>

        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Slot</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{#each this.slots}}
                <tr>
                    <td>{{this.slot_num}}</td>
                    <td>{{this.item_name}}</td>
                    <td>{{this.item_price}}</td>
                    <td>{{this.available}}</td>
                    <td>
                        <input type="button" class="btn btn-primary" btn-action="drop" value="Drop">
                        <input type="button" class="btn btn-info" value="Edit">
                    </td>
                </tr>
                {{/each}}
            </tbody>
        </table>
    </div>
</div>
<hr>
{{/each}}