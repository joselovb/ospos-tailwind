<?php
/**
 * @var string $controller_name
 * @var string $table_headers
 * @var array $filters
 * @var array $stock_locations
 * @var int $stock_location
 * @var array $config
 * @var string|null $start_date
 * @var string|null $end_date
 * @var array $selected_filters
 */

use App\Models\Employee;
?>

<?= view('partial/header') ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#generate_barcodes').click(function() {
            window.open(
                'index.php/items/generateBarcodes/' + table_support.selected_ids().join(':'),
                '_blank'
            );
        });

        // Load the preset daterange picker
        <?= view('partial/daterangepicker') ?>
        // Set the beginning of time as starting date
        $('#daterangepicker').data('daterangepicker').setStartDate("<?= date($config['dateformat'], mktime(0, 0, 0, 01, 01, 2010)) ?>");
        // Update the hidden inputs with the selected dates before submitting the search data
        var start_date = "<?= date('Y-m-d', mktime(0, 0, 0, 01, 01, 2010)) ?>";

        // Override dates from server if provided
        <?php if (isset($start_date) && $start_date): ?>
        start_date = "<?= esc($start_date) ?>";
        <?php endif; ?>
        <?php if (isset($end_date) && $end_date): ?>
        end_date = "<?= esc($end_date) ?>";
        <?php endif; ?>

        <?php
        echo view('partial/bootstrap_tables_locale');
        $employee = model(Employee::class);
        ?>

        table_support.init({
            employee_id: <?= $employee->get_logged_in_employee_info()->person_id ?>,
            resource: '<?= esc($controller_name) ?>',
            headers: <?= $table_headers ?>,
            pageSize: <?= $config['lines_per_page'] ?>,
            uniqueId: 'items.item_id',
            queryParams: function() {
                return $.extend(arguments[0], {
                    "start_date": start_date,
                    "end_date": end_date,
                    "stock_location": $("#stock_location").val(),
                    "filters": $("#filters").val()
                });
            },
            onLoadSuccess: function(response) {
                $('a.rollover').imgPreview({
                    imgCSS: {
                        width: 200
                    },
                    distanceFromCursor: {
                        top: 10,
                        left: -210
                    }
                })
            }
        });
    });
</script>

<?= view('partial/table_filter_persistence', ['additional_params' => ['stock_location']]) ?>

<div class="my-6 flex flex-col gap-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold text-brand-primary-active"><?= lang('Module.' . $controller_name) ?></h1>
        </div>

        <div id="title_bar" class="print_hide flex flex-wrap items-center gap-2">
            <button class="ui-btn-secondary modal-dlg" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= "$controller_name/csvImport" ?>" title="<?= lang('Items.import_items_csv') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                <?= lang('Common.import_csv') ?>
            </button>

            <button class="ui-btn-primary modal-dlg" data-btn-new="<?= lang('Common.new') ?>" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= "$controller_name/view" ?>" title="<?= lang(ucfirst($controller_name) . '.new') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <?= lang(ucfirst($controller_name) . '.new') ?>
            </button>
        </div>
    </div>

    <div id="toolbar" class="ui-card flex flex-wrap items-center gap-2 p-3">
        <div class="flex flex-wrap items-center gap-2" role="toolbar">
            <button id="delete" class="ui-btn-secondary print_hide">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                <?= lang('Common.delete') ?>
            </button>
            <button id="bulk_edit" class="ui-btn-secondary modal-dlg print_hide" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= "items/bulkEdit" ?>" title="<?= lang('Items.edit_multiple_items') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>
                <?= lang('Items.bulk_edit') ?>
            </button>
            <button id="generate_barcodes" class="ui-btn-secondary print_hide" data-href="<?= "$controller_name/generateBarcodes" ?>" title="<?= lang('Items.generate_barcodes') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="5" x2="3" y2="19"/><line x1="7" y1="5" x2="7" y2="19"/><line x1="11" y1="5" x2="11" y2="19"/><line x1="16" y1="5" x2="16" y2="19"/><line x1="21" y1="5" x2="21" y2="19"/></svg>
                <?= lang('Items.generate_barcodes') ?>
            </button>
        </div>

        <div class="ml-auto flex flex-wrap items-center gap-2">
            <?= form_input(['name' => 'daterangepicker', 'class' => '!rounded-xl !border !border-brand-primary-border !bg-surface !px-4 !py-2 !text-sm !text-text-default focus:!outline-none focus:!ring-2 focus:!ring-brand-primary-ring', 'id' => 'daterangepicker']) ?>
            <?= form_multiselect('filters[]', $filters, $selected_filters ?? [], [
                'id'                        => 'filters',
                'class'                     => 'selectpicker show-menu-arrow',
                'data-none-selected-text'   => lang('Common.none_selected_text'),
                'data-selected-text-format' => 'count > 1',
                'data-style'                => 'btn-default btn-sm',
                'data-width'                => 'fit'
            ]) ?>
            <?php
            if (count($stock_locations) > 1) {
                echo form_dropdown(
                    'stock_location',
                    $stock_locations,
                    $stock_location,
                    [
                        'id'         => 'stock_location',
                        'class'      => 'selectpicker show-menu-arrow',
                        'data-style' => 'btn-default btn-sm',
                        'data-width' => 'fit'
                    ]
                );
            }
            ?>
        </div>
    </div>

    <div id="table_holder" class="ui-card overflow-hidden">
        <table id="table"></table>
    </div>
</div>

<?= view('partial/footer') ?>
