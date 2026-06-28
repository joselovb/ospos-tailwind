<?php
/**
 * @var int $tax_rate_id
 * @var array $tax_code_options
 * @var array $rate_tax_code_id
 * @var array $tax_category_options
 * @var array $rate_tax_category_id
 * @var array $tax_jurisdiction_options
 * @var array $rate_jurisdiction_id
 * @var float $tax_rate
 * @var array $rounding_options
 * @var array $tax_rounding_code
 */
?>

<ul id="error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<?= form_open("taxes/save/$tax_rate_id", ['id' => 'tax_code_form']) ?>

<fieldset id="tax_rate_info" class="space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="rate_tax_code_id" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Taxes.tax_code') ?></label>
        <div class="relative flex-1">
            <?= form_dropdown('rate_tax_code_id', $tax_code_options, $rate_tax_code_id, ['class' => 'ui-select', 'id' => 'rate_tax_code_id']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="rate_tax_category_id" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Taxes.tax_category') ?></label>
        <div class="relative flex-1">
            <?= form_dropdown('rate_tax_category_id', $tax_category_options, $rate_tax_category_id, ['class' => 'ui-select', 'id' => 'rate_tax_category_id']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="rate_jurisdiction_id" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Taxes.tax_jurisdiction') ?></label>
        <div class="relative flex-1">
            <?= form_dropdown('rate_jurisdiction_id', $tax_jurisdiction_options, $rate_jurisdiction_id, ['class' => 'ui-select', 'id' => 'rate_jurisdiction_id']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="tax_rate" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Taxes.tax_rate') ?></label>
        <div class="flex items-center gap-1">
            <div class="w-32">
                <?= form_input([
                    'name'  => 'tax_rate',
                    'id'    => 'tax_rate',
                    'class' => 'ui-input text-uppercase',
                    'value' => $tax_rate
                ]) ?>
            </div>
            <span class="font-semibold text-text-muted text-sm">%</span>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="tax_rounding_code" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Taxes.tax_rounding') ?></label>
        <div class="relative flex-1">
            <?= form_dropdown('tax_rounding_code', $rounding_options, $tax_rounding_code, ['class' => 'ui-select', 'id' => 'tax_rounding_code']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

</fieldset>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tax_code_form').validate($.extend({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        dialog_support.hide();
                        table_support.handle_submit('<?= 'taxes' ?>', response);
                    },
                    dataType: 'json'
                });
            },
            rules: {},
            messages: {}
        }, form_support.error));
    });

    function delete_tax_rate_row(link) {
        $(link).parent().parent().remove();
        return false;
    }
</script>
