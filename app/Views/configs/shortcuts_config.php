<?php
/**
 * @var array $config
 * @var array $keyboardShortcutOptions
 * @var array $keyboardShortcuts
 */

$keyboardShortcuts ??= [];
$keyboardShortcutOptions ??= [];
$config ??= [];

$shortcutLabels = [
    'cancel'    => lang('Sales.key_cancel'),
    'items'     => lang('Sales.key_item_search'),
    'customers' => lang('Sales.key_customer_search'),
    'suspend'   => lang('Sales.key_suspend'),
    'suspended' => lang('Sales.key_suspended'),
    'amount'    => lang('Sales.key_tendered'),
    'payment'   => lang('Sales.key_payment'),
    'complete'  => lang('Sales.key_finish_sale'),
    'finish'    => lang('Sales.key_finish_quote'),
    'help'      => lang('Sales.key_help_modal')
];
?>

<?= form_open('config/saveShortcuts', ['id' => 'shortcuts_config_form']) ?>

<ul id="shortcuts_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<div class="max-w-md space-y-4">

    <?php foreach ($shortcutLabels as $name => $label): ?>
        <?php $keyboardShortcutSelectedValue = $keyboardShortcuts[$name]['value'] ?? ''; ?>
        <div class="sm:flex sm:items-center sm:gap-4">
            <label for="key_<?= $name ?>" class="ui-label sm:w-44 sm:shrink-0"><?= $label ?></label>
            <div class="relative flex-1">
                <?= form_dropdown('key_' . $name, $keyboardShortcutOptions, $keyboardShortcutSelectedValue, 'class="ui-select" id="key_' . $name . '"') ?>
                <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_shortcuts" id="submit_shortcuts" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $('#shortcuts_config_form').validate($.extend(form_support.handler, {
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                success: function(response) {
                    $.notify({
                        message: response.message
                    }, {
                        type: response.success ? 'success' : 'danger'
                    });
                },
                error: function(xhr) {
                    const rawMessage = xhr.responseJSON?.message ?? xhr.responseText ?? <?= json_encode(lang('Config.shortcuts_save_error')) ?>;
                    $.notify({
                        message: DOMPurify.sanitize(rawMessage)
                    }, {
                        type: 'danger'
                    });
                },
                dataType: 'json'
            });
        },

        errorLabelContainer: '#shortcuts_error_message_box'
    }));
</script>
