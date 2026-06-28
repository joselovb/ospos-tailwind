<?php
/**
 * @var string $controller_name
 * @var object $person_info
 * @var array $packages
 * @var int $selected_package
 * @var bool $use_destination_based_tax
 * @var string $sales_tax_code_label
 * @var string $employee
 * @var array $config
 */

$has_stats = !empty($stats);
$has_mailchimp = !empty($mailchimp_info) && !empty($mailchimp_activity);
?>

<div id="required_fields_message" class="ui-help-text mb-3 italic"><?= lang('Common.fields_required_message') ?></div>
<ul id="error_message_box" class="error_message_box ui-alert-danger mb-3 block list-none empty:hidden"></ul>

<?= form_open("$controller_name/save/$person_info->person_id", ['id' => 'customer_form', 'class' => 'form-horizontal']) ?>

<div x-data="{ tab: 'basic' }">

    <?php if ($has_stats || $has_mailchimp): ?>
    <div class="mb-4 flex border-b border-brand-primary-border">
        <button type="button"
                @click="tab = 'basic'"
                :class="tab === 'basic' ? 'border-brand-primary text-brand-primary-active border-b-2 font-semibold' : 'text-text-muted hover:text-text-default'"
                class="px-4 py-2 text-sm transition-colors -mb-px">
            <?= lang('Customers.basic_information') ?>
        </button>
        <?php if ($has_stats): ?>
        <button type="button"
                @click="tab = 'stats'"
                :class="tab === 'stats' ? 'border-brand-primary text-brand-primary-active border-b-2 font-semibold' : 'text-text-muted hover:text-text-default'"
                class="px-4 py-2 text-sm transition-colors -mb-px">
            <?= lang('Customers.stats_info') ?>
        </button>
        <?php endif; ?>
        <?php if ($has_mailchimp): ?>
        <button type="button"
                @click="tab = 'mailchimp'"
                :class="tab === 'mailchimp' ? 'border-brand-primary text-brand-primary-active border-b-2 font-semibold' : 'text-text-muted hover:text-text-default'"
                class="px-4 py-2 text-sm transition-colors -mb-px">
            <?= lang('Customers.mailchimp_info') ?>
        </button>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Tab: Basic Info -->
    <div x-show="tab === 'basic'" class="space-y-4">
        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Customers.consent'), 'consent', ['class' => 'required ui-label sm:w-40 sm:shrink-0 sm:pt-0']) ?>
            <div class="flex items-center pt-0.5">
                <?= form_checkbox('consent', 1, $person_info->consent == '' ? !$config['enforce_privacy'] : (bool)$person_info->consent) ?>
            </div>
        </div>

        <?= view('people/form_basic_info') ?>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Customers.discount_type'), 'discount_type', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2']) ?>
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 pt-2">
                <label class="radio-inline flex items-center gap-2 text-sm text-text-default">
                    <?= form_radio([
                        'name'    => 'discount_type',
                        'type'    => 'radio',
                        'id'      => 'discount_type',
                        'value'   => 0,
                        'checked' => $person_info->discount_type == PERCENT
                    ]) ?> <?= lang('Customers.discount_percent') ?>
                </label>
                <label class="radio-inline flex items-center gap-2 text-sm text-text-default">
                    <?= form_radio([
                        'name'    => 'discount_type',
                        'type'    => 'radio',
                        'id'      => 'discount_type',
                        'value'   => 1,
                        'checked' => $person_info->discount_type == FIXED
                    ]) ?> <?= lang('Customers.discount_fixed') ?>
                </label>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Customers.discount'), 'discount', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="max-w-40">
                <?= form_input([
                    'name'    => 'discount',
                    'id'      => 'discount',
                    'class'   => 'ui-input',
                    'onClick' => 'this.select();',
                    'value'   => $person_info->discount_type === FIXED ? to_currency_no_money($person_info->discount) : to_decimals($person_info->discount)
                ]) ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Customers.company_name'), 'customer_company_name', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div>
                <?= form_input([
                    'name'  => 'company_name',
                    'id'    => 'customer_company_name',
                    'class' => 'ui-input',
                    'value' => $person_info->company_name
                ]) ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Customers.account_number'), 'account_number', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="max-w-50">
                <?= form_input([
                    'name'  => 'account_number',
                    'id'    => 'account_number',
                    'class' => 'ui-input',
                    'value' => $person_info->account_number
                ]) ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Customers.tax_id'), 'tax_id', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="max-w-50">
                <?= form_input([
                    'name'  => 'tax_id',
                    'id'    => 'tax_id',
                    'class' => 'ui-input',
                    'value' => $person_info->tax_id
                ]) ?>
            </div>
        </div>

        <?php if ($config['customer_reward_enable']): ?>
            <div class="form-group sm:flex sm:items-start sm:gap-4">
                <?= form_label(lang('Customers.rewards_package'), 'rewards', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
                <div class="relative">
                    <?= form_dropdown('package_id', $packages, $selected_package, ['class' => 'ui-select']) ?>
                    <span class="ui-select-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </span>
                </div>
            </div>

            <div class="form-group sm:flex sm:items-start sm:gap-4">
                <?= form_label(lang('Customers.available_points'), 'available_points', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
                <div class="max-w-40">
                    <?= form_input([
                        'name'     => 'available_points',
                        'id'       => 'available_points',
                        'class'    => 'ui-input opacity-60 cursor-not-allowed',
                        'value'    => $person_info->points,
                        'disabled' => ''
                    ]) ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Customers.taxable'), 'taxable', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-0']) ?>
            <div class="flex items-center pt-0.5">
                <?= form_checkbox('taxable', 1, $person_info->taxable == 1) ?>
            </div>
        </div>

        <?php if ($use_destination_based_tax) { ?>
            <div class="form-group sm:flex sm:items-start sm:gap-4">
                <?= form_label(lang('Customers.tax_code'), 'sales_tax_code_name', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
                <div>
                    <?= form_input([
                        'name'  => 'sales_tax_code_name',
                        'id'    => 'sales_tax_code_name',
                        'class' => 'ui-input',
                        'size'  => '50',
                        'value' => $sales_tax_code_label
                    ]) ?>
                    <?= form_hidden('sales_tax_code_id', $person_info->sales_tax_code_id) ?>
                </div>
            </div>
        <?php } ?>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Customers.date'), 'date', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="relative max-w-60">
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </span>
                <?= form_input([
                    'name'     => 'date',
                    'id'       => 'datetime',
                    'class'    => 'ui-input pr-10 opacity-60 cursor-not-allowed',
                    'value'    => to_datetime(strtotime($person_info->date)),
                    'readonly' => 'true'
                ]) ?>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Customers.employee'), 'employee', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div>
                <?= form_input([
                    'name'     => 'employee',
                    'id'       => 'employee',
                    'class'    => 'ui-input opacity-60 cursor-not-allowed',
                    'value'    => $employee,
                    'readonly' => 'true'
                ]) ?>
            </div>
        </div>

        <?= form_hidden('employee_id', $person_info->employee_id) ?>
    </div>

    <?php if ($has_stats): ?>
    <!-- Tab: Stats -->
    <div x-show="tab === 'stats'" class="space-y-4" style="display:none">
        <?php
        $stats_fields = [
            ['label' => lang('Customers.total'),        'id' => 'total',       'value' => to_currency_no_money($stats->total),           'symbol' => true],
            ['label' => lang('Customers.max'),          'id' => 'max',         'value' => to_currency_no_money($stats->max),             'symbol' => true],
            ['label' => lang('Customers.min'),          'id' => 'min',         'value' => to_currency_no_money($stats->min),             'symbol' => true],
            ['label' => lang('Customers.average'),      'id' => 'average',     'value' => to_currency_no_money($stats->average),         'symbol' => true],
            ['label' => lang('Customers.quantity'),     'id' => 'quantity',    'value' => to_quantity_decimals($stats->quantity),        'prefix' => '≥',  'symbol' => false],
            ['label' => lang('Customers.avg_discount'), 'id' => 'avg_discount','value' => to_decimals($stats->avg_discount),             'suffix' => '%',  'symbol' => false],
        ];
        foreach ($stats_fields as $field):
        ?>
        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label($field['label'], $field['id'], ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="relative max-w-50">
                <?php if (!empty($field['symbol']) && !is_right_side_currency_symbol()): ?>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm font-semibold text-text-muted"><?= esc($config['currency_symbol']) ?></span>
                <?php elseif (!empty($field['prefix'])): ?>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm font-semibold text-text-muted"><?= $field['prefix'] ?></span>
                <?php endif; ?>
                <?= form_input([
                    'name'     => $field['id'],
                    'id'       => $field['id'],
                    'class'    => 'ui-input opacity-60 cursor-not-allowed'
                        . ((!empty($field['symbol']) && !is_right_side_currency_symbol()) || !empty($field['prefix']) ? ' pl-8' : '')
                        . ((!empty($field['symbol']) && is_right_side_currency_symbol()) || !empty($field['suffix']) ? ' pr-8' : ''),
                    'value'    => $field['value'],
                    'disabled' => ''
                ]) ?>
                <?php if (!empty($field['symbol']) && is_right_side_currency_symbol()): ?>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm font-semibold text-text-muted"><?= esc($config['currency_symbol']) ?></span>
                <?php elseif (!empty($field['suffix'])): ?>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-sm font-semibold text-text-muted"><?= $field['suffix'] ?></span>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($has_mailchimp): ?>
    <!-- Tab: Mailchimp -->
    <div x-show="tab === 'mailchimp'" class="space-y-4" style="display:none">

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Customers.mailchimp_status'), 'mailchimp_status', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="relative">
                <?= form_dropdown('mailchimp_status', [
                    'subscribed'   => 'subscribed',
                    'unsubscribed' => 'unsubscribed',
                    'cleaned'      => 'cleaned',
                    'pending'      => 'pending'
                ], $mailchimp_info['status'], ['id' => 'mailchimp_status', 'class' => 'ui-select']) ?>
                <span class="ui-select-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </span>
            </div>
        </div>

        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label(lang('Customers.mailchimp_vip'), 'mailchimp_vip', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-0']) ?>
            <div class="flex items-center pt-0.5">
                <?= form_checkbox('mailchimp_vip', 1, $mailchimp_info['vip'] == 1) ?>
            </div>
        </div>

        <?php
        $mc_fields = [
            ['label' => lang('Customers.mailchimp_member_rating'),       'id' => '',                          'value' => $mailchimp_info['member_rating']],
            ['label' => lang('Customers.mailchimp_activity_total'),      'id' => 'mailchimp_activity_total',  'value' => $mailchimp_activity['total']],
            ['label' => lang('Customers.mailchimp_activity_lastopen'),   'id' => 'mailchimp_activity_lastopen','value' => $mailchimp_activity['lastopen']],
            ['label' => lang('Customers.mailchimp_activity_open'),       'id' => 'mailchimp_activity_open',   'value' => $mailchimp_activity['open']],
            ['label' => lang('Customers.mailchimp_activity_click'),      'id' => 'mailchimp_activity_click',  'value' => $mailchimp_activity['click']],
            ['label' => lang('Customers.mailchimp_activity_unopen'),     'id' => 'mailchimp_activity_unopen', 'value' => $mailchimp_activity['unopen']],
            ['label' => lang('Customers.mailchimp_email_client'),        'id' => 'mailchimp_email_client',    'value' => $mailchimp_info['email_client']],
        ];
        foreach ($mc_fields as $field):
        ?>
        <div class="form-group sm:flex sm:items-start sm:gap-4">
            <?= form_label($field['label'], $field['id'], ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
            <div class="max-w-50">
                <?= form_input([
                    'name'     => $field['id'],
                    'class'    => 'ui-input opacity-60 cursor-not-allowed',
                    'value'    => $field['value'],
                    'disabled' => ''
                ]) ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("input[name='sales_tax_code_name']").change(function() {
            if (!$("input[name='sales_tax_code_name']").val()) {
                $("input[name='sales_tax_code_id']").val('');
            }
        });

        var fill_value = function(event, ui) {
            event.preventDefault();
            $("input[name='sales_tax_code_id']").val(ui.item.value);
            $("input[name='sales_tax_code_name']").val(ui.item.label);
        };

        $('#sales_tax_code_name').autocomplete({
            source: "<?= esc('taxes/suggestTaxCodes') ?>",
            minChars: 0,
            delay: 15,
            cacheLength: 1,
            appendTo: '.modal-content',
            select: fill_value,
            focus: fill_value
        });

        $('#customer_form').validate($.extend({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        dialog_support.hide();
                        table_support.handle_submit("<?= $controller_name ?>", response);
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: '#error_message_box',

            rules: {
                first_name: 'required',
                last_name: 'required',
                consent: 'required',
                email: {
                    remote: {
                        url: "<?= "$controller_name/checkEmail" ?>",
                        type: 'POST',
                        data: {
                            'person_id': "<?= $person_info->person_id ?>"
                        }
                    }
                },
                account_number: {
                    remote: {
                        url: "<?= "$controller_name/checkAccountNumber" ?>",
                        type: 'POST',
                        data: {
                            'person_id': "<?= $person_info->person_id ?>"
                        }
                    }
                }
            },

            messages: {
                first_name: "<?= lang('Common.first_name_required') ?>",
                last_name: "<?= lang('Common.last_name_required') ?>",
                consent: "<?= lang('Customers.consent_required') ?>",
                email: "<?= lang('Customers.email_duplicate') ?>",
                account_number: "<?= lang('Customers.account_number_duplicate') ?>"
            }
        }, form_support.error));
    });
</script>
