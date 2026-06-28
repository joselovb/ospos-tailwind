<?php
/**
 * @var array $receiving_info
 * @var string $selected_supplier_name
 * @var int $selected_supplier_id
 * @var array $employees
 * @var string $controller_name
 * @var bool $can_assign_employee
 */
?>

<div id="required_fields_message" class="mb-3 text-sm text-text-muted"><?= lang('Common.fields_required_message') ?></div>
<ul id="error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<?= form_open("receivings/save/" . $receiving_info['receiving_id'], ['id' => 'receivings_edit_form']) ?>

<fieldset id="receiving_basic_info" class="space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Receivings.receipt_number') ?></label>
        <div class="flex-1 pt-2">
            <?= anchor('receivings/receipt/' . $receiving_info['receiving_id'], 'RECV ' . $receiving_info['receiving_id'], ['target' => '_blank', 'class' => 'text-brand-primary hover:underline font-medium text-sm']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="datetime" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Receivings.date') ?></label>
        <div class="relative flex-1">
            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </span>
            <?= form_input([
                'name'     => 'date',
                'value'    => to_datetime(strtotime($receiving_info['receiving_time'])),
                'id'       => 'datetime',
                'class'    => 'datetime ui-input pr-10',
                'readonly' => 'readonly'
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="supplier_name" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Receivings.supplier') ?></label>
        <div class="flex-1">
            <?= form_input(['name' => 'supplier_name', 'value' => $selected_supplier_name, 'id' => 'supplier_name', 'class' => 'ui-input']) ?>
            <?= form_hidden('supplier_id', $selected_supplier_id ?? '') ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="reference" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Receivings.reference') ?></label>
        <div class="flex-1">
            <?= form_input(['name' => 'reference', 'value' => $receiving_info['reference'], 'id' => 'reference', 'class' => 'ui-input']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="employee_id" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Receivings.employee') ?></label>
        <div class="relative flex-1">
            <?php if ($can_assign_employee): ?>
                <?= form_dropdown('employee_id', $employees, $receiving_info['employee_id'], 'id="employee_id" class="ui-select"') ?>
                <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
            <?php else: ?>
                <?= form_hidden('employee_id', $receiving_info['employee_id']) ?>
                <?= form_input(['name' => 'employee_name', 'value' => esc($employees[$receiving_info['employee_id']] ?? ''), 'class' => 'ui-input', 'readonly' => 'readonly']) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="comment" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Receivings.comments') ?></label>
        <div class="flex-1">
            <?= form_textarea(['name' => 'comment', 'value' => $receiving_info['comment'], 'id' => 'comment', 'class' => 'ui-input min-h-[80px] resize-y']) ?>
        </div>
    </div>

</fieldset>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        <?= view('partial/datepicker_locale') ?>

        $('#datetime').datetimepicker(pickerconfig);

        var fill_value = function(event, ui) {
            event.preventDefault();
            $("input[name='supplier_id']").val(ui.item.value);
            $("input[name='supplier_name']").val(ui.item.label);
        };

        $('#supplier_name').autocomplete({
            source: "<?= 'suppliers/suggest' ?>",
            minChars: 0,
            delay: 15,
            cacheLength: 1,
            appendTo: '.modal-content',
            select: fill_value,
            focus: fill_value
        });

        $('button#delete').click(function() {
            dialog_support.hide();
            table_support.do_delete("<?= esc($controller_name) ?>", <?= $receiving_info['receiving_id'] ?>);
        });

        $('#receivings_edit_form').validate($.extend({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        dialog_support.hide();
                        table_support.handle_submit("<?= esc($controller_name) ?>", response);
                    },
                    dataType: 'json'
                });
            }
        }, form_support.error));
    });
</script>
