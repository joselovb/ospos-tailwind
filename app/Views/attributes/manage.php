<?php
/**
 * @var string $controller_name
 * @var string $table_headers
 * @var array $config
 */
?>

<?= view('partial/header') ?>

<script type="text/javascript">
    $(document).ready(function() {
        <?= view('partial/bootstrap_tables_locale') ?>

        table_support.init({
            resource: '<?= esc($controller_name) ?>',
            headers: <?= $table_headers ?>,
            pageSize: <?= $config['lines_per_page'] ?>,
            uniqueId: 'definition_id'
        });
    });
</script>

<div class="mb-4 flex flex-wrap items-center justify-between gap-3">
    <h1 class="font-display text-2xl font-semibold text-brand-primary-active"><?= lang('Module.' . $controller_name) ?></h1>
    <button class="ui-btn-primary modal-dlg"
            data-btn-submit="<?= lang('Common.submit') ?>"
            data-href="<?= esc("$controller_name/view") ?>"
            title="<?= lang(ucfirst($controller_name) . '.new') ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        <?= lang(ucfirst($controller_name) . '.new') ?>
    </button>
</div>

<div class="ui-card p-4">
    <div id="toolbar">
        <div class="flex flex-wrap items-center gap-2">
            <button id="delete" class="ui-btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                <?= lang('Common.delete') ?>
            </button>
        </div>
    </div>

    <div id="table_holder" class="mt-3">
        <table id="table"></table>
    </div>
</div>

<?= view('partial/footer') ?>
