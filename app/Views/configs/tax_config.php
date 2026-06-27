<?php
/**
 * @var array $tax_code_options
 * @var array $tax_category_options
 * @var array $tax_jurisdiction_options
 * @var string $controller_name
 * @var array $config
 */
?>

<?= form_open('config/saveTax/', ['id' => 'tax_config_form']) ?>

<div class="max-w-2xl space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="tax_id" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.tax_id') ?></label>
        <div class="w-40">
            <?= form_input(['name' => 'tax_id', 'id' => 'tax_id', 'class' => 'ui-input', 'value' => $config['tax_id']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.tax_included') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'tax_included', 'id' => 'tax_included', 'value' => 'tax_included', 'checked' => $config['tax_included'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="default_tax_1_rate" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.default_tax_rate_1') ?></label>
        <div class="flex items-center gap-2">
            <?= form_input(['name' => 'default_tax_1_name', 'id' => 'default_tax_1_name', 'class' => 'ui-input w-32', 'value' => $config['default_tax_1_name'] !== false ? $config['default_tax_1_name'] : lang('Items.sales_tax_1')]) ?>
            <?= form_input(['name' => 'default_tax_1_rate', 'id' => 'default_tax_1_rate', 'class' => 'ui-input w-20', 'value' => to_tax_decimals($config['default_tax_1_rate'])]) ?>
            <span class="text-sm text-text-muted">%</span>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="default_tax_2_rate" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.default_tax_rate_2') ?></label>
        <div class="flex items-center gap-2">
            <?= form_input(['name' => 'default_tax_2_name', 'id' => 'default_tax_2_name', 'class' => 'ui-input w-32', 'value' => $config['default_tax_2_name'] !== false ? $config['default_tax_2_name'] : lang('Items.sales_tax_2')]) ?>
            <?= form_input(['name' => 'default_tax_2_rate', 'id' => 'default_tax_2_rate', 'class' => 'ui-input w-20', 'value' => to_tax_decimals($config['default_tax_2_rate'])]) ?>
            <span class="text-sm text-text-muted">%</span>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.use_destination_based_tax') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'use_destination_based_tax', 'id' => 'use_destination_based_tax', 'value' => 'use_destination_based_tax', 'checked' => $config['use_destination_based_tax'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="default_tax_code" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.default_tax_code') ?></label>
        <div class="relative w-48">
            <?= form_dropdown('default_tax_code', $tax_code_options, $config['default_tax_code'], 'class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="default_tax_category" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.default_tax_category') ?></label>
        <div class="relative w-48">
            <?= form_dropdown('default_tax_category', $tax_category_options, $config['default_tax_category'], 'class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="default_tax_jurisdiction" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.default_tax_jurisdiction') ?></label>
        <div class="relative w-48">
            <?= form_dropdown('default_tax_jurisdiction', $tax_jurisdiction_options, $config['default_tax_jurisdiction'], 'class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_tax" id="submit_tax" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        var enable_disable_use_destination_based_tax = (function() {
            var use_destination_based_tax = $("#use_destination_based_tax").is(":checked");
            $("select[name='default_tax_code']").prop("disabled", !use_destination_based_tax);
            $("select[name='default_tax_category']").prop("disabled", !use_destination_based_tax);
            $("select[name='default_tax_jurisdiction']").prop("disabled", !use_destination_based_tax);
            $("input[name='tax_included']").prop("disabled", use_destination_based_tax);
            $("input[name='default_tax_1_rate']").prop("disabled", use_destination_based_tax);
            $("input[name='default_tax_1_name']").prop("disabled", use_destination_based_tax);
            $("input[name='default_tax_2_rate']").prop("disabled", use_destination_based_tax);
            $("input[name='default_tax_2_name']").prop("disabled", use_destination_based_tax);

            return arguments.callee;
        })();

        $("#use_destination_based_tax").change(enable_disable_use_destination_based_tax);

        $('#tax_config_form').validate($.extend(form_support.handler, {
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    beforeSerialize: function(arr, $form, options) {
                        return true;
                    },
                    success: function(response) {
                        $.notify({
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        });
                    },
                    dataType: 'json'
                });
            },

            rules: {
                default_tax_1_rate: {
                    remote: "<?= "$controller_name/checkNumeric" ?>"
                },
                default_tax2_rate: {
                    remote: "<?= "$controller_name/checkNumeric" ?>"
                },
            },

            messages: {
                default_tax_1_rate: {
                    number: "<?= lang('Config.default_tax_rate_number') ?>"
                },
            }
        }));
    });
</script>
