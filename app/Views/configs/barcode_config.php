<?php
/**
 * @var array $support_barcode
 * @var array $config
 * @var array $barcode_fonts
 */
?>

<?= form_open('config/saveBarcode/', ['id' => 'barcode_config_form']) ?>

<ul id="barcode_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<div class="max-w-2xl space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="barcode_type" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.barcode_type') ?></label>
        <div class="relative w-48">
            <?= form_dropdown('barcode_type', $support_barcode, $config['barcode_type'], 'class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="barcode_width" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.barcode_width') ?> <span class="text-state-danger">*</span></label>
        <div class="w-24">
            <?= form_input(['step' => '5', 'max' => '350', 'min' => '60', 'type' => 'number', 'name' => 'barcode_width', 'id' => 'barcode_width', 'class' => 'ui-input required', 'value' => $config['barcode_width']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="barcode_height" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.barcode_height') ?> <span class="text-state-danger">*</span></label>
        <div class="w-24">
            <?= form_input(['type' => 'number', 'min' => 10, 'max' => 120, 'name' => 'barcode_height', 'id' => 'barcode_height', 'class' => 'ui-input required', 'value' => $config['barcode_height']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.barcode_font') ?> <span class="text-state-danger">*</span></label>
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative w-40">
                <?= form_dropdown('barcode_font', $barcode_fonts, $config['barcode_font'], 'class="ui-select" required') ?>
                <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
            </div>
            <div class="w-20">
                <?= form_input(['type' => 'number', 'min' => '1', 'max' => '30', 'name' => 'barcode_font_size', 'id' => 'barcode_font_size', 'class' => 'ui-input required', 'value' => $config['barcode_font_size']]) ?>
            </div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.allow_duplicate_barcodes') ?></label>
        <div class="flex items-center gap-2 pt-2">
            <?= form_checkbox(['name' => 'allow_duplicate_barcodes', 'id' => 'allow_duplicate_barcodes', 'value' => 'allow_duplicate_barcodes', 'checked' => $config['allow_duplicate_barcodes'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
            <span data-toggle="tooltip" data-placement="right" title="<?= lang('Config.barcode_tooltip') ?>" class="inline-flex cursor-help text-state-danger">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </span>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.barcode_content') ?></label>
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 pt-2">
            <label class="flex items-center gap-2 text-sm text-text-default">
                <?= form_radio(['name' => 'barcode_content', 'value' => 'id', 'checked' => $config['barcode_content'] == 'id']) ?>
                <?= lang('Config.barcode_id') ?>
            </label>
            <label class="flex items-center gap-2 text-sm text-text-default">
                <?= form_radio(['name' => 'barcode_content', 'value' => 'number', 'checked' => $config['barcode_content'] == 'number']) ?>
                <?= lang('Config.barcode_number') ?>
            </label>
            <label class="flex items-center gap-2 text-sm text-text-default">
                <?= form_checkbox(['name' => 'barcode_generate_if_empty', 'value' => 'barcode_generate_if_empty', 'checked' => $config['barcode_generate_if_empty'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
                <?= lang('Config.barcode_generate_if_empty') ?>
            </label>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="barcode_formats" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.barcode_formats') ?></label>
        <div class="flex-1 max-w-xs">
            <?php
            $barcode_formats = json_decode(config('OSPOS')->settings['barcode_formats']);
            echo form_dropdown([
                'name'      => 'barcode_formats[]',
                'id'        => 'barcode_formats',
                'options'   => !empty($barcode_formats) ? array_combine($barcode_formats, $barcode_formats) : [],
                'multiple'  => 'multiple',
                'data-role' => 'tagsinput'
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.barcode_layout') ?></label>
        <div class="flex flex-wrap items-end gap-3">
            <div>
                <span class="mb-1 block text-xs text-text-muted"><?= lang('Config.barcode_first_row') ?></span>
                <div class="relative w-36">
                    <?= form_dropdown('barcode_first_row', ['not_show' => lang('Config.none'), 'name' => lang('Items.name'), 'category' => lang('Items.category'), 'cost_price' => lang('Items.cost_price'), 'unit_price' => lang('Items.unit_price'), 'company_name' => lang('Suppliers.company_name')], $config['barcode_first_row'], ['class' => 'ui-select']) ?>
                    <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                </div>
            </div>
            <div>
                <span class="mb-1 block text-xs text-text-muted"><?= lang('Config.barcode_second_row') ?></span>
                <div class="relative w-36">
                    <?= form_dropdown('barcode_second_row', ['not_show' => lang('Config.none'), 'name' => lang('Items.name'), 'category' => lang('Items.category'), 'cost_price' => lang('Items.cost_price'), 'unit_price' => lang('Items.unit_price'), 'item_code' => lang('Items.item_number'), 'company_name' => lang('Suppliers.company_name')], $config['barcode_second_row'], ['class' => 'ui-select']) ?>
                    <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                </div>
            </div>
            <div>
                <span class="mb-1 block text-xs text-text-muted"><?= lang('Config.barcode_third_row') ?></span>
                <div class="relative w-36">
                    <?= form_dropdown('barcode_third_row', ['not_show' => lang('Config.none'), 'name' => lang('Items.name'), 'category' => lang('Items.category'), 'cost_price' => lang('Items.cost_price'), 'unit_price' => lang('Items.unit_price'), 'item_code' => lang('Items.item_number'), 'company_name' => lang('Suppliers.company_name')], $config['barcode_third_row'], ['class' => 'ui-select']) ?>
                    <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                </div>
            </div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="barcode_num_in_row" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.barcode_number_in_row') ?> <span class="text-state-danger">*</span></label>
        <div class="w-24">
            <?= form_input(['type' => 'number', 'name' => 'barcode_num_in_row', 'id' => 'barcode_num_in_row', 'class' => 'ui-input required', 'value' => $config['barcode_num_in_row']]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="barcode_page_width" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.barcode_page_width') ?> <span class="text-state-danger">*</span></label>
        <div class="flex items-center gap-2">
            <?= form_input(['type' => 'number', 'min' => '0', 'max' => '100', 'name' => 'barcode_page_width', 'id' => 'barcode_page_width', 'class' => 'ui-input w-20 required', 'value' => $config['barcode_page_width']]) ?>
            <span class="text-sm text-text-muted">%</span>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="barcode_page_cellspacing" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Config.barcode_page_cellspacing') ?> <span class="text-state-danger">*</span></label>
        <div class="flex items-center gap-2">
            <?= form_input(['type' => 'number', 'name' => 'barcode_page_cellspacing', 'id' => 'barcode_page_cellspacing', 'class' => 'ui-input w-20 required', 'value' => $config['barcode_page_cellspacing']]) ?>
            <span class="text-sm text-text-muted">px</span>
        </div>
    </div>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_barcode" id="submit_barcode" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        $('#barcode_config_form').validate($.extend(form_support.handler, {

            errorLabelContainer: "#barcode_error_message_box",

            rules: {
                barcode_width: { required: true, number: true },
                barcode_height: { required: true, number: true },
                barcode_font_size: { required: true, number: true },
                barcode_num_in_row: { required: true, number: true },
                barcode_page_width: { required: true, number: true },
                barcode_page_cellspacing: { required: true, number: true }
            },

            messages: {
                barcode_width: { required: "<?= lang('Config.default_barcode_width_required') ?>", number: "<?= lang('Config.default_barcode_width_number') ?>" },
                barcode_height: { required: "<?= lang('Config.default_barcode_height_required') ?>", number: "<?= lang('Config.default_barcode_height_number') ?>" },
                barcode_font_size: { required: "<?= lang('Config.default_barcode_font_size_required') ?>", number: "<?= lang('Config.default_barcode_font_size_number') ?>" },
                barcode_num_in_row: { required: "<?= lang('Config.default_barcode_num_in_row_required') ?>", number: "<?= lang('Config.default_barcode_num_in_row_number') ?>" },
                barcode_page_width: { required: "<?= lang('Config.default_barcode_page_width_required') ?>", number: "<?= lang('Config.default_barcode_page_width_number') ?>" },
                barcode_page_cellspacing: { required: "<?= lang('Config.default_barcode_page_cellspacing_required') ?>", number: "<?= lang('Config.default_barcode_page_cellspacing_number') ?>" }
            }
        }));
    });
</script>
