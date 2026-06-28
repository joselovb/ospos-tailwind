<?php
/**
 * @var array $suppliers
 * @var array $allow_alt_description_choices
 * @var array $serialization_choices
 * @var string $controller_name
 * @var array $config
 */
?>

<div id="required_fields_message" class="ui-help-text mb-3 italic"><?= lang('Items.edit_fields_you_want_to_update') ?></div>
<ul id="error_message_box" class="error_message_box ui-alert-danger mb-3 block list-none empty:hidden"></ul>

<?= form_open('items/bulkUpdate/', ['id' => 'item_form', 'class' => 'form-horizontal']) ?>
    <fieldset id="bulk_item_basic_info" class="space-y-4">

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.name'), 'name', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div>
                <?= form_input([
                    'name'  => 'name',
                    'id'    => 'name',
                    'class' => 'ui-input'
                ]) ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.category'), 'category', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41 11 4H4v7l9.59 9.59a2 2 0 0 0 2.82 0l4.18-4.18a2 2 0 0 0 0-2.82z"/><circle cx="7.5" cy="7.5" r="0.5" fill="currentColor"/></svg>
                </span>
                <?= form_input([
                    'name'  => 'category',
                    'id'    => 'category',
                    'class' => 'ui-input pr-10'
                ]) ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.supplier'), 'supplier', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="relative">
                <?= form_dropdown('supplier_id', $suppliers, '', ['class' => 'ui-select']) ?>
                <span class="ui-select-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </span>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.cost_price'), 'cost_price', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="relative max-w-50">
                <?php if (!is_right_side_currency_symbol()): ?>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm font-semibold text-text-muted"><?= esc($config['currency_symbol']) ?></span>
                <?php endif; ?>
                <?= form_input([
                    'name'  => 'cost_price',
                    'id'    => 'cost_price',
                    'class' => 'ui-input' . (!is_right_side_currency_symbol() ? ' pl-8' : ' pr-8')
                ]) ?>
                <?php if (is_right_side_currency_symbol()): ?>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm font-semibold text-text-muted"><?= esc($config['currency_symbol']) ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.unit_price'), 'unit_price', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="relative max-w-50">
                <?php if (!is_right_side_currency_symbol()): ?>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm font-semibold text-text-muted"><?= esc($config['currency_symbol']) ?></span>
                <?php endif; ?>
                <?= form_input([
                    'name'  => 'unit_price',
                    'id'    => 'unit_price',
                    'class' => 'ui-input' . (!is_right_side_currency_symbol() ? ' pl-8' : ' pr-8')
                ]) ?>
                <?php if (is_right_side_currency_symbol()): ?>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm font-semibold text-text-muted"><?= esc($config['currency_symbol']) ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.tax_1'), 'tax_percent_1', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="flex flex-wrap gap-2">
                <?= form_input([
                    'name'  => 'tax_names[]',
                    'id'    => 'tax_name_1',
                    'class' => 'ui-input max-w-50',
                    'value' => $config['default_tax_1_name']
                ]) ?>
                <div class="relative max-w-30">
                    <?= form_input([
                        'name'  => 'tax_percents[]',
                        'id'    => 'tax_percent_name_1',
                        'class' => 'ui-input pr-8',
                        'value' => to_tax_decimals($config['default_tax_1_rate'])
                    ]) ?>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm font-semibold text-text-muted">%</span>
                </div>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.tax_2'), 'tax_percent_2', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="flex flex-wrap gap-2">
                <?= form_input([
                    'name'  => 'tax_names[]',
                    'id'    => 'tax_name_2',
                    'class' => 'ui-input max-w-50',
                    'value' => $config['default_tax_2_name']
                ]) ?>
                <div class="relative max-w-30">
                    <?= form_input([
                        'name'  => 'tax_percents[]',
                        'id'    => 'tax_percent_name_2',
                        'class' => 'ui-input pr-8',
                        'value' => to_tax_decimals($config['default_tax_2_rate'])
                    ]) ?>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm font-semibold text-text-muted">%</span>
                </div>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.reorder_level'), 'reorder_level', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="max-w-40">
                <?= form_input([
                    'name'  => 'reorder_level',
                    'id'    => 'reorder_level',
                    'class' => 'ui-input'
                ]) ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.description'), 'description', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div>
                <?= form_textarea([
                    'name'  => 'description',
                    'id'    => 'description',
                    'class' => 'ui-input'
                ]) ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.allow_alt_description'), 'allow_alt_description', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="relative">
                <?= form_dropdown('allow_alt_description', $allow_alt_description_choices, '', ['class' => 'ui-select']) ?>
                <span class="ui-select-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </span>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Items.is_serialized'), 'is_serialized', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="relative">
                <?= form_dropdown('is_serialized', $serialization_choices, '', ['class' => 'ui-select']) ?>
                <span class="ui-select-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </span>
            </div>
        </div>

    </fieldset>
<?= form_close() ?>

<script type="text/javascript">
    // Validation and submit handling
    $(document).ready(function() {
        $('#category').autocomplete({
            source: "<?= 'items/suggestCategory' ?>",
            appendTo: '.modal-content',
            delay: 10
        });

        var confirm_message = false;
        $('#tax_percent_name_2, #tax_name_2').prop('disabled', true),
            $('#tax_percent_name_1, #tax_name_1').blur(function() {
                var disabled = !($('#tax_percent_name_1').val() + $('#tax_name_1').val());
                $('#tax_percent_name_2, #tax_name_2').prop('disabled', disabled);
                confirm_message = disabled ? '' : "<?= lang('Items.confirm_bulk_edit_wipe_taxes') ?>";
            });

        $('#item_form').validate($.extend({
            submitHandler: function(form) {
                if (!confirm_message || confirm(confirm_message)) {
                    $(form).ajaxSubmit({
                        beforeSubmit: function(arr, $form, options) {
                            arr.push({
                                name: 'item_ids',
                                value: table_support.selected_ids().join(":")
                            });
                        },
                        success: function(response) {
                            dialog_support.hide();
                            table_support.handle_submit("<?= esc($controller_name) ?>", response);
                        },
                        dataType: 'json'
                    });
                }
            },

            errorLabelContainer: '#error_message_box',

            rules: {
                unit_price: {
                    number: true
                },
                tax_percent: {
                    number: true
                },
                quantity: {
                    number: true
                },
                reorder_level: {
                    number: true
                }
            },

            messages: {
                unit_price: {
                    number: "<?= lang('Items.unit_price_number') ?>"
                },
                tax_percent: {
                    number: "<?= lang('Items.tax_percent_number') ?>"
                },
                quantity: {
                    number: "<?= lang('Items.quantity_number') ?>"
                },
                reorder_level: {
                    number: "<?= lang('Items.reorder_level_number') ?>"
                }
            }
        }, form_support.error));
    });
</script>
