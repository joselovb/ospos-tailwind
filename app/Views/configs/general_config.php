<?php
/**
 * @var array $themes
 * @var array $image_allowed_types
 * @var array $selected_image_allowed_types
 * @var bool $show_office_group
 * @var string $controller_name
 * @var array $config
 */
?>

<?= form_open('config/saveGeneral/', ['id' => 'general_config_form', 'enctype' => 'multipart/form-data']) ?>

<ul id="general_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<div class="max-w-3xl space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="theme-change" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.theme') ?></label>
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative w-48">
                <?= form_dropdown('theme', $themes, $config['theme'], 'class="ui-select" id="theme-change"') ?>
                <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
            </div>
            <a href="<?= 'https://bootswatch.com/3/' . ('bootstrap' == ($config['theme']) ? 'default' : esc($config['theme'])) ?>" target="_blank" rel="noopener" class="flex items-center gap-1 text-sm text-brand-primary hover:underline">
                <?= lang('Config.theme_preview') . ' ' . ucfirst(esc($config['theme'])) ?>
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="login_form" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.login_form') ?></label>
        <div class="relative w-48">
            <?= form_dropdown('login_form', ['floating_labels' => lang('Config.floating_labels'), 'input_groups' => lang('Config.input_groups')], $config['login_form'], 'class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="default_sales_discount" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.default_sales_discount') ?> <span class="text-state-danger">*</span></label>
        <div class="flex items-center gap-3">
            <?= form_input(['name' => 'default_sales_discount', 'id' => 'default_sales_discount', 'class' => 'ui-input w-24 required', 'type' => 'number', 'min' => 0, 'max' => 100, 'value' => $config['default_sales_discount']]) ?>
            <?= form_checkbox(['id' => 'default_sales_discount_type', 'name' => 'default_sales_discount_type', 'value' => 1, 'data-toggle' => 'toggle', 'data-size' => 'normal', 'data-onstyle' => 'success', 'data-on' => '<b>' . $config['currency_symbol'] . '</b>', 'data-off' => '<b>%</b>', 'checked' => $config['default_sales_discount_type'] == 1]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="default_receivings_discount" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.default_receivings_discount') ?> <span class="text-state-danger">*</span></label>
        <div class="flex items-center gap-3">
            <?= form_input(['name' => 'default_receivings_discount', 'id' => 'default_receivings_discount', 'class' => 'ui-input w-24 required', 'type' => 'number', 'min' => 0, 'max' => 100, 'value' => $config['default_receivings_discount']]) ?>
            <?= form_checkbox(['id' => 'default_receivings_discount_type', 'name' => 'default_receivings_discount_type', 'value' => 1, 'data-toggle' => 'toggle', 'data-size' => 'normal', 'data-onstyle' => 'success', 'data-on' => '<b>' . $config['currency_symbol'] . '</b>', 'data-off' => '<b>%</b>', 'checked' => $config['default_receivings_discount_type'] == 1]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.enforce_privacy') ?></label>
        <div class="flex items-center gap-2 pt-2">
            <?= form_checkbox(['name' => 'enforce_privacy', 'id' => 'enforce_privacy', 'value' => 'enforce_privacy', 'checked' => $config['enforce_privacy'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
            <span data-toggle="tooltip" data-placement="right" title="<?= lang('Config.enforce_privacy_tooltip') ?>" class="inline-flex cursor-help text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </span>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.receiving_calculate_average_price') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'receiving_calculate_average_price', 'id' => 'receiving_calculate_average_price', 'value' => 'receiving_calculate_average_price', 'checked' => $config['receiving_calculate_average_price'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="lines_per_page" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.lines_per_page') ?> <span class="text-state-danger">*</span></label>
        <div class="w-24">
            <?= form_input(['name' => 'lines_per_page', 'id' => 'lines_per_page', 'class' => 'ui-input required', 'type' => 'number', 'min' => 10, 'max' => 1000, 'value' => $config['lines_per_page']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.notify_alignment') ?></label>
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative w-28">
                <?= form_dropdown('notify_vertical_position', ['top' => lang('Config.top'), 'bottom' => lang('Config.bottom')], $config['notify_vertical_position'], 'class="ui-select"') ?>
                <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
            </div>
            <div class="relative w-28">
                <?= form_dropdown('notify_horizontal_position', ['left' => lang('Config.left'), 'center' => lang('Config.center'), 'right' => lang('Config.right')], $config['notify_horizontal_position'], 'class="ui-select"') ?>
                <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
            </div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.image_restrictions') ?></label>
        <div class="flex flex-wrap items-start gap-3">
            <div class="relative w-28">
                <?= form_input(['name' => 'image_max_width', 'id' => 'image_max_width', 'class' => 'ui-input required', 'type' => 'number', 'min' => 128, 'max' => 3840, 'value' => $config['image_max_width'], 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => lang('Config.image_max_width_tooltip'), 'placeholder' => 'W px']) ?>
            </div>
            <div class="relative w-28">
                <?= form_input(['name' => 'image_max_height', 'id' => 'image_max_height', 'class' => 'ui-input required', 'type' => 'number', 'min' => 128, 'max' => 3840, 'value' => $config['image_max_height'], 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => lang('Config.image_max_height_tooltip'), 'placeholder' => 'H px']) ?>
            </div>
            <div class="relative w-28">
                <?= form_input(['name' => 'image_max_size', 'id' => 'image_max_size', 'class' => 'ui-input required', 'type' => 'number', 'min' => 128, 'max' => 2048, 'value' => $config['image_max_size'], 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => lang('Config.image_max_size_tooltip'), 'placeholder' => 'KB']) ?>
            </div>
            <div class="relative">
                <?= form_multiselect(['name' => 'image_allowed_types[]', 'options' => $image_allowed_types, 'selected' => $selected_image_allowed_types, 'id' => 'image_allowed_types', 'class' => 'selectpicker show-menu-arrow', 'data-none-selected-text' => lang('Common.none_selected_text'), 'data-selected-text-format' => 'count > 1', 'data-style' => 'btn-default btn-sm', 'data-width' => '180px']) ?>
            </div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.gcaptcha_enable') ?></label>
        <div class="flex items-center gap-2 pt-2">
            <?= form_checkbox(['name' => 'gcaptcha_enable', 'id' => 'gcaptcha_enable', 'value' => 'gcaptcha_enable', 'checked' => $config['gcaptcha_enable'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
            <a href="https://www.google.com/recaptcha/admin" target="_blank" class="inline-flex cursor-help text-text-muted hover:text-brand-primary">
                <span data-toggle="tooltip" data-placement="right" title="<?= lang('Config.gcaptcha_tooltip') ?>">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                </span>
            </a>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label id="config_gcaptcha_site_key" for="gcaptcha_site_key" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5 required"><?= lang('Config.gcaptcha_site_key') ?></label>
        <div class="flex-1">
            <?= form_input(['name' => 'gcaptcha_site_key', 'id' => 'gcaptcha_site_key', 'class' => 'ui-input required', 'value' => $config['gcaptcha_site_key']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label id="config_gcaptcha_secret_key" for="gcaptcha_secret_key" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5 required"><?= lang('Config.gcaptcha_secret_key') ?></label>
        <div class="flex-1">
            <?= form_input(['name' => 'gcaptcha_secret_key', 'id' => 'gcaptcha_secret_key', 'class' => 'ui-input required', 'value' => $config['gcaptcha_secret_key']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.suggestions_layout') ?></label>
        <div class="flex flex-wrap items-end gap-3">
            <div>
                <span class="mb-1 block text-xs text-text-muted"><?= lang('Config.suggestions_first_column') ?></span>
                <div class="relative w-36">
                    <?= form_dropdown('suggestions_first_column', ['name' => lang('Items.name'), 'item_number' => lang('Items.number_information'), 'unit_price' => lang('Items.unit_price'), 'cost_price' => lang('Items.cost_price')], $config['suggestions_first_column'], 'class="ui-select"') ?>
                    <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                </div>
            </div>
            <div>
                <span class="mb-1 block text-xs text-text-muted"><?= lang('Config.suggestions_second_column') ?></span>
                <div class="relative w-36">
                    <?= form_dropdown('suggestions_second_column', ['' => lang('Config.none'), 'name' => lang('Items.name'), 'item_number' => lang('Items.number_information'), 'unit_price' => lang('Items.unit_price'), 'cost_price' => lang('Items.cost_price')], $config['suggestions_second_column'], 'class="ui-select"') ?>
                    <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                </div>
            </div>
            <div>
                <span class="mb-1 block text-xs text-text-muted"><?= lang('Config.suggestions_third_column') ?></span>
                <div class="relative w-36">
                    <?= form_dropdown('suggestions_third_column', ['' => lang('Config.none'), 'name' => lang('Items.name'), 'item_number' => lang('Items.number_information'), 'unit_price' => lang('Items.unit_price'), 'cost_price' => lang('Items.cost_price')], $config['suggestions_third_column'], 'class="ui-select"') ?>
                    <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                </div>
            </div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.giftcard_number') ?></label>
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 pt-2">
            <label class="flex items-center gap-2 text-sm text-text-default">
                <?= form_radio(['name' => 'giftcard_number', 'value' => 'series', 'checked' => $config['giftcard_number'] == 'series']) ?>
                <?= lang('Config.giftcard_series') ?>
            </label>
            <label class="flex items-center gap-2 text-sm text-text-default">
                <?= form_radio(['name' => 'giftcard_number', 'value' => 'random', 'checked' => $config['giftcard_number'] == 'random']) ?>
                <?= lang('Config.giftcard_random') ?>
            </label>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.derive_sale_quantity') ?></label>
        <div class="flex items-center gap-2 pt-2">
            <?= form_checkbox(['name' => 'derive_sale_quantity', 'id' => 'derive_sale_quantity', 'value' => 'derive_sale_quantity', 'checked' => $config['derive_sale_quantity'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
            <span data-toggle="tooltip" data-placement="right" title="<?= lang('Config.derive_sale_quantity_tooltip') ?>" class="inline-flex cursor-help text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </span>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.show_office_group') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'show_office_group', 'id' => 'show_office_group', 'value' => 'show_office_group', 'checked' => $show_office_group > 0, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.multi_pack_enabled') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'multi_pack_enabled', 'id' => 'multi_pack_enabled', 'value' => 'multi_pack_enabled', 'checked' => $config['multi_pack_enabled'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.include_hsn') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'include_hsn', 'id' => 'include_hsn', 'value' => 'include_hsn', 'checked' => $config['include_hsn'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.category_dropdown') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'category_dropdown', 'id' => 'category_dropdown', 'value' => 'category_dropdown', 'checked' => $config['category_dropdown'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_general" id="submit_general" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        var enable_disable_gcaptcha_enable = (function() {
            var gcaptcha_enable = $("#gcaptcha_enable").is(":checked");
            if (gcaptcha_enable) {
                $("#gcaptcha_site_key, #gcaptcha_secret_key").prop("disabled", !gcaptcha_enable).addClass("required");
                $("#config_gcaptcha_site_key, #config_gcaptcha_secret_key").addClass("required");
            } else {
                $("#gcaptcha_site_key, #gcaptcha_secret_key").prop("disabled", gcaptcha_enable).removeClass("required");
                $("#config_gcaptcha_site_key, #config_gcaptcha_secret_key").removeClass("required");
            }

            return arguments.callee;
        })();

        $("#gcaptcha_enable").change(enable_disable_gcaptcha_enable);

        $('#general_config_form').validate($.extend(form_support.handler, {

            errorLabelContainer: "#general_error_message_box",

            rules: {
                lines_per_page: {
                    required: true,
                    remote: "<?= "$controller_name/checkNumeric" ?>"
                },
                default_sales_discount: {
                    required: true,
                    remote: "<?= "$controller_name/checkNumeric" ?>"
                },
                gcaptcha_site_key: {
                    required: "#gcaptcha_enable:checked"
                },
                gcaptcha_secret_key: {
                    required: "#gcaptcha_enable:checked"
                }
            },

            messages: {
                default_sales_discount: {
                    required: "<?= lang('Config.default_sales_discount_required') ?>",
                    number: "<?= lang('Config.default_sales_discount_number') ?>"
                },
                lines_per_page: {
                    required: "<?= lang('Config.lines_per_page_required') ?>",
                    number: "<?= lang('Config.lines_per_page_number') ?>"
                },
                gcaptcha_site_key: {
                    required: "<?= lang('Config.gcaptcha_site_key_required') ?>"
                },
                gcaptcha_secret_key: {
                    required: "<?= lang('Config.gcaptcha_secret_key_required') ?>"
                }
            },

            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    beforeSerialize: function(arr, $form, options) {
                        $("#gcaptcha_site_key, #gcaptcha_secret_key").prop("disabled", false);
                        return true;
                    },
                    success: function(response) {
                        $.notify({
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        })
                        enable_disable_gcaptcha_enable();
                    },
                    dataType: 'json'
                });
            }
        }));
    });
</script>
