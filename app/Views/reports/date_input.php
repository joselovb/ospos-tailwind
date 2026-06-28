<?php
/**
 * @var array $sale_type_options
 * @var array $config
 */
?>

<?= view('partial/header') ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>

<div class="mb-6">
    <h1 id="page_title" class="font-display text-2xl font-semibold text-brand-primary-active"><?= lang('Reports.report_input') ?></h1>
</div>

<?php if (isset($error)) { ?>
    <div class="ui-alert-danger mb-4"><?= esc($error) ?></div>
<?php } ?>

<div class="ui-card max-w-lg p-6">

    <?= form_open('#', ['id' => 'item_form', 'enctype' => 'multipart/form-data']) ?>

        <div class="space-y-4">

            <div class="sm:flex sm:items-start sm:gap-4">
                <label class="ui-label sm:w-36 sm:shrink-0 sm:pt-2.5"><?= lang('Reports.date_range') ?></label>
                <div class="flex-1">
                    <?= form_input(['name' => 'daterangepicker', 'class' => 'ui-input', 'id' => 'daterangepicker']) ?>
                </div>
            </div>

            <?php if (!empty($mode)) { ?>
                <div class="sm:flex sm:items-start sm:gap-4">
                    <?php if ($mode == 'sale') { ?>
                        <label class="ui-label sm:w-36 sm:shrink-0 sm:pt-2.5"><?= lang('Reports.sale_type') ?></label>
                        <div id="report_sale_type" class="relative flex-1">
                            <?= form_dropdown('sale_type', $sale_type_options, 'complete', ['id' => 'input_type', 'class' => 'ui-select']) ?>
                            <div class="ui-select-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                            </div>
                        </div>
                    <?php } elseif ($mode == 'receiving') { ?>
                        <label class="ui-label sm:w-36 sm:shrink-0 sm:pt-2.5"><?= lang('Reports.receiving_type') ?></label>
                        <div id="report_receiving_type" class="relative flex-1">
                            <?= form_dropdown(
                                'receiving_type',
                                [
                                    'all'          => lang('Reports.all'),
                                    'receiving'    => lang('Reports.receivings'),
                                    'returns'      => lang('Reports.returns'),
                                    'requisitions' => lang('Reports.requisitions')
                                ],
                                'all',
                                ['id' => 'input_type', 'class' => 'ui-select']
                            ) ?>
                            <div class="ui-select-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (isset($discount_type_options)) { ?>
                <div class="sm:flex sm:items-start sm:gap-4">
                    <label class="ui-label sm:w-36 sm:shrink-0 sm:pt-2.5"><?= lang('Reports.discount_type') ?></label>
                    <div id="report_discount_type" class="relative flex-1">
                        <?= form_dropdown('discount_type', $discount_type_options, $config['default_sales_discount_type'], ['id' => 'discount_type_id', 'class' => 'ui-select']) ?>
                        <div class="ui-select-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (!empty($stock_locations) && count($stock_locations) > 2) { ?>
                <div class="sm:flex sm:items-start sm:gap-4">
                    <label class="ui-label sm:w-36 sm:shrink-0 sm:pt-2.5"><?= lang('Reports.stock_location') ?></label>
                    <div id="report_stock_location" class="relative flex-1">
                        <?= form_dropdown('stock_location', $stock_locations, 'all', ['id' => 'location_id', 'class' => 'ui-select']) ?>
                        <div class="ui-select-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>

        <div class="mt-6">
            <?= form_button(['name' => 'generate_report', 'id' => 'generate_report', 'content' => lang('Common.submit'), 'class' => 'ui-btn-primary']) ?>
        </div>

    <?= form_close() ?>

</div>

<?= view('partial/footer') ?>

<script type="text/javascript">
    $(document).ready(function() {
        <?= view('partial/daterangepicker') ?>

        $("#generate_report").click(function() {
            window.location = [window.location, start_date, end_date, $("#input_type").val() || 0, $("#location_id").val() || 'all', $("#discount_type_id").val() || 0].join("/");
        });
    });
</script>
