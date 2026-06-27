<ul id="error_message_box" class="error_message_box ui-alert-danger mb-3 block list-none empty:hidden"></ul>

<?= form_open_multipart('items/importCsvFile/', ['id' => 'csv_form', 'class' => 'form-horizontal']) ?>
    <fieldset id="item_basic_info" class="space-y-4">

        <div>
            <a href="<?= esc('items/generateCsvFile', 'attr') ?>" class="inline-flex items-center gap-1.5 text-sm text-brand-primary hover:text-brand-primary-hover transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                <?= lang('Common.download_import_template') ?>
            </a>
        </div>

        <div class="fileinput fileinput-new" data-provides="fileinput">
            <label class="block">
                <span class="ui-label mb-1 block"><?= lang('Common.import_select_file') ?></span>
                <div class="flex items-center gap-3">
                    <span class="fileinput-filename truncate text-sm text-text-muted fileinput-new hidden"><?= lang('Common.import_select_file') ?></span>
                    <span class="fileinput-filename truncate text-sm text-text-default fileinput-exists"></span>
                    <span class="btn btn-default btn-file ui-btn-secondary cursor-pointer">
                        <span class="fileinput-new"><?= lang('Common.import_select_file') ?></span>
                        <span class="fileinput-exists"><?= lang('Common.import_change_file') ?></span>
                        <input type="file" id="file_path" name="file_path" accept=".csv" class="sr-only">
                    </span>
                    <a href="#" class="fileinput-exists ui-btn-secondary text-sm" data-dismiss="fileinput"><?= lang('Common.import_remove_file') ?></a>
                </div>
            </label>
        </div>

    </fieldset>
<?= form_close() ?>

<script type="text/javascript">
    // Validation and submit handling
    $(document).ready(function() {
        $('#csv_form').validate($.extend({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        dialog_support.hide();
                        table_support.handle_submit('<?= esc('items') ?>', response);
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: '#error_message_box',

            rules: {
                file_path: 'required'
            },

            messages: {
                file_path: "<?= lang('Common.import_full_path') ?>"
            }
        }, form_support.error));
    });
</script>
