<?php
/**
 * @var array $config
 */
?>

<?= form_open('config/saveReceipt/', ['id' => 'receipt_config_form']) ?>

<ul id="receipt_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<div class="max-w-2xl space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="receipt_template" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.receipt_template') ?></label>
        <div class="relative w-48">
            <?= form_dropdown('receipt_template', ['receipt_default' => lang('Config.receipt_default'), 'receipt_short' => lang('Config.receipt_short')], $config['receipt_template'], 'class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="receipt_font_size" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.receipt_font_size') ?> <span class="text-state-danger">*</span></label>
        <div class="flex items-center gap-2">
            <?= form_input(['type' => 'number', 'min' => '0', 'max' => '20', 'name' => 'receipt_font_size', 'id' => 'receipt_font_size', 'class' => 'ui-input w-20 required', 'value' => $config['receipt_font_size']]) ?>
            <span class="text-sm text-text-muted">px</span>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="print_delay_autoreturn" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.print_delay_autoreturn') ?> <span class="text-state-danger">*</span></label>
        <div class="flex items-center gap-2">
            <?= form_input(['type' => 'number', 'min' => '0', 'max' => '30', 'name' => 'print_delay_autoreturn', 'id' => 'print_delay_autoreturn', 'class' => 'ui-input w-20 required', 'value' => $config['print_delay_autoreturn']]) ?>
            <span class="text-sm text-text-muted">s</span>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.email_receipt_check_behaviour') ?></label>
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 pt-2">
            <label class="flex items-center gap-2 text-sm text-text-default">
                <?= form_radio(['name' => 'email_receipt_check_behaviour', 'value' => 'always', 'checked' => $config['email_receipt_check_behaviour'] == 'always']) ?>
                <?= lang('Config.email_receipt_check_behaviour_always') ?>
            </label>
            <label class="flex items-center gap-2 text-sm text-text-default">
                <?= form_radio(['name' => 'email_receipt_check_behaviour', 'value' => 'never', 'checked' => $config['email_receipt_check_behaviour'] == 'never']) ?>
                <?= lang('Config.email_receipt_check_behaviour_never') ?>
            </label>
            <label class="flex items-center gap-2 text-sm text-text-default">
                <?= form_radio(['name' => 'email_receipt_check_behaviour', 'value' => 'last', 'checked' => $config['email_receipt_check_behaviour'] == 'last']) ?>
                <?= lang('Config.email_receipt_check_behaviour_last') ?>
            </label>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.print_receipt_check_behaviour') ?></label>
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 pt-2">
            <label class="flex items-center gap-2 text-sm text-text-default">
                <?= form_radio(['name' => 'print_receipt_check_behaviour', 'value' => 'always', 'checked' => $config['print_receipt_check_behaviour'] == 'always']) ?>
                <?= lang('Config.print_receipt_check_behaviour_always') ?>
            </label>
            <label class="flex items-center gap-2 text-sm text-text-default">
                <?= form_radio(['name' => 'print_receipt_check_behaviour', 'value' => 'never', 'checked' => $config['print_receipt_check_behaviour'] == 'never']) ?>
                <?= lang('Config.print_receipt_check_behaviour_never') ?>
            </label>
            <label class="flex items-center gap-2 text-sm text-text-default">
                <?= form_radio(['name' => 'print_receipt_check_behaviour', 'value' => 'last', 'checked' => $config['print_receipt_check_behaviour'] == 'last']) ?>
                <?= lang('Config.print_receipt_check_behaviour_last') ?>
            </label>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.receipt_show_company_name') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'receipt_show_company_name', 'value' => 'receipt_show_company_name', 'id' => 'receipt_show_company_name', 'checked' => $config['receipt_show_company_name'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.receipt_show_taxes') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'receipt_show_taxes', 'value' => 'receipt_show_taxes', 'id' => 'receipt_show_taxes', 'checked' => $config['receipt_show_taxes'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.receipt_show_tax_ind') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'receipt_show_tax_ind', 'value' => 'receipt_show_tax_ind', 'id' => 'receipt_show_tax_ind', 'checked' => $config['receipt_show_tax_ind'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.receipt_show_total_discount') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'receipt_show_total_discount', 'value' => 'receipt_show_total_discount', 'id' => 'receipt_show_total_discount', 'checked' => $config['receipt_show_total_discount'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.receipt_show_description') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'receipt_show_description', 'value' => 'receipt_show_description', 'id' => 'receipt_show_description', 'checked' => $config['receipt_show_description'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.receipt_show_serialnumber') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'receipt_show_serialnumber', 'value' => 'receipt_show_serialnumber', 'id' => 'receipt_show_serialnumber', 'checked' => $config['receipt_show_serialnumber'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.print_silently') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'print_silently', 'id' => 'print_silently', 'value' => 'print_silently', 'checked' => $config['print_silently'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.print_header') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'print_header', 'id' => 'print_header', 'value' => 'print_header', 'checked' => $config['print_header'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.print_footer') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'print_footer', 'id' => 'print_footer', 'value' => 'print_footer', 'checked' => $config['print_footer'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.receipt_printer') ?></label>
        <div class="relative w-48">
            <?= form_dropdown('receipt_printer', [], ' ', 'id="receipt_printer" class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.invoice_printer') ?></label>
        <div class="relative w-48">
            <?= form_dropdown('invoice_printer', [], ' ', 'id="invoice_printer" class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.takings_printer') ?></label>
        <div class="relative w-48">
            <?= form_dropdown('takings_printer', [], ' ', 'id="takings_printer" class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="border-t border-brand-primary-border pt-4">
        <p class="mb-3 text-sm font-medium text-text-muted"><?= lang('Config.print_margins') ?? 'Print Margins' ?></p>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            <div>
                <label for="print_top_margin" class="mb-1 block text-xs text-text-muted"><?= lang('Config.print_top_margin') ?></label>
                <div class="flex items-center gap-1">
                    <?= form_input(['type' => 'number', 'min' => '0', 'max' => '20', 'name' => 'print_top_margin', 'id' => 'print_top_margin', 'class' => 'ui-input required', 'value' => $config['print_top_margin']]) ?>
                    <span class="shrink-0 text-xs text-text-muted">px</span>
                </div>
            </div>
            <div>
                <label for="print_left_margin" class="mb-1 block text-xs text-text-muted"><?= lang('Config.print_left_margin') ?></label>
                <div class="flex items-center gap-1">
                    <?= form_input(['type' => 'number', 'min' => '0', 'max' => '20', 'name' => 'print_left_margin', 'id' => 'print_left_margin', 'class' => 'ui-input required', 'value' => $config['print_left_margin']]) ?>
                    <span class="shrink-0 text-xs text-text-muted">px</span>
                </div>
            </div>
            <div>
                <label for="print_bottom_margin" class="mb-1 block text-xs text-text-muted"><?= lang('Config.print_bottom_margin') ?></label>
                <div class="flex items-center gap-1">
                    <?= form_input(['type' => 'number', 'min' => '0', 'max' => '20', 'name' => 'print_bottom_margin', 'id' => 'print_bottom_margin', 'class' => 'ui-input required', 'value' => $config['print_bottom_margin']]) ?>
                    <span class="shrink-0 text-xs text-text-muted">px</span>
                </div>
            </div>
            <div>
                <label for="print_right_margin" class="mb-1 block text-xs text-text-muted"><?= lang('Config.print_right_margin') ?></label>
                <div class="flex items-center gap-1">
                    <?= form_input(['type' => 'number', 'min' => '0', 'max' => '20', 'name' => 'print_right_margin', 'id' => 'print_right_margin', 'class' => 'ui-input required', 'value' => $config['print_right_margin']]) ?>
                    <span class="shrink-0 text-xs text-text-muted">px</span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_receipt" id="submit_receipt" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        if (window.localStorage && window.jsPrintSetup) {
            var printers = (jsPrintSetup.getPrintersList() && jsPrintSetup.getPrintersList().split(',')) || [];
            $('#receipt_printer, #invoice_printer, #takings_printer').each(function() {
                var $this = $(this)
                $(printers).each(function(key, value) {
                    $this.append($('<option>', {
                        value: value
                    }).text(value));
                });
                $("option[value='" + localStorage[$(this).attr('id')] + "']", this).prop('selected', true);
                $(this).change(function() {
                    localStorage[$(this).attr('id')] = $(this).val();
                });
            });
        } else {
            $("input[id*='margin'], #print_footer, #print_header, #receipt_printer, #invoice_printer, #takings_printer, #print_silently").prop('disabled', true);
            $("#receipt_printer, #invoice_printer, #takings_printer").each(function() {
                $(this).append($('<option>', {
                    value: 'na'
                }).text('N/A'));
            });
        }

        var dialog_confirmed = window.jsPrintSetup;

        $('#receipt_config_form').validate($.extend(form_support.handler, {
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    beforeSerialize: function(arr, $form, options) {
                        return (dialog_confirmed || confirm('<?= lang('Config.jsprintsetup_required') ?>'));
                    },
                    success: function(response) {
                        $.notify({
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        })
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: "#receipt_error_message_box",

            rules: {
                print_top_margin: { required: true, number: true },
                print_left_margin: { required: true, number: true },
                print_bottom_margin: { required: true, number: true },
                print_right_margin: { required: true, number: true },
                receipt_font_size: { required: true, number: true },
                print_delay_autoreturn: { required: true, number: true }
            },

            messages: {
                print_top_margin: { required: "<?= lang('Config.print_top_margin_required') ?>", number: "<?= lang('Config.print_top_margin_number') ?>" },
                print_left_margin: { required: "<?= lang('Config.print_left_margin_required') ?>", number: "<?= lang('Config.print_left_margin_number') ?>" },
                print_bottom_margin: { required: "<?= lang('Config.print_bottom_margin_required') ?>", number: "<?= lang('Config.print_bottom_margin_number') ?>" },
                print_right_margin: { required: "<?= lang('Config.print_right_margin_required') ?>", number: "<?= lang('Config.print_right_margin_number') ?>" },
                receipt_font_size: { required: "<?= lang('Config.receipt_font_size_required') ?>", number: "<?= lang('Config.receipt_font_size_number') ?>" },
                print_delay_autoreturn: { required: "<?= lang('Config.print_delay_autoreturn_required') ?>", number: "<?= lang('Config.print_delay_autoreturn_number') ?>" }
            }
        }));
    });
</script>
