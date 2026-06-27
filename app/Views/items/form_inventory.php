<?php
/**
 * @var object $item_info
 * @var array $stock_locations
 * @var array $item_quantities
 * @var string $controller_name
 */
?>

<div id="required_fields_message" class="ui-help-text mb-3 italic"><?= lang('Common.fields_required_message') ?></div>
<ul id="error_message_box" class="error_message_box ui-alert-danger mb-3 block list-none empty:hidden"></ul>

<?= form_open("items/saveInventory/$item_info->item_id", ['id' => 'item_form', 'class' => 'form-horizontal']) ?>
    <fieldset id="inv_item_basic_info" class="space-y-4">

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
                <?= form_dropdown('stock_location', $stock_locations, current($stock_locations), ['onchange' => 'fill_quantity(this.value)', 'class' => 'ui-select']) ?>
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

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.add_minus'), 'quantity', ['class' => 'required ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="max-w-40">
                <?= form_input([
                    'name'  => 'newquantity',
                    'id'    => 'newquantity',
                    'class' => 'ui-input'
                ]) ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.inventory_comments'), 'description', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div>
                <?= form_textarea([
                    'name'  => 'trans_comment',
                    'id'    => 'trans_comment',
                    'class' => 'ui-input'
                ]) ?>
            </div>
        </div>

    </fieldset>
<?= form_close() ?>

<script type="text/javascript">
    // Validation and submit handling
    $(document).ready(function() {
        $('#item_form').validate($.extend({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        dialog_support.hide();
                        table_support.handle_submit("<?= esc($controller_name) ?>", response);
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: '#error_message_box',

            rules: {
                newquantity: {
                    required: true,
                    number: true
                }
            },

            messages: {
                newquantity: {
                    required: "<?= lang('Items.quantity_required') ?>",
                    number: "<?= lang('Items.quantity_number') ?>"
                }
            }
        }, form_support.error));
    });

    function fill_quantity(val) {
        var item_quantities = <?= json_encode(esc($item_quantities, 'raw')) ?>;
        document.getElementById('quantity').value = parseFloat(item_quantities[val]).toFixed(<?= quantity_decimals() ?>);
    }
</script>
