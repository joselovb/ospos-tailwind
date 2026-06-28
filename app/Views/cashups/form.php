<?php
/**
 * @var object $cash_ups_info
 * @var array $employees
 * @var string $controller_name
 * @var array $config
 */

$currency_sym = esc($config['currency_symbol']);
$right_side   = is_right_side_currency_symbol();

function currency_field(string $name, string $id, string $value, string $sym, bool $right): string
{
    $input = form_input([
        'name'  => $name,
        'id'    => $id,
        'class' => 'ui-input',
        'value' => $value
    ]);
    $sym_span = '<span class="font-semibold text-sm text-text-muted">' . $sym . '</span>';
    return '<div class="flex items-center gap-1">'
        . ($right ? '' : $sym_span)
        . '<div class="w-36">' . $input . '</div>'
        . ($right ? $sym_span : '')
        . '</div>';
}
?>

<div id="required_fields_message" class="mb-3 text-sm text-text-muted"><?= lang('Common.fields_required_message') ?></div>
<ul id="error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<?= form_open('cashups/save/' . $cash_ups_info->cashup_id, ['id' => 'cashups_edit_form']) ?>

<fieldset id="item_basic_info" class="space-y-4">

    <?php if (!empty($cash_ups_info->cashup_id)) { ?>
        <div class="sm:flex sm:items-start sm:gap-4">
            <label class="ui-label sm:w-52 sm:shrink-0 sm:pt-2.5"><?= lang('Cashups.info') ?></label>
            <div class="flex-1 pt-2 text-sm text-text-muted"><?= lang('Cashups.id') . ' ' . $cash_ups_info->cashup_id ?></div>
        </div>
    <?php } ?>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="open_date" class="required ui-label sm:w-52 sm:shrink-0 sm:pt-2.5"><?= lang('Cashups.open_date') ?></label>
        <div class="relative flex-1">
            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </span>
            <?= form_input([
                'name'  => 'open_date',
                'id'    => 'open_date',
                'class' => 'ui-input pr-10 datepicker',
                'value' => to_datetime(strtotime($cash_ups_info->open_date))
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="open_employee_id" class="ui-label sm:w-52 sm:shrink-0 sm:pt-2.5"><?= lang('Cashups.open_employee') ?></label>
        <div class="relative flex-1">
            <?= form_dropdown('open_employee_id', $employees, $cash_ups_info->open_employee_id, 'id="open_employee_id" class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="open_amount_cash" class="ui-label sm:w-52 sm:shrink-0 sm:pt-2.5"><?= lang('Cashups.open_amount_cash') ?></label>
        <?= currency_field('open_amount_cash', 'open_amount_cash', to_currency_no_money($cash_ups_info->open_amount_cash), $currency_sym, $right_side) ?>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="transfer_amount_cash" class="ui-label sm:w-52 sm:shrink-0 sm:pt-2.5"><?= lang('Cashups.transfer_amount_cash') ?></label>
        <?= currency_field('transfer_amount_cash', 'transfer_amount_cash', to_currency_no_money($cash_ups_info->transfer_amount_cash), $currency_sym, $right_side) ?>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="close_date" class="required ui-label sm:w-52 sm:shrink-0 sm:pt-2.5"><?= lang('Cashups.close_date') ?></label>
        <div class="relative flex-1">
            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </span>
            <?= form_input([
                'name'  => 'close_date',
                'id'    => 'close_date',
                'class' => 'ui-input pr-10 datepicker',
                'value' => to_datetime(strtotime($cash_ups_info->close_date))
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="close_employee_id" class="ui-label sm:w-52 sm:shrink-0 sm:pt-2.5"><?= lang('Cashups.close_employee') ?></label>
        <div class="relative flex-1">
            <?= form_dropdown('close_employee_id', $employees, $cash_ups_info->close_employee_id, 'id="close_employee_id" class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="closed_amount_cash" class="ui-label sm:w-52 sm:shrink-0 sm:pt-2.5"><?= lang('Cashups.closed_amount_cash') ?></label>
        <?= currency_field('closed_amount_cash', 'closed_amount_cash', to_currency_no_money($cash_ups_info->closed_amount_cash), $currency_sym, $right_side) ?>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="note" class="ui-label sm:w-52 sm:shrink-0 sm:pt-2"><?= lang('Cashups.note') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox([
                'name'    => 'note',
                'id'      => 'note',
                'value'   => 0,
                'class'   => 'h-4 w-4 cursor-pointer rounded accent-brand-primary',
                'checked' => $cash_ups_info->note == 1
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="closed_amount_due" class="ui-label sm:w-52 sm:shrink-0 sm:pt-2.5"><?= lang('Cashups.closed_amount_due') ?></label>
        <?= currency_field('closed_amount_due', 'closed_amount_due', to_currency_no_money($cash_ups_info->closed_amount_due), $currency_sym, $right_side) ?>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="closed_amount_card" class="ui-label sm:w-52 sm:shrink-0 sm:pt-2.5"><?= lang('Cashups.closed_amount_card') ?></label>
        <?= currency_field('closed_amount_card', 'closed_amount_card', to_currency_no_money($cash_ups_info->closed_amount_card), $currency_sym, $right_side) ?>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="closed_amount_check" class="ui-label sm:w-52 sm:shrink-0 sm:pt-2.5"><?= lang('Cashups.closed_amount_check') ?></label>
        <?= currency_field('closed_amount_check', 'closed_amount_check', to_currency_no_money($cash_ups_info->closed_amount_check), $currency_sym, $right_side) ?>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="closed_amount_total" class="ui-label sm:w-52 sm:shrink-0 sm:pt-2.5 font-semibold"><?= lang('Cashups.closed_amount_total') ?></label>
        <?= currency_field('closed_amount_total', 'closed_amount_total', to_currency_no_money($cash_ups_info->closed_amount_total), $currency_sym, $right_side) ?>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="description" class="ui-label sm:w-52 sm:shrink-0 sm:pt-2.5"><?= lang('Cashups.description') ?></label>
        <div class="flex-1">
            <?= form_textarea([
                'name'  => 'description',
                'id'    => 'description',
                'class' => 'ui-input min-h-[80px] resize-y',
                'value' => $cash_ups_info->description
            ]) ?>
        </div>
    </div>

    <?php if (!empty($cash_ups_info->cashup_id)) { ?>
        <div class="sm:flex sm:items-start sm:gap-4">
            <label for="deleted" class="ui-label sm:w-52 sm:shrink-0 sm:pt-2"><?= lang('Cashups.is_deleted') ?></label>
            <div class="flex items-center pt-2">
                <?= form_checkbox([
                    'name'    => 'deleted',
                    'id'      => 'deleted',
                    'value'   => 1,
                    'class'   => 'h-4 w-4 cursor-pointer rounded accent-brand-primary',
                    'checked' => $cash_ups_info->deleted == 1
                ]) ?>
            </div>
        </div>
    <?php } ?>

</fieldset>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        <?= view('partial/datepicker_locale') ?>

        $('#open_date').datetimepicker({
            format: "<?= dateformat_bootstrap($config['dateformat']) . ' ' . dateformat_bootstrap($config['timeformat']) ?>",
            startDate: "<?= date($config['dateformat'] . ' ' . esc($config['timeformat'], 'js'), mktime(0, 0, 0, 1, 1, 2010)) ?>",
            <?php if (str_contains($config['timeformat'], 'a') || str_contains($config['timeformat'], 'A')) { ?>
                showMeridian: true,
            <?php } else { ?>
                showMeridian: false,
            <?php } ?>
            minuteStep: 1,
            autoclose: true,
            todayBtn: true,
            todayHighlight: true,
            bootcssVer: 3,
            language: '<?= current_language_code() ?>'
        });

        $('#close_date').datetimepicker({
            format: "<?= dateformat_bootstrap($config['dateformat']) . ' ' . dateformat_bootstrap($config['timeformat']) ?>",
            startDate: "<?= date($config['dateformat'] . ' ' . esc($config['timeformat'], 'js'), mktime(0, 0, 0, 1, 1, 2010)) ?>",
            <?php if (str_contains($config['timeformat'], 'a') || str_contains($config['timeformat'], 'A')) { ?>
                showMeridian: true,
            <?php } else { ?>
                showMeridian: false,
            <?php } ?>
            minuteStep: 1,
            autoclose: true,
            todayBtn: true,
            todayHighlight: true,
            bootcssVer: 3,
            language: '<?= current_language_code() ?>'
        });

        $('#open_amount_cash, #transfer_amount_cash, #closed_amount_cash, #closed_amount_due, #closed_amount_card, #closed_amount_check').keyup(function() {
            $.post("<?= esc("$controller_name/ajax_cashup_total") ?>", {
                    'open_amount_cash': $('#open_amount_cash').val(),
                    'transfer_amount_cash': $('#transfer_amount_cash').val(),
                    'closed_amount_due': $('#closed_amount_due').val(),
                    'closed_amount_cash': $('#closed_amount_cash').val(),
                    'closed_amount_card': $('#closed_amount_card').val(),
                    'closed_amount_check': $('#closed_amount_check').val()
                },
                function(response) {
                    $('#closed_amount_total').val(response.total);
                },
                'json'
            );
        });

        var submit_form = function() {
            $(this).ajaxSubmit({
                success: function(response) {
                    dialog_support.hide();
                    table_support.handle_submit('<?= esc('cashups') ?>', response);
                },
                dataType: 'json'
            });
        };

        $('#cashups_edit_form').validate($.extend({
            submitHandler: function(form) {
                submit_form.call(form);
            },
            rules: {},
            messages: {
                open_date: {
                    required: '<?= lang('Cashups.date_required') ?>'
                },
                close_date: {
                    required: '<?= lang('Cashups.date_required') ?>'
                },
                amount: {
                    required: '<?= lang('Cashups.amount_required') ?>',
                    number: '<?= lang('Cashups.amount_number') ?>'
                }
            }
        }, form_support.error));
    });
</script>
