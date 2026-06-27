<?php
/**
 * @var string $specific_input_name
 * @var array $specific_input_data
 * @var array $sale_type_options
 * @var array $payment_type
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

            <div class="sm:flex sm:items-start sm:gap-4" id="report_specific_input_data">
                <label class="ui-label sm:w-36 sm:shrink-0 sm:pt-2.5"><?= esc($specific_input_name) ?></label>
                <div class="relative flex-1">
                    <?= form_dropdown('specific_input_data', $specific_input_data, '', 'id="specific_input_data" class="ui-select" data-live-search="true"') ?>
                    <div class="ui-select-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>
            </div>

            <div class="sm:flex sm:items-start sm:gap-4">
                <label class="ui-label sm:w-36 sm:shrink-0 sm:pt-2.5"><?= lang('Reports.sale_type') ?></label>
                <div id="report_sale_type" class="relative flex-1">
                    <?= form_dropdown('sale_type', $sale_type_options, 'complete', 'id="input_type" class="ui-select"') ?>
                    <div class="ui-select-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>
            </div>

            <div class="sm:flex sm:items-start sm:gap-4">
                <label class="ui-label sm:w-36 sm:shrink-0 sm:pt-2.5"><?= lang('Reports.payment_type') ?></label>
                <div class="relative flex-1">
                    <?= form_dropdown('payment_type', $payment_type, '', 'id="input_payment_type" class="ui-select"') ?>
                    <div class="ui-select-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>
            </div>

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
            window.location = [window.location, start_date, end_date, $('#specific_input_data').val(), $("#input_type").val(), $('#input_payment_type').val() || 0].join("/");
        });

    });
</script>
