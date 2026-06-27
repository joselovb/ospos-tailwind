<?php
/**
 * @var string $controller_name
 * @var string $tax_rate_table_headers
 * @var array $config
 */
?>

<script type="text/javascript">
    $(document).ready(function() {
        <?= view('partial/bootstrap_tables_locale') ?>
        table_support.init({
            resource: '<?= esc($controller_name) ?>',
            headers: <?= $tax_rate_table_headers ?>,
            pageSize: <?= $config['lines_per_page'] ?>,
            uniqueId: 'tax_rate_id'
        });
    });
</script>

<div id="title_bar" class="mb-4 flex items-center justify-end gap-2">
    <button class="ui-btn-primary modal-dlg"
            data-btn-submit="<?= lang('Common.submit') ?>"
            data-href="<?= esc("$controller_name/view") ?>"
            title="<?= lang(ucfirst($controller_name) . '.new') ?>">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <?= lang(ucfirst($controller_name) . '.new') ?>
    </button>
</div>

<div id="toolbar" class="mb-3">
    <button id="delete" class="ui-btn-secondary !text-state-danger hover:!bg-state-danger-soft">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
        <?= lang('Common.delete') ?>
    </button>
</div>

<div id="table_holder">
    <table id="table"></table>
</div>
