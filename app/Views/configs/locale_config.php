<?php
/**
 * @var string $currency_code
 * @var array $rounding_options
 * @var string $controller_name
 * @var array $config
 */
?>

<?= form_open('config/saveLocale/', ['id' => 'locale_config_form']) ?>

<ul id="locale_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<div class="max-w-2xl space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="number_locale" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.number_locale') ?></label>
        <div class="flex items-center gap-3">
            <?= form_input(['name' => 'number_locale', 'id' => 'number_locale', 'class' => 'ui-input w-32', 'value' => $config['number_locale']]) ?>
            <?= form_hidden(['name' => 'save_number_locale', 'value' => $config['number_locale']]) ?>
            <a href="https://github.com/opensourcepos/opensourcepos/wiki/Localisation-support" target="_blank" class="inline-flex cursor-help text-text-muted hover:text-brand-primary">
                <span data-toggle="tooltip" data-placement="right" title="<?= lang('Config.number_locale_tooltip') ?>">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                </span>
            </a>
            <span id="number_locale_example" class="text-sm text-text-muted"><?= to_currency(1234567890.12300) ?></span>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.thousands_separator') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'thousands_separator', 'id' => 'thousands_separator', 'value' => 'thousands_separator', 'checked' => $config['thousands_separator'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="currency_symbol" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.currency_symbol') ?></label>
        <div class="w-24">
            <?= form_input(['name' => 'currency_symbol', 'id' => 'currency_symbol', 'class' => 'ui-input number_locale', 'value' => $config['currency_symbol']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="currency_code" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.currency_code') ?></label>
        <div class="w-24">
            <?= form_input(['name' => 'currency_code', 'id' => 'currency_code', 'class' => 'ui-input number_locale', 'value' => $currency_code]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="currency_decimals" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.currency_decimals') ?></label>
        <div class="relative w-24">
            <?= form_dropdown('currency_decimals', ['0' => '0', '1' => '1', '2' => '2'], $config['currency_decimals'], ['class' => 'ui-select']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="tax_decimals" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.tax_decimals') ?></label>
        <div class="relative w-24">
            <?= form_dropdown('tax_decimals', ['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4'], $config['tax_decimals'], ['class' => 'ui-select']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="quantity_decimals" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.quantity_decimals') ?></label>
        <div class="relative w-24">
            <?= form_dropdown('quantity_decimals', ['0' => '0', '1' => '1', '2' => '2', '3' => '3'], $config['quantity_decimals'], ['class' => 'ui-select']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="cash_decimals" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.cash_decimals') ?></label>
        <div class="flex items-center gap-2">
            <div class="relative w-24">
                <?= form_dropdown('cash_decimals', ['-1' => '-1', '0' => '0', '1' => '1', '2' => '2'], $config['cash_decimals'], ['class' => 'ui-select']) ?>
                <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
            </div>
            <span data-toggle="tooltip" data-placement="right" title="<?= lang('Config.cash_decimals_tooltip') ?>" class="inline-flex cursor-help text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </span>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="cash_rounding_code" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.cash_rounding') ?></label>
        <div class="relative w-48">
            <?= form_dropdown('cash_rounding_code', $rounding_options, $config['cash_rounding_code'], 'class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="payment_options_order" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.payment_options_order') ?></label>
        <div class="relative flex-1 max-w-xs">
            <?= form_dropdown('payment_options_order', [
                'cashdebitcredit' => lang('Sales.cash') . ' / ' . lang('Sales.debit') . ' / ' . lang('Sales.credit'),
                'debitcreditcash' => lang('Sales.debit') . ' / ' . lang('Sales.credit') . ' / ' . lang('Sales.cash'),
                'debitcashcredit' => lang('Sales.debit') . ' / ' . lang('Sales.cash') . ' / ' . lang('Sales.credit'),
                'creditdebitcash' => lang('Sales.credit') . ' / ' . lang('Sales.debit') . ' / ' . lang('Sales.cash'),
                'creditcashdebit' => lang('Sales.credit') . ' / ' . lang('Sales.cash') . ' / ' . lang('Sales.debit')
            ], $config['payment_options_order'], 'class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="country_codes" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.country_codes') ?></label>
        <div class="flex items-center gap-2">
            <div class="w-24">
                <?= form_input(['name' => 'country_codes', 'class' => 'ui-input', 'value' => $config['country_codes']]) ?>
            </div>
            <a href="https://wiki.openstreetmap.org/wiki/Nominatim/Country_Codes" target="_blank" class="inline-flex cursor-help text-text-muted hover:text-brand-primary">
                <span data-toggle="tooltip" data-placement="right" title="<?= lang('Config.country_codes_tooltip') ?>">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                </span>
            </a>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="language" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.language') ?></label>
        <div class="relative flex-1 max-w-xs">
            <?= form_dropdown('language', get_languages(), current_language_code(true) . ':' . current_language(true), ['class' => 'ui-select']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.timezone') ?></label>
        <div class="relative flex-1 max-w-xs">
            <?= form_dropdown('timezone', get_timezones(), $config['timezone'] ? $config['timezone'] : date_default_timezone_get(), ['class' => 'ui-select']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.datetimeformat') ?></label>
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative w-36">
                <?= form_dropdown('dateformat', get_dateformats(), $config['dateformat'], ['class' => 'ui-select']) ?>
                <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
            </div>
            <div class="relative w-36">
                <?= form_dropdown('timeformat', get_timeformats(), $config['timeformat'], ['class' => 'ui-select']) ?>
                <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
            </div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.date_or_time_format') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'date_or_time_format', 'id' => 'date_or_time_format', 'value' => 'date_or_time_format', 'checked' => $config['date_or_time_format'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="financial_year" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.financial_year') ?></label>
        <div class="relative w-40">
            <?= form_dropdown('financial_year', [
                '1'  => lang('Config.financial_year_jan'), '2' => lang('Config.financial_year_feb'),
                '3'  => lang('Config.financial_year_mar'), '4' => lang('Config.financial_year_apr'),
                '5'  => lang('Config.financial_year_may'), '6' => lang('Config.financial_year_jun'),
                '7'  => lang('Config.financial_year_jul'), '8' => lang('Config.financial_year_aug'),
                '9'  => lang('Config.financial_year_sep'), '10' => lang('Config.financial_year_oct'),
                '11' => lang('Config.financial_year_nov'), '12' => lang('Config.financial_year_dec')
            ], $config['financial_year'], ['class' => 'ui-select']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_locale" id="submit_locale" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        $('#currency_symbol, #thousands_separator, #currency_code').change(function() {
            var data = {
                number_locale: $('#number_locale').val()
            };
            data['save_number_locale'] = $("input[name='save_number_locale']").val();
            data['currency_symbol'] = $('#currency_symbol').val();
            data['currency_code'] = $('#currency_code').val();
            data['thousands_separator'] = $('#thousands_separator').is(":checked")
            $.post("<?= "$controller_name/checkNumberLocale" ?>",
                data,
                function(response) {
                    $("input[name='save_number_locale']").val(response.save_number_locale);
                    $('#number_locale_example').text(response.number_locale_example);
                    $('#currency_symbol').val(response.currency_symbol);
                    $('#currency_code').val(response.currency_code);
                },
                'json'
            );
        });

        $('#locale_config_form').validate($.extend(form_support.handler, {
            rules: {
                number_locale: {
                    required: true,
                    remote: {
                        url: "<?= "$controller_name/checkNumberLocale" ?>",
                        type: 'POST',
                        data: {
                            'number_locale': function() {
                                return $('#number_locale').val();
                            },
                            'save_number_locale': function() {
                                return $("input[name='save_number_locale']").val();
                            },
                            'currency_symbol': function() {
                                return $('#currency_symbol').val();
                            },
                            'thousands_separator': function() {
                                return $('#thousands_separator').is(':checked');
                            },
                            'currency_code': function() {
                                return $('#currency_code').val();
                            }
                        },
                        dataFilter: function(data) {
                            var response = JSON.parse(data);
                            $("input[name='save_number_locale']").val(response.save_number_locale);
                            $('#number_locale_example').text(response.number_locale_example);
                            $('#currency_symbol').val(response.currency_symbol);
                            $('#currency_code').val(response.currency_code);
                            return response.success;
                        }
                    }
                }
            },

            messages: {
                number_locale: {
                    required: "<?= lang('Config.number_locale_required') ?>",
                    number_locale: "<?= lang('Config.number_locale_invalid') ?>"
                }
            },

            errorLabelContainer: '#locale_error_message_box'
        }));
    });
</script>
