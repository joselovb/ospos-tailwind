<?php
/**
 * @var object $item_info
 * @var array $stock_locations
 * @var array $item_quantities
 */

use App\Models\Employee;
use App\Models\Inventory;
?>

<?= form_open('items', ['id' => 'item_form', 'class' => 'form-horizontal']) ?>
    <fieldset id="count_item_basic_info" class="mb-6 space-y-4">

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.item_number'), 'name', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="5" x2="3" y2="19"/><line x1="7" y1="5" x2="7" y2="19"/><line x1="11" y1="5" x2="11" y2="19"/><line x1="16" y1="5" x2="16" y2="19"/><line x1="21" y1="5" x2="21" y2="19"/></svg>
                </span>
                <?= form_input([
                    'name'     => 'item_number',
                    'id'       => 'item_number',
                    'class'    => 'ui-input pl-10 opacity-60 cursor-not-allowed',
                    'disabled' => '',
                    'value'    => $item_info->item_number
                ]) ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.name'), 'name', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div>
                <?= form_input([
                    'name'     => 'name',
                    'id'       => 'name',
                    'class'    => 'ui-input opacity-60 cursor-not-allowed',
                    'disabled' => '',
                    'value'    => $item_info->name
                ]) ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.category'), 'category', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41 11 4H4v7l9.59 9.59a2 2 0 0 0 2.82 0l4.18-4.18a2 2 0 0 0 0-2.82z"/><circle cx="7.5" cy="7.5" r="0.5" fill="currentColor"/></svg>
                </span>
                <?= form_input([
                    'name'     => 'category',
                    'id'       => 'category',
                    'class'    => 'ui-input pl-10 opacity-60 cursor-not-allowed',
                    'disabled' => '',
                    'value'    => $item_info->category
                ]) ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.stock_location'), 'stock_location', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="relative">
                <?= form_dropdown('stock_location', $stock_locations, current($stock_locations), ['onchange' => 'display_stock(this.value);', 'class' => 'ui-select']) ?>
                <span class="ui-select-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </span>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.current_quantity'), 'quantity', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="max-w-40">
                <?= form_input([
                    'name'     => 'quantity',
                    'id'       => 'quantity',
                    'class'    => 'ui-input opacity-60 cursor-not-allowed',
                    'disabled' => '',
                    'value'    => to_quantity_decimals(current($item_quantities))
                ]) ?>
            </div>
        </div>

    </fieldset>
<?= form_close() ?>

<div class="overflow-x-auto rounded-xl border border-brand-primary-border">
    <table id="items_count_details" class="w-full text-sm">
        <thead>
            <tr class="bg-brand-primary-soft">
                <th colspan="4" class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wide text-brand-primary-active"><?= lang('Items.inventory_data_tracking') ?></th>
            </tr>
            <tr class="border-b border-brand-primary-border bg-surface">
                <th class="px-4 py-2 text-left text-xs font-semibold text-text-muted" style="width:30%"><?= lang('Items.inventory_date') ?></th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-text-muted" style="width:20%"><?= lang('Items.inventory_employee') ?></th>
                <th class="px-4 py-2 text-center text-xs font-semibold text-text-muted" style="width:20%"><?= lang('Items.inventory_in_out_quantity') ?></th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-text-muted" style="width:30%"><?= lang('Items.inventory_remarks') ?></th>
            </tr>
        </thead>
        <tbody id="inventory_result" class="divide-y divide-brand-primary-border">
            <?php
            $employee = model(Employee::class);
            $inventory = model(Inventory::class);

            $inventory_array = $inventory->get_inventory_data_for_item($item_info->item_id)->getResultArray();
            $employee_name = [];

            foreach ($inventory_array as $row) {
                $employee_data = $employee->get_info($row['trans_user']);
                $employee_name[] = $employee_data->first_name . ' ' . $employee_data->last_name;
            }
            ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        display_stock(<?= json_encode(key(esc($stock_locations, 'raw'))) ?>);
    });

    function display_stock(location_id) {
        var item_quantities = <?= json_encode(esc($item_quantities, 'raw')) ?>;
        document.getElementById("quantity").value = parseFloat(item_quantities[location_id]).toFixed(<?= quantity_decimals() ?>);

        var inventory_data = <?= json_encode(esc($inventory_array, 'raw')) ?>;
        var employee_data = <?= json_encode(esc($employee_name, 'raw')) ?>;

        var table = document.getElementById("inventory_result");

        var rowCount = table.rows.length;
        for (var index = rowCount; index > 0; index--) {
            table.deleteRow(index - 1);
        }

        for (var index = 0; index < inventory_data.length; index++) {
            var data = inventory_data[index];
            if (data['trans_location'] == location_id) {
                var tr = document.createElement('tr');
                tr.className = 'hover:bg-brand-primary-soft transition-colors';

                var td = document.createElement('td');
                td.className = 'px-4 py-2 text-text-default';
                td.appendChild(document.createTextNode(data['trans_date']));
                tr.appendChild(td);

                td = document.createElement('td');
                td.className = 'px-4 py-2 text-text-default';
                td.appendChild(document.createTextNode(employee_data[index]));
                tr.appendChild(td);

                td = document.createElement('td');
                td.className = 'px-4 py-2 text-center font-medium text-text-default';
                td.appendChild(document.createTextNode(parseFloat(data['trans_inventory']).toFixed(<?= quantity_decimals() ?>)));
                tr.appendChild(td);

                td = document.createElement('td');
                td.className = 'px-4 py-2 text-text-muted';
                td.appendChild(document.createTextNode(data['trans_comment']));
                tr.appendChild(td);

                table.appendChild(tr);
            }
        }
    }
</script>
