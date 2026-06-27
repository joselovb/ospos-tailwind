<?php
/**
 * @var array $invoice_type_options
 * @var array $line_sequence_options
 * @var array $config
 */
?>

<?= form_open('config/saveInvoice/', ['id' => 'invoice_config_form']) ?>

<ul id="invoice_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<div class="max-w-2xl space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.invoice_enable') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'invoice_enable', 'value' => 'invoice_enable', 'id' => 'invoice_enable', 'checked' => $config['invoice_enable'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="invoice_type" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.invoice_type') ?></label>
        <div class="relative w-48">
            <?= form_dropdown('invoice_type', $invoice_type_options, $config['invoice_type'], 'class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="recv_invoice_format" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.recv_invoice_format') ?></label>
        <div class="w-40">
            <?= form_input(['name' => 'recv_invoice_format', 'id' => 'recv_invoice_format', 'class' => 'ui-input', 'value' => $config['recv_invoice_format']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="invoice_default_comments" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.invoice_default_comments') ?></label>
        <div class="flex-1">
            <?= form_textarea(['name' => 'invoice_default_comments', 'id' => 'invoice_default_comments', 'class' => 'ui-input min-h-[60px] resize-y', 'value' => $config['invoice_default_comments']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="invoice_email_message" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.invoice_email_message') ?></label>
        <div class="flex-1">
            <?= form_textarea(['name' => 'invoice_email_message', 'id' => 'invoice_email_message', 'class' => 'ui-input min-h-[60px] resize-y', 'value' => $config['invoice_email_message']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="line_sequence" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.line_sequence') ?></label>
        <div class="relative w-48">
            <?= form_dropdown('line_sequence', $line_sequence_options, $config['line_sequence'], 'class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="sales_invoice_format" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.sales_invoice_format') ?></label>
        <div class="w-40">
            <?= form_input(['name' => 'sales_invoice_format', 'id' => 'sales_invoice_format', 'class' => 'ui-input', 'value' => $config['sales_invoice_format']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="last_used_invoice_number" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.last_used_invoice_number') ?></label>
        <div class="w-32">
            <?= form_input(['type' => 'number', 'name' => 'last_used_invoice_number', 'id' => 'last_used_invoice_number', 'class' => 'ui-input required', 'value' => $config['last_used_invoice_number']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="sales_quote_format" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.sales_quote_format') ?></label>
        <div class="w-40">
            <?= form_input(['name' => 'sales_quote_format', 'id' => 'sales_quote_format', 'class' => 'ui-input', 'value' => $config['sales_quote_format']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="last_used_quote_number" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.last_used_quote_number') ?></label>
        <div class="w-32">
            <?= form_input(['type' => 'number', 'name' => 'last_used_quote_number', 'id' => 'last_used_quote_number', 'class' => 'ui-input required', 'value' => $config['last_used_quote_number']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="quote_default_comments" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.quote_default_comments') ?></label>
        <div class="flex-1">
            <?= form_textarea(['name' => 'quote_default_comments', 'id' => 'quote_default_comments', 'class' => 'ui-input min-h-[60px] resize-y', 'value' => $config['quote_default_comments']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.work_order_enable') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'work_order_enable', 'value' => 'work_order_enable', 'id' => 'work_order_enable', 'checked' => $config['work_order_enable'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="work_order_format" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.work_order_format') ?></label>
        <div class="w-40">
            <?= form_input(['name' => 'work_order_format', 'id' => 'work_order_format', 'class' => 'ui-input', 'value' => $config['work_order_format']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="last_used_work_order_number" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.last_used_work_order_number') ?></label>
        <div class="w-32">
            <?= form_input(['type' => 'number', 'name' => 'last_used_work_order_number', 'id' => 'last_used_work_order_number', 'class' => 'ui-input required', 'value' => $config['last_used_work_order_number']]) ?>
        </div>
    </div>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_invoice" id="submit_invoice" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        var enable_disable_invoice_enable = (function() {
            var invoice_enabled = $("#invoice_enable").is(":checked");
            var work_order_enabled = $("#work_order_enable").is(":checked");
            $("#sales_invoice_format, #recv_invoice_format, #invoice_default_comments, #invoice_email_message, select[name='invoice_type'], #sales_quote_format, select[name='line_sequence'], #last_used_invoice_number, #last_used_quote_number, #quote_default_comments, #work_order_enable, #work_order_format, #last_used_work_order_number").prop("disabled", !invoice_enabled);
            if (invoice_enabled) {
                $("#work_order_format, #last_used_work_order_number").prop("disabled", !work_order_enabled);
            } else {
                $("#work_order_enable").attr('checked', false);
            }
            return arguments.callee;
        })();

        var enable_disable_work_order_enable = (function() {
            var work_order_enabled = $("#work_order_enable").is(":checked");
            var invoice_enabled = $("#invoice_enable").is(":checked");
            if (invoice_enabled) {
                $("#work_order_format, #last_used_work_order_number").prop("disabled", !work_order_enabled);
            }
            return arguments.callee;
        })();

        $("#invoice_enable").change(enable_disable_invoice_enable);
        $("#work_order_enable").change(enable_disable_work_order_enable);

        $("#invoice_config_form").validate($.extend(form_support.handler, {

            errorLabelContainer: "#invoice_error_message_box",

            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    beforeSerialize: function(arr, $form, options) {
                        $("#sales_invoice_format, #sales_quote_format, #recv_invoice_format, #invoice_default_comments, #invoice_email_message, #last_used_invoice_number, #last_used_quote_number, #quote_default_comments, #work_order_enable, #work_order_format, #last_used_work_order_number").prop("disabled", false);
                        return true;
                    },
                    success: function(response) {
                        $.notify({
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        })
                        enable_disable_invoice_enable();
                        enable_disable_work_order_enable();
                    },
                    dataType: 'json'
                });
            }
        }));
    });
</script>
