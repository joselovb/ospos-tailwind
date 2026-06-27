<?php
/**
 * @var array $config
 */
?>

<?= form_open('config/saveMessage/', ['id' => 'message_config_form', 'enctype' => 'multipart/form-data']) ?>

<ul id="message_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<div class="max-w-2xl space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="msg_uid" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.msg_uid') ?> <span class="text-state-danger">*</span></label>
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <?= form_input(['name' => 'msg_uid', 'id' => 'msg_uid', 'class' => 'ui-input pl-10 required', 'value' => $config['msg_uid']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="msg_pwd" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.msg_pwd') ?> <span class="text-state-danger">*</span></label>
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <?= form_password(['name' => 'msg_pwd', 'id' => 'msg_pwd', 'class' => 'ui-input pl-10 required', 'value' => $config['msg_pwd']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="msg_src" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.msg_src') ?> <span class="text-state-danger">*</span></label>
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg>
            </div>
            <?= form_input(['name' => 'msg_src', 'id' => 'msg_src', 'class' => 'ui-input pl-10 required', 'value' => $config['msg_src'] == null ? $config['company'] : $config['msg_src']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="msg_msg" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.msg_msg') ?></label>
        <div class="flex-1">
            <?= form_textarea(['name' => 'msg_msg', 'id' => 'msg_msg', 'class' => 'ui-input min-h-[80px] resize-y', 'value' => $config['msg_msg'], 'placeholder' => lang('Config.msg_msg_placeholder')]) ?>
        </div>
    </div>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_message" id="submit_message" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#message_config_form').validate($.extend(form_support.handler, {

            errorLabelContainer: "#message_error_message_box",

            rules: {
                msg_uid: "required",
                msg_pwd: "required",
                msg_src: "required"
            },

            messages: {
                msg_uid: "<?= lang('Config.msg_uid_required') ?>",
                msg_pwd: "<?= lang('Config.msg_pwd_required') ?>",
                msg_src: "<?= lang('Config.msg_src_required') ?>"
            }
        }));
    });
</script>
