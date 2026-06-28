<?php
/**
 * @var string $title
 * @var string $subtitle
 * @var string $chart_type
 * @var array $summary_data_1
 */
?>

<?= view('partial/header') ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>

<div class="mb-4">
    <h1 id="page_title" class="font-display text-2xl font-semibold text-brand-primary-active"><?= esc($title) ?></h1>
    <p id="page_subtitle" class="mt-1 text-sm text-text-muted"><?= esc($subtitle) ?></p>
</div>

<div class="ui-card mb-4 p-6">
    <div class="ct-chart ct-golden-section" id="chart1"></div>

    <div id="toolbar" class="mt-4">
        <div class="flex flex-wrap items-center gap-2">
            <button id="toggleCostProfitButton" class="ui-btn-secondary print_hide">
                <?= lang('Reports.toggle_cost_and_profit') ?>
            </button>
        </div>
    </div>
</div>

<?= view($chart_type) ?>

<div id="chart_report_summary" class="mt-6 rounded-xl border border-brand-primary-border bg-surface p-6 text-center">
    <?php foreach ($summary_data_1 as $name => $value) { ?>
        <div class="summary_row py-1 text-sm font-medium text-text-default"><?= lang("Reports.$name") . ': ' . esc(to_currency($value)) ?></div>
    <?php } ?>
</div>

<script src="<?= base_url('js/hide_cost_profit.js') ?>"></script>

<?= view('partial/footer') ?>
