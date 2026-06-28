<?php
/**
 * @var object $expenses_info
 * @var array $payment_options
 * @var array $expense_categories
 * @var array $employees
 * @var string $controller_name
 * @var array $config
 */
?>

<div id="required_fields_message" class="mb-3 text-sm text-text-muted"><?= lang('Common.fields_required_message') ?></div>
<ul id="error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<?= form_open("expenses/save/$expenses_info->expense_id", ['id' => 'expenses_edit_form']) ?>

<fieldset id="item_basic_info" class="space-y-4">

    <?php if (!empty($expenses_info->expense_id)) { ?>
        <div class="sm:flex sm:items-start sm:gap-4">
            <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Expenses.info') ?></label>
            <div class="flex-1 pt-2 text-sm text-text-muted"><?= lang('Expenses.expense_id') . " $expenses_info->expense_id" ?></div>
        </div>
    <?php } ?>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="required ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Expenses.date') ?></label>
        <div class="relative flex-1">
            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </span>
            <?= form_input([
                'name'     => 'date',
                'class'    => 'ui-input pr-10 datetime',
                'value'    => to_datetime(strtotime($expenses_info->date)),
                'readonly' => 'readonly'
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="supplier_name" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Expenses.supplier_name') ?></label>
        <div class="flex flex-1 items-center gap-2">
            <div class="flex-1">
                <?= form_input([
                    'name'  => 'supplier_name',
                    'id'    => 'supplier_name',
                    'class' => 'ui-input',
                    'value' => lang('Expenses.start_typing_supplier_name')
                ]) ?>
                <?= form_input([
                    'type' => 'hidden',
                    'name' => 'supplier_id',
                    'id'   => 'supplier_id'
                ]) ?>
            </div>
            <button type="button" id="remove_supplier_button" class="ui-btn-secondary !text-state-danger hover:!bg-state-danger-soft" title="Remove Supplier">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="supplier_tax_code" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Expenses.supplier_tax_code') ?></label>
        <div class="w-40">
            <?= form_input([
                'name'  => 'supplier_tax_code',
                'id'    => 'supplier_tax_code',
                'class' => 'ui-input',
                'value' => $expenses_info->supplier_tax_code
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="amount" class="required ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Expenses.amount') ?></label>
        <div class="flex items-center gap-1">
            <?php if (!is_right_side_currency_symbol()): ?>
                <span class="font-semibold text-text-muted text-sm"><?= esc($config['currency_symbol']) ?></span>
            <?php endif; ?>
            <div class="w-36">
                <?= form_input([
                    'name'  => 'amount',
                    'id'    => 'amount',
                    'class' => 'ui-input',
                    'value' => to_currency_no_money($expenses_info->amount)
                ]) ?>
            </div>
            <?php if (is_right_side_currency_symbol()): ?>
                <span class="font-semibold text-text-muted text-sm"><?= esc($config['currency_symbol']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="tax_amount" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Expenses.tax_amount') ?></label>
        <div class="flex items-center gap-1">
            <?php if (!is_right_side_currency_symbol()): ?>
                <span class="font-semibold text-text-muted text-sm"><?= esc($config['currency_symbol']) ?></span>
            <?php endif; ?>
            <div class="w-36">
                <?= form_input([
                    'name'  => 'tax_amount',
                    'id'    => 'tax_amount',
                    'class' => 'ui-input',
                    'value' => to_currency_no_money($expenses_info->tax_amount)
                ]) ?>
            </div>
            <?php if (is_right_side_currency_symbol()): ?>
                <span class="font-semibold text-text-muted text-sm"><?= esc($config['currency_symbol']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="payment_type" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Expenses.payment') ?></label>
        <div class="relative flex-1">
            <?= form_dropdown('payment_type', $payment_options, $expenses_info->payment_type, ['class' => 'ui-select', 'id' => 'payment_type']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="category" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Expenses_categories.name') ?></label>
        <div class="relative flex-1">
            <?= form_dropdown('expense_category_id', $expense_categories, $expenses_info->expense_category_id, ['class' => 'ui-select', 'id' => 'category']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="employee_id" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Expenses.employee') ?></label>
        <div class="relative flex-1">
            <?php if ($can_assign_employee): ?>
                <?= form_dropdown('employee_id', $employees, $expenses_info->employee_id, 'id="employee_id" class="ui-select"') ?>
                <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
            <?php else: ?>
                <?= form_hidden('employee_id', $expenses_info->employee_id) ?>
                <?= form_input(['name' => 'employee_name', 'value' => esc($employees[$expenses_info->employee_id] ?? ''), 'class' => 'ui-input', 'readonly' => 'readonly']) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="description" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Expenses.description') ?></label>
        <div class="flex-1">
            <?= form_textarea([
                'name'  => 'description',
                'id'    => 'description',
                'class' => 'ui-input min-h-[80px] resize-y',
                'value' => $expenses_info->description
            ]) ?>
        </div>
    </div>

    <?php if (!empty($expenses_info->expense_id)) { ?>
        <div class="sm:flex sm:items-start sm:gap-4">
            <label for="deleted" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2"><?= lang('Expenses.is_deleted') ?></label>
            <div class="flex items-center pt-2">
                <?= form_checkbox([
                    'name'    => 'deleted',
                    'id'      => 'deleted',
                    'value'   => 1,
                    'class'   => 'h-4 w-4 cursor-pointer rounded accent-brand-primary',
                    'checked' => $expenses_info->deleted == 1
                ]) ?>
            </div>
        </div>
    <?php } ?>

</fieldset>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        <?= view('partial/datepicker_locale') ?>

        $('#supplier_name').click(function() {
            $(this).attr('value', '');
        });

        $('#supplier_name').autocomplete({
            source: '<?= "suppliers/suggest" ?>',
            minChars: 0,
            delay: 10,
            select: function(event, ui) {
                $('#supplier_id').val(ui.item.value);
                $(this).val(ui.item.label);
                $(this).attr('readonly', 'readonly');
                $('#remove_supplier_button').css('display', 'inline-flex');
                return false;
            }
        });

        $('#supplier_name').blur(function() {
            $(this).attr('value', "<?= lang('Expenses.start_typing_supplier_name') ?>");
        });

        $('#remove_supplier_button').css('display', 'none');

        $('#remove_supplier_button').click(function() {
            $('#supplier_id').val('');
            $('#supplier_name').removeAttr('readonly');
            $('#supplier_name').val('');
            $(this).css('display', 'none');
        });

        <?php if ($expenses_info->expense_id != -1) { ?>
            $('#supplier_id').val('<?= $expenses_info->supplier_id ?>');
            $('#supplier_name').val('<?= esc($expenses_info->supplier_name, 'js') ?>').attr('readonly', 'readonly');
            $('#remove_supplier_button').css('display', 'inline-flex');
        <?php } ?>

        $('#expenses_edit_form').validate($.extend({
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

            ignore: '',

            rules: {
                supplier_name: 'required',
                category: 'required',
                expense_category_id: 'required',
                date: {
                    required: true
                },
                amount: {
                    required: true,
                    remote: "<?= "$controller_name/checkNumeric" ?>"
                },
                tax_amount: {
                    remote: "<?= "$controller_name/checkNumeric" ?>"
                }
            },

            messages: {
                category: "<?= lang('Expenses.category_required') ?>",
                expense_category_id: "<?= lang('Expenses_categories.category_name_required') ?>",
                date: {
                    required: "<?= lang('Expenses.date_required') ?>"
                },
                amount: {
                    required: "<?= lang('Expenses.amount_required') ?>",
                    remote: "<?= lang('Expenses.amount_number') ?>"
                },
                tax_amount: {
                    remote: "<?= lang('Expenses.tax_amount_number') ?>"
                }
            }
        }, form_support.error));
    });
</script>
