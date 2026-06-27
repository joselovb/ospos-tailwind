<?php
/**
 * @var array $config
 */
?>

<?= form_open('config/saveEmail/', ['id' => 'email_config_form', 'enctype' => 'multipart/form-data']) ?>

<ul id="email_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<div class="max-w-2xl space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="protocol" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.email_protocol') ?></label>
        <div class="relative w-40">
            <?= form_dropdown('protocol', ['mail' => 'Mail', 'sendmail' => 'Sendmail', 'smtp' => 'SMTP'], $config['protocol'], 'class="ui-select" id="protocol"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="mailpath" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.email_mailpath') ?></label>
        <div class="flex-1">
            <?= form_input(['name' => 'mailpath', 'id' => 'mailpath', 'class' => 'ui-input', 'value' => $config['mailpath']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="smtp_host" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.email_smtp_host') ?></label>
        <div class="flex-1">
            <?= form_input(['name' => 'smtp_host', 'id' => 'smtp_host', 'class' => 'ui-input', 'value' => $config['smtp_host']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="smtp_port" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.email_smtp_port') ?></label>
        <div class="w-24">
            <?= form_input(['type' => 'number', 'name' => 'smtp_port', 'id' => 'smtp_port', 'class' => 'ui-input', 'value' => $config['smtp_port']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="smtp_crypto" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.email_smtp_crypto') ?></label>
        <div class="relative w-32">
            <?= form_dropdown('smtp_crypto', ['' => 'None', 'tls' => 'TLS', 'ssl' => 'SSL'], $config['smtp_crypto'], 'class="ui-select" id="smtp_crypto"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="smtp_timeout" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.email_smtp_timeout') ?></label>
        <div class="w-24">
            <?= form_input(['type' => 'number', 'name' => 'smtp_timeout', 'id' => 'smtp_timeout', 'class' => 'ui-input', 'value' => $config['smtp_timeout']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="smtp_user" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.email_smtp_user') ?></label>
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <?= form_input(['name' => 'smtp_user', 'id' => 'smtp_user', 'class' => 'ui-input pl-10', 'value' => $config['smtp_user']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="smtp_pass" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.email_smtp_pass') ?></label>
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <?= form_password(['name' => 'smtp_pass', 'id' => 'smtp_pass', 'class' => 'ui-input pl-10', 'value' => $config['smtp_pass']]) ?>
        </div>
    </div>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_email" id="submit_email" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        var check_protocol = function() {
            if ($('#protocol').val() == 'sendmail') {
                $('#mailpath').prop('disabled', false);
                $('#smtp_host, #smtp_user, #smtp_pass, #smtp_port, #smtp_timeout, #smtp_crypto').prop('disabled', true);
            } else if ($('#protocol').val() == 'smtp') {
                $('#smtp_host, #smtp_user, #smtp_pass, #smtp_port, #smtp_timeout, #smtp_crypto').prop('disabled', false);
                $('#mailpath').prop('disabled', true);
            } else {
                $('#mailpath, #smtp_host, #smtp_user, #smtp_pass, #smtp_port, #smtp_timeout, #smtp_crypto').prop('disabled', true);
            }
        };

        $('#protocol').change(check_protocol).ready(check_protocol);

        $('#email_config_form').validate($.extend(form_support.handler, {
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    beforeSerialize: function(arr, $form, options) {
                        $('#mailpath, #smtp_host, #smtp_user, #smtp_pass, #smtp_port, #smtp_timeout, #smtp_crypto').prop('disabled', false);
                        return true;
                    },
                    success: function(response) {
                        $.notify({
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        })
                        check_protocol();
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: '#email_error_message_box'
        }));
    });
</script>
