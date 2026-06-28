<?php
/**
 * @var string $controller_name
 * @var string $table_headers
 * @var array $filters
 * @var array $selected_filters
 * @var array $config
 * @var string|null $start_date
 * @var string|null $end_date
 */
?>

<?= view('partial/header') ?>

<script type="text/javascript">
    $(document).ready(function() {
        <?= view('partial/daterangepicker') ?>

        <?= view('partial/bootstrap_tables_locale') ?>

        <?php if (isset($start_date) && $start_date): ?>
        start_date = "<?= esc($start_date) ?>";
        <?php endif; ?>
        <?php if (isset($end_date) && $end_date): ?>
        end_date = "<?= esc($end_date) ?>";
        <?php endif; ?>

        table_support.init({
            resource: '<?= esc($controller_name) ?>',
            headers: <?= $table_headers ?>,
            pageSize: <?= $config['lines_per_page'] ?>,
            uniqueId: 'cashup_id',
            queryParams: function() {
                return $.extend(arguments[0], {
                    "end_date": end_date,
                    "filters": $("#filters").val(),
                    "start_date": start_date
                });
            }
        });
    });
</script>

<?= view('partial/table_filter_persistence') ?>
<?= view('partial/print_receipt', ['print_after_sale' => false, 'selected_printer' => 'takings_printer']) ?>

<div class="mb-4 flex flex-wrap items-center justify-between gap-3">
    <h1 class="font-display text-2xl font-semibold text-brand-primary-active"><?= lang('Module.' . $controller_name) ?></h1>
    <div class="flex flex-wrap items-center gap-2">
        <button onclick="printdoc()" class="ui-btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            <?= lang('Common.print') ?>
        </button>
        <button class="ui-btn-primary modal-dlg"
                data-btn-submit="<?= lang('Common.submit') ?>"
                data-href="<?= esc("$controller_name/view") ?>"
                title="<?= lang(ucfirst($controller_name) . '.new') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            <?= lang(ucfirst($controller_name) . '.new') ?>
        </button>
    </div>
</div>

<div class="ui-card p-4">
    <div id="toolbar">
        <div class="flex flex-wrap items-center gap-2">
            <button id="delete" class="ui-btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                <?= lang('Common.delete') ?>
            </button>
            <?= form_input(['name' => 'daterangepicker', 'class' => 'ui-input !py-1.5 !text-sm w-52', 'id' => 'daterangepicker']) ?>
            <?= form_multiselect('filters[]', $filters, $selected_filters ?? [], [
                'id'                        => 'filters',
                'data-none-selected-text'   => lang('Common.none_selected_text'),
                'class'                     => 'selectpicker show-menu-arrow',
                'data-selected-text-format' => 'count > 1',
                'data-style'                => 'btn-default btn-sm',
                'data-width'                => 'fit'
            ]) ?>
        </div>
    </div>

    <div id="table_holder" class="mt-3">
        <table id="table"></table>
    </div>
</div>

<?= view('partial/footer') ?>
