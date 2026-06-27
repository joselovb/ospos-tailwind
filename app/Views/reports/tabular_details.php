<?php
/**
 * @var string $title
 * @var string $subtitle
 * @var array $overall_summary_data
 * @var array $details_data
 * @var array $headers
 * @var array $summary_data
 * @var array $config
 */
?>

<?= view('partial/header') ?>

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
    <?php foreach ($overall_summary_data as $name => $value) { ?>
        <div class="summary_row py-1 text-sm font-medium text-text-default"><?= lang("Reports.$name") . ': ' . esc(to_currency($value)) ?></div>
    <?php } ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        <?= view('partial/bootstrap_tables_locale') ?>

        var details_data = <?= json_encode(esc($details_data)) ?>;
        <?php if ($config['customer_reward_enable'] && !empty($details_data_rewards)) { ?>
            var details_data_rewards = <?= json_encode(esc($details_data_rewards)) ?>;
        <?php } ?>
        <?= view('partial/visibility_js') ?>

        var init_dialog = function () {
            <?php if (isset($editable)) { ?>
                table_support.submit_handler('<?= esc(site_url("reports/get_detailed_$editable" . '_row')) ?>');
                dialog_support.init("a.modal-dlg");
            <?php } ?>
        };

        $('#table')
            .addClass("table-striped")
            .addClass("table-bordered")
            .bootstrapTable({
                columns: applyColumnVisibility(<?= transform_headers(esc($headers['summary']), true) ?>),
                stickyHeader: true,
                stickyHeaderOffsetLeft: $('#table').offset().left + 'px',
                stickyHeaderOffsetRight: $('#table').offset().right + 'px',
                pageSize: <?= $config['lines_per_page'] ?>,
                pagination: true,
                sortable: true,
                showColumns: true,
                uniqueId: 'id',
                showExport: true,
                exportDataType: 'all',
                exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
                data: <?= json_encode($summary_data) ?>,
                iconSize: 'sm',
                paginationVAlign: 'bottom',
                detailView: true,
                escape: true,
                search: true,
                onPageChange: init_dialog,
                onPostBody: function () {
                    dialog_support.init("a.modal-dlg");
                },
                onExpandRow: function (index, row, $detail) {
                    $detail.html('<table></table>').find("table").bootstrapTable({
                        columns: <?= transform_headers_readonly(esc($headers['details'])) ?>,
                        data: details_data[(!isNaN(row.id) && row.id) || $(row[0] || row.id).text().replace(
                            /(POS|RECV)\s*/g, '')]
                    });

                    <?php if ($config['customer_reward_enable'] && !empty($details_data_rewards)) { ?>
                        $detail.append('<table></table>').find("table").bootstrapTable({
                            columns: <?= transform_headers_readonly(esc($headers['details_rewards'])) ?>,
                            data: details_data_rewards[(!isNaN(row.id) && row.id) || $(row[0] || row.id).text().replace(
                                /(POS|RECV)\s*/g, '')]
                        });
                    <?php } ?>
                }
            });

        init_dialog();
    });
</script>

<?= view('partial/footer') ?>
