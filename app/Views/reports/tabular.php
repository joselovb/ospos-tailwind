<?php
/**
 * @var string $title
 * @var string $subtitle
 * @var array $summary_data
 * @var array $headers
 * @var array $data
 * @var array $config
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

<div id="toolbar" class="mb-3">
    <div class="flex flex-wrap items-center gap-2">
        <button id="toggleCostProfitButton" class="ui-btn-secondary print_hide">
            <?= lang('Reports.toggle_cost_and_profit') ?>
        </button>
    </div>
</div>

<div class="ui-card p-4">
    <div id="table_holder">
        <table id="table"></table>
    </div>
</div>

<div id="report_summary" class="mt-6 rounded-xl border border-brand-primary-border bg-surface p-6">
    <?php
    foreach ($summary_data as $name => $value) {
        if ($name == "total_quantity") {
            ?>
            <div class="summary_row py-1 text-sm font-medium text-text-default"><?= lang("Reports.$name") . ": " . esc($value) ?></div>
        <?php } else { ?>
            <div class="summary_row py-1 text-sm font-medium text-text-default"><?= lang("Reports.$name") . ': ' . to_currency($value) ?></div>
            <?php
        }
    }
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        <?= view('partial/bootstrap_tables_locale') ?>
        <?= view('partial/visibility_js') ?>

        $('#table')
            .addClass("table-striped")
            .addClass("table-bordered")
            .bootstrapTable({
                columns: applyColumnVisibility(<?= transform_headers(esc($headers), true, false) ?>),
                stickyHeader: true,
                stickyHeaderOffsetLeft: $('#table').offset().left + 'px',
                stickyHeaderOffsetRight: $('#table').offset().right + 'px',
                pageSize: <?= $config['lines_per_page'] ?>,
                sortable: true,
                showExport: true,
                exportDataType: 'all',
                exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
                pagination: true,
                showColumns: true,
                data: <?= json_encode($data) ?>,
                iconSize: 'sm',
                paginationVAlign: 'bottom',
                escape: true,
                search: true
            });
    });
</script>

<?= view('partial/footer') ?>
