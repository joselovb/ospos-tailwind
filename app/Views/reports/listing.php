<?php
/**
 * @var int   $person_id
 * @var array $permission_ids
 * @var array $grants
 */

$detailed_reports = [
    'reports_sales'      => 'detailed',
    'reports_receivings' => 'detailed',
    'reports_customers'  => 'specific',
    'reports_discounts'  => 'specific',
    'reports_employees'  => 'specific',
    'reports_suppliers'  => 'specific',
];
?>

<?= view('partial/header') ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>

<?php if (isset($error)) { ?>
    <div class="ui-alert-danger mb-4"><?= esc($error) ?></div>
<?php } ?>

<div class="mb-6 flex items-center gap-3">
    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-primary to-brand-accent">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-text-on-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
    </div>
    <h1 class="font-display text-2xl font-semibold text-brand-primary-active"><?= lang('Reports.reports') ?></h1>
</div>

<div class="grid grid-cols-1 gap-6 md:grid-cols-3">

    <!-- Graphical Reports -->
    <div class="ui-card overflow-hidden">
        <div class="flex items-center gap-2.5 bg-gradient-to-r from-brand-primary to-brand-accent px-4 py-3.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-text-on-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            <h3 class="font-display font-semibold text-text-on-brand"><?= lang('Reports.graphical_reports') ?></h3>
        </div>
        <div class="divide-y divide-brand-primary-border">
            <?php foreach ($permission_ids as $permission_id) {
                if (can_show_report($permission_id, ['inventory', 'receiving'])) {
                    $link = get_report_link($permission_id, 'graphical_summary');
            ?>
                <a href="<?= $link['path'] ?>"
                   class="flex items-center gap-2 px-4 py-3 text-sm text-text-default transition-colors hover:bg-brand-primary-soft hover:text-brand-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0 text-text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    <?= esc($link['label']) ?>
                </a>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Summary Reports -->
    <div class="ui-card overflow-hidden">
        <div class="flex items-center gap-2.5 bg-gradient-to-r from-brand-primary to-brand-accent px-4 py-3.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-text-on-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            <h3 class="font-display font-semibold text-text-on-brand"><?= lang('Reports.summary_reports') ?></h3>
        </div>
        <div class="divide-y divide-brand-primary-border">
            <?php foreach ($permission_ids as $permission_id) {
                if (can_show_report($permission_id, ['inventory', 'receiving'])) {
                    $link = get_report_link($permission_id, 'summary');
            ?>
                <a href="<?= $link['path'] ?>"
                   class="flex items-center gap-2 px-4 py-3 text-sm text-text-default transition-colors hover:bg-brand-primary-soft hover:text-brand-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0 text-text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    <?= esc($link['label']) ?>
                </a>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Detailed + Inventory Reports (stacked in same column) -->
    <div class="space-y-6">
        <div class="ui-card overflow-hidden">
            <div class="flex items-center gap-2.5 bg-gradient-to-r from-brand-primary to-brand-accent px-4 py-3.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-text-on-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                <h3 class="font-display font-semibold text-text-on-brand"><?= lang('Reports.detailed_reports') ?></h3>
            </div>
            <div class="divide-y divide-brand-primary-border">
                <?php foreach ($detailed_reports as $report_name => $prefix) {
                    if (in_array($report_name, $permission_ids, true)) {
                        $link = get_report_link($report_name, $prefix);
                ?>
                    <a href="<?= $link['path'] ?>"
                       class="flex items-center gap-2 px-4 py-3 text-sm text-text-default transition-colors hover:bg-brand-primary-soft hover:text-brand-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0 text-text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        <?= esc($link['label']) ?>
                    </a>
                <?php
                    }
                }
                ?>
            </div>
        </div>

        <?php if (in_array('reports_inventory', $permission_ids, true)) { ?>
            <div class="ui-card overflow-hidden">
                <div class="flex items-center gap-2.5 bg-gradient-to-r from-brand-primary to-brand-accent px-4 py-3.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-text-on-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                    <h3 class="font-display font-semibold text-text-on-brand"><?= lang('Reports.inventory_reports') ?></h3>
                </div>
                <div class="divide-y divide-brand-primary-border">
                    <?php
                    $inventory_low_report = get_report_link('reports_inventory_low');
                    $inventory_summary_report = get_report_link('reports_inventory_summary');
                    ?>
                    <a href="<?= $inventory_low_report['path'] ?>"
                       class="flex items-center gap-2 px-4 py-3 text-sm text-text-default transition-colors hover:bg-brand-primary-soft hover:text-brand-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0 text-text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        <?= esc($inventory_low_report['label']) ?>
                    </a>
                    <a href="<?= $inventory_summary_report['path'] ?>"
                       class="flex items-center gap-2 px-4 py-3 text-sm text-text-default transition-colors hover:bg-brand-primary-soft hover:text-brand-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0 text-text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        <?= esc($inventory_summary_report['label']) ?>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>

</div>

<?= view('partial/footer') ?>
