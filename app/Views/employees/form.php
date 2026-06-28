<?php
/**
 * @var string $controller_name
 * @var object $person_info
 * @var array $all_modules
 * @var array $all_subpermissions
 * @var int $employee_id
 */
?>

<div id="required_fields_message" class="mb-3 text-sm text-text-muted"><?= lang('Common.fields_required_message') ?></div>
<ul id="error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<?= form_open("$controller_name/save/$person_info->person_id", ['id' => 'employee_form']) ?>

<div x-data="{ tab: 'basic' }">

    <div class="-mb-px flex border-b border-brand-primary-border">
        <button type="button" @click="tab = 'basic'"
            :class="tab === 'basic' ? 'border-b-2 border-brand-primary text-brand-primary-active font-semibold' : 'text-text-muted hover:text-text-default'"
            class="px-4 py-2.5 text-sm transition-colors">
            <?= lang('Employees.basic_information') ?>
        </button>
        <button type="button" @click="tab = 'login'"
            :class="tab === 'login' ? 'border-b-2 border-brand-primary text-brand-primary-active font-semibold' : 'text-text-muted hover:text-text-default'"
            class="px-4 py-2.5 text-sm transition-colors">
            <?= lang('Employees.login_info') ?>
        </button>
        <button type="button" @click="tab = 'permissions'"
            :class="tab === 'permissions' ? 'border-b-2 border-brand-primary text-brand-primary-active font-semibold' : 'text-text-muted hover:text-text-default'"
            class="px-4 py-2.5 text-sm transition-colors">
            <?= lang('Employees.permission_info') ?>
        </button>
    </div>

    <div x-show="tab === 'basic'" class="pt-4 space-y-4">
        <?= view('people/form_basic_info') ?>
    </div>

    <div x-show="tab === 'login'" style="display:none" class="pt-4 space-y-4">

        <div class="sm:flex sm:items-start sm:gap-4">
            <label for="username" class="required ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Employees.username') ?></label>
            <div class="relative flex-1">
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </span>
                <?= form_input([
                    'name'  => 'username',
                    'id'    => 'username',
                    'class' => 'ui-input pr-10',
                    'value' => $person_info->username
                ]) ?>
            </div>
        </div>

        <?php $password_label_class = $person_info->person_id == '' ? 'required ui-label sm:w-44 sm:shrink-0 sm:pt-2.5' : 'ui-label sm:w-44 sm:shrink-0 sm:pt-2.5'; ?>

        <div class="sm:flex sm:items-start sm:gap-4">
            <label for="password" class="<?= $password_label_class ?>"><?= lang('Employees.password') ?></label>
            <div class="relative flex-1">
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </span>
                <?= form_password([
                    'name'  => 'password',
                    'id'    => 'password',
                    'class' => 'ui-input pr-10'
                ]) ?>
            </div>
        </div>

        <div class="sm:flex sm:items-start sm:gap-4">
            <label for="repeat_password" class="<?= $password_label_class ?>"><?= lang('Employees.repeat_password') ?></label>
            <div class="relative flex-1">
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </span>
                <?= form_password([
                    'name'  => 'repeat_password',
                    'id'    => 'repeat_password',
                    'class' => 'ui-input pr-10'
                ]) ?>
            </div>
        </div>

        <div class="sm:flex sm:items-start sm:gap-4">
            <label for="language" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Employees.language') ?></label>
            <div class="relative flex-1">
                <?php
                $languages = get_languages();
                $languages[':'] = lang('Employees.system_language');
                $language_code = current_language_code();
                $language = current_language();

                if ($language_code === current_language_code(true)) {
                    $language_code = '';
                    $language = '';
                }

                echo form_dropdown(
                    'language',
                    $languages,
                    "$language_code:$language",
                    ['id' => 'language', 'class' => 'ui-select']
                );
                ?>
                <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
            </div>
        </div>

    </div>

    <div x-show="tab === 'permissions'" style="display:none" class="pt-4">

        <p class="mb-3 text-sm text-text-muted"><?= lang('Employees.permission_desc') ?></p>

        <?php
        /*
         * JS requires:
         *  - input.module checkboxes are DIRECT children of their <li> (selector: ul#permission_list > li > input.module)
         *  - sub-permission <ul> is also a DIRECT child of the same <li> (so $this.parent() finds it)
         * We use CSS grid on <li> to align checkbox / select / label while satisfying these constraints.
         */
        ?>
        <ul id="permission_list" class="space-y-2">
            <?php foreach ($all_modules as $module) {
                $has_subperms = false;
                foreach ($all_subpermissions as $sp) {
                    if ($sp->module_id == $module->module_id) { $has_subperms = true; break; }
                }
            ?>
                <li class="rounded-xl border border-brand-primary-border bg-surface-muted px-4 py-3">
                    <?php /* checkbox is a DIRECT child of <li> — required by JS selector */ ?>
                    <?= form_checkbox("grant_$module->module_id", $module->module_id, $module->grant == 1, 'class="module float-left mt-0.5 h-4 w-4 cursor-pointer rounded accent-brand-primary"') ?>
                    <div class="ml-7 flex flex-wrap items-center gap-3">
                        <div class="relative">
                            <?= form_dropdown(
                                "menu_group_$module->module_id",
                                [
                                    'home'   => lang('Module.home'),
                                    'office' => lang('Module.office'),
                                    'both'   => lang('Module.both')
                                ],
                                $module->menu_group,
                                'class="module ui-select !py-1 !text-xs !pr-7 !pl-2"'
                            ) ?>
                            <div class="ui-select-arrow"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                        </div>
                        <div class="min-w-0">
                            <span class="font-medium text-sm text-text-default"><?= lang("Module.$module->module_id") ?></span>
                            <span class="ml-1 text-xs text-text-muted"><?= lang("Module.$module->module_id" . '_desc') ?></span>
                        </div>
                    </div>
                    <?php if ($has_subperms) { ?>
                        <?php /* sub-permission <ul> is a DIRECT child of <li> — required by JS */ ?>
                        <ul class="ml-7 mt-2 space-y-1 border-t border-brand-primary-border pt-2 clear-both">
                            <?php foreach ($all_subpermissions as $permission) {
                                $exploded_permission = explode('_', $permission->permission_id, 2);
                                if ($permission->module_id == $module->module_id) {
                                    $lang_key = $module->module_id . '.' . $exploded_permission[1];
                                    $lang_line = lang(ucfirst($lang_key));
                                    $lang_line = (lang(ucfirst($lang_key)) == $lang_line) ? ucwords(str_replace("_", " ", $exploded_permission[1])) : $lang_line;
                                    if (!empty($lang_line)) {
                            ?>
                                        <li class="flex items-center gap-2">
                                            <?= form_checkbox("grant_$permission->permission_id", $permission->permission_id, $permission->grant == 1, 'class="h-4 w-4 cursor-pointer rounded accent-brand-primary"') ?>
                                            <?= form_hidden("menu_group_$permission->permission_id", "--") ?>
                                            <span class="text-sm text-text-default"><?= esc($lang_line) ?></span>
                                        </li>
                            <?php       }
                                }
                            } ?>
                        </ul>
                    <?php } ?>
                    <div class="clear-both"></div>
                </li>
            <?php } ?>
        </ul>

    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        $.validator.setDefaults({
            ignore: []
        });

        $.validator.addMethod('module', function(value, element) {
            var result = $('#permission_list input').is(':checked');
            $('.module').each(function(index, element) {
                var parent = $(element).parent();
                var checked = $(element).is(':checked');
                if ($('ul', parent).length > 0 && result) {
                    result &= !checked || (checked && $('ul > li > input:checked', parent).length > 0);
                }
            });
            return result;
        }, "<?= lang('Employees.subpermission_required') ?>");

        $('ul#permission_list > li > input.module').each(function() {
            var $this = $(this);
            $('ul > li > input,select', $this.parent()).each(function() {
                var $that = $(this);
                var updateInputs = function(checked) {
                    $that.prop('disabled', !checked);
                    !checked && $that.prop('checked', false);
                }
                $this.change(function() {
                    updateInputs($this.is(':checked'));
                });
                updateInputs($this.is(':checked'));
            });
        });

        $('#employee_form').validate($.extend({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        dialog_support.hide();
                        table_support.handle_submit("<?= esc($controller_name) ?>", response);
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: '#error_message_box',

            rules: {
                first_name: 'required',
                last_name: 'required',
                username: {
                    required: true,
                    minlength: 5,
                    remote: '<?= esc("$controller_name/checkUsername/$employee_id") ?>'
                },
                password: {
                    <?php if ($person_info->person_id == '') { ?>
                        required: true,
                    <?php } ?>
                    minlength: 8
                },
                repeat_password: {
                    equalTo: '#password'
                },
                email: 'email'
            },

            messages: {
                first_name: "<?= lang('Common.first_name_required') ?>",
                last_name: "<?= lang('Common.last_name_required') ?>",
                username: {
                    required: "<?= lang('Employees.username_required') ?>",
                    minlength: "<?= lang('Employees.username_minlength') ?>",
                    remote: "<?= lang('Employees.username_duplicate') ?>"
                },
                password: {
                    <?php if ($person_info->person_id == "") { ?>
                        required: "<?= lang('Employees.password_required') ?>",
                    <?php } ?>
                    minlength: "<?= lang('Employees.password_minlength') ?>"
                },
                repeat_password: {
                    equalTo: "<?= lang('Employees.password_must_match') ?>"
                },
                email: "<?= lang('Common.email_invalid_format') ?>"
            }
        }, form_support.error));
    });
</script>
