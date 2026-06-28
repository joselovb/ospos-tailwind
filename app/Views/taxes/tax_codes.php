<?php
/**
 * @var array $tax_codes
 */
?>

<?= form_open('taxes/save_tax_codes/', ['id' => 'tax_codes_form']) ?>

<div id="config_wrapper">
    <fieldset id="config_info">

        <div class="mb-3 text-sm text-text-muted"><?= lang('Common.fields_required_message') ?></div>
        <ul id="tax_codes_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

        <div id="tax_codes" class="space-y-2 mb-4">
            <?= view('partial/tax_codes', ['tax_codes' => $tax_codes]) ?>
        </div>

        <div class="flex justify-end">
            <?= form_submit([
                'name'  => 'submit_tax_codes',
                'id'    => 'submit_tax_codes',
                'value' => lang('Common.submit'),
                'class' => 'ui-btn-primary'
            ]) ?>
        </div>

    </fieldset>
</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        var tax_code_count = <?= sizeof($tax_codes) ?>;
        if (tax_code_count == 0) {
            tax_code_count = 1;
        }

        var hide_show_remove_tax_code = function() {
            if ($("input[name*='tax_code']:enabled").length > 1) {
                $(".remove_tax_code").show();
            } else {
                $(".remove_tax_code").hide();
            }
        };

        var add_tax_code = function() {
            var id = $(this).parent().find("input[name='tax_code[]']").attr('id');
            id = id.replace(/.*?_(\d+)$/g, "$1");
            var block = $(this).parent().clone(true);
            var new_block = block.insertAfter($(this).parent());
            ++tax_code_count;
            var new_tax_code_id = 'tax_code_' + tax_code_count;

            $(new_block).find('label').html("<?= lang('Taxes.tax_code') ?> " + tax_code_count).attr('for', new_tax_code_id).attr('class', 'ui-label text-sm font-medium text-text-default shrink-0');
            $(new_block).find("input[name='tax_code[]']").attr('id', new_tax_code_id).removeAttr('disabled').attr('class', 'valid_chars text-uppercase ui-input !py-1.5 !text-sm w-20 required').val('');
            $(new_block).find("input[name='tax_code_name[]']").removeAttr('disabled').attr('class', 'valid_chars ui-input !py-1.5 !text-sm flex-1 min-w-[120px]').val('');
            $(new_block).find("input[name='city[]']").removeAttr('disabled').attr('class', 'valid_chars ui-input !py-1.5 !text-sm w-28').val('');
            $(new_block).find("input[name='state[]']").removeAttr('disabled').attr('class', 'valid_chars ui-input !py-1.5 !text-sm w-20').val('');
            $(new_block).find("input[name='tax_code_id[]']").val('-1');

            hide_show_remove_tax_code();
        };

        var remove_tax_code = function() {
            $(this).parent().remove();
            hide_show_remove_tax_code();
        };

        var init_add_remove_tax_codes = function() {
            $('.add_tax_code').click(add_tax_code);
            $('.remove_tax_code').click(remove_tax_code);
            hide_show_remove_tax_code();
        };
        init_add_remove_tax_codes();

        $.validator.addMethod('check4TaxCodeDups', function(value, element) {
            var value_count = 0;
            $("input[name='tax_code[]']").each(function() {
                value_count = $(this).val() == value ? value_count + 1 : value_count;
            });
            return value_count <= 1;
        }, "<?= lang('Taxes.tax_code_duplicate') ?>");

        $.validator.addMethod('validateTaxCodeCharacters', function(value, element) {
            return (value.indexOf('_') == -1);
        }, "<?= lang('Taxes.tax_code_invalid_chars') ?>");

        $.validator.addMethod('requireTaxCode', function(value, element) {
            return value.trim() != '';
        }, "<?= lang('Taxes.tax_code_required') ?>");

        $('#tax_codes_form').validate($.extend(form_support.handler, {
            submitHandler: function(form, event) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        $.notify({
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        });
                        $("#tax_codes").load('<?= "taxes/ajax_tax_codes" ?>', init_add_remove_tax_codes);
                    },
                    dataType: 'json'
                });
            },
            invalidHandler: function(event, validator) {
                $.notify("<?= lang('Common.correct_errors') ?>");
            },
            errorLabelContainer: "#tax_code_error_message_box"
        }));

        <?php
        $i = 0;
        foreach ($tax_codes as $tax_code => $tax_code_data) {
        ?>
            $('<?= '#tax_code_' . ++$i ?>').rules("add", {
                requireTaxCode: true,
                check4TaxCodeDups: true,
                validateTaxCodeCharacters: true
            });
        <?php } ?>

    });
</script>
