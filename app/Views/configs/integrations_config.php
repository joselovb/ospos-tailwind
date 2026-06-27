<?php
/**
 * @var array $mailchimp
 * @var string $controller_name
 */
?>

<?= form_open('config/saveMailchimp/', ['id' => 'mailchimp_config_form', 'enctype' => 'multipart/form-data']) ?>

<div class="mb-4 flex items-center gap-2">
    <svg class="h-5 w-5 text-brand-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>
    <h3 class="font-display font-semibold text-brand-primary-active"><?= lang('Config.mailchimp_configuration') ?></h3>
</div>

<ul id="mailchimp_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<div class="max-w-2xl space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="mailchimp_api_key" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.mailchimp_api_key') ?></label>
        <div class="flex flex-1 items-center gap-2">
            <div class="relative flex-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>
                </div>
                <?= form_input(['name' => 'mailchimp_api_key', 'id' => 'mailchimp_api_key', 'class' => 'ui-input pl-10', 'value' => $mailchimp['api_key']]) ?>
            </div>
            <a href="https://eepurl.com/b9a05b" target="_blank" class="inline-flex cursor-help text-text-muted hover:text-brand-primary">
                <span data-toggle="tooltip" data-placement="right" title="<?= lang('Config.mailchimp_tooltip') ?>">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                </span>
            </a>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="mailchimp_list_id" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.mailchimp_lists') ?></label>
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <?= form_dropdown('mailchimp_list_id', $mailchimp['lists'], $mailchimp['list_id'], 'id="mailchimp_list_id" class="ui-select pl-10"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_mailchimp" id="submit_mailchimp" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        $('#mailchimp_api_key').change(function() {
            $.post("<?= "$controller_name/checkMailchimpApiKey" ?>", {
                    'mailchimp_api_key': $('#mailchimp_api_key').val()
                },
                function(response) {
                    $.notify({
                        message: response.message
                    }, {
                        type: response.success ? 'success' : 'danger'
                    });
                    $('#mailchimp_list_id').empty();
                    $.each(response.mailchimp_lists, function(val, text) {
                        $('#mailchimp_list_id').append(new Option(text, val));
                    });
                    $('#mailchimp_list_id').prop('selectedIndex', 0);
                },
                'json'
            );
        });

        $('#mailchimp_config_form').validate($.extend(form_support.handler, {
            submitHandler: function(form) {
                $(form).ajaxSubmit({
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

            errorLabelContainer: '#mailchimp_error_message_box'
        }));
    });
</script>
