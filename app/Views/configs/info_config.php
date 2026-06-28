<?php
/**
 * @var bool $logo_exists
 * @var string $controller_name
 * @var array $config
 */
?>

<?= form_open('config/saveInfo/', ['id' => 'info_config_form', 'enctype' => 'multipart/form-data']) ?>

<ul id="info_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<div class="max-w-2xl space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="company" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.company') ?> <span class="text-state-danger">*</span></label>
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <?= form_input(['name' => 'company', 'id' => 'company', 'class' => 'ui-input pr-10 required', 'value' => $config['company']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="company_logo" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.company_logo') ?></label>
        <div class="flex-1">
            <div class="fileinput <?= $logo_exists ? 'fileinput-exists' : 'fileinput-new' ?>" data-provides="fileinput">
                <div class="fileinput-new rounded-xl border border-dashed border-brand-primary-border bg-surface-muted" style="width: 200px; height: 200px;"></div>
                <div class="fileinput-preview fileinput-exists rounded-xl border border-brand-primary-border overflow-hidden" style="max-width: 200px; max-height: 200px;">
                    <img data-src="holder.js/100%x100%" alt="<?= esc(lang('Config.company_logo')) ?>" src="<?= $logo_src ?>" style="max-height: 100%; max-width: 100%;">
                </div>
                <div class="mt-2 flex flex-wrap items-center gap-2">
                    <span class="ui-btn-secondary btn-file !text-sm">
                        <span class="fileinput-new"><?= lang('Config.company_select_image') ?></span>
                        <span class="fileinput-exists"><?= lang('Config.company_change_image') ?></span>
                        <input type="file" name="company_logo">
                    </span>
                    <a href="#" class="ui-btn-secondary fileinput-exists text-sm" data-dismiss="fileinput"><?= lang('Config.company_remove_image') ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="address" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.address') ?> <span class="text-state-danger">*</span></label>
        <div class="flex-1">
            <?= form_textarea(['name' => 'address', 'id' => 'address', 'class' => 'ui-input min-h-[80px] resize-y required', 'value' => $config['address']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="website" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.website') ?></label>
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            </div>
            <?= form_input(['name' => 'website', 'id' => 'website', 'class' => 'ui-input pr-10', 'value' => $config['website']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="email" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Common.email') ?></label>
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <?= form_input(['name' => 'email', 'id' => 'email', 'type' => 'email', 'class' => 'ui-input pr-10', 'value' => $config['email']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="phone" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.phone') ?> <span class="text-state-danger">*</span></label>
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.89 11.7 19.79 19.79 0 0 1 1.15 3 2 2 0 0 1 3.14 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 5.94 5.94l1.32-1.32a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </div>
            <?= form_input(['type' => 'tel', 'name' => 'phone', 'id' => 'phone', 'class' => 'ui-input pr-10 required', 'value' => $config['phone']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="fax" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.fax') ?></label>
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.89 11.7 19.79 19.79 0 0 1 1.15 3 2 2 0 0 1 3.14 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 5.94 5.94l1.32-1.32a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </div>
            <?= form_input(['type' => 'tel', 'name' => 'fax', 'id' => 'fax', 'class' => 'ui-input pr-10', 'value' => $config['fax']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="return_policy" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Common.return_policy') ?> <span class="text-state-danger">*</span></label>
        <div class="flex-1">
            <?= form_textarea(['name' => 'return_policy', 'id' => 'return_policy', 'class' => 'ui-input min-h-[80px] resize-y required', 'value' => $config['return_policy']]) ?>
        </div>
    </div>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_info" id="submit_info" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("a.fileinput-exists").click(function() {
            $.ajax({
                type: 'POST',
                url: '<?= "$controller_name/removeLogo"; ?>',
                dataType: 'json'
            })
        });

        $('#info_config_form').validate($.extend(form_support.handler, {

            errorLabelContainer: "#info_error_message_box",

            rules: {
                company: "required",
                address: "required",
                phone: "required",
                email: "email",
                return_policy: "required"
            },

            messages: {
                company: "<?= lang('Config.company_required') ?>",
                address: "<?= lang('Config.address_required') ?>",
                phone: "<?= lang('Config.phone_required') ?>",
                email: "<?= lang('Common.email_invalid_format') ?>",
                return_policy: "<?= lang('Config.return_policy_required') ?>"
            }
        }));
    });
</script>
