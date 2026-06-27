<?php
/**
 * @var string $controller_name
 * @var object $person_info
 * @var array $categories
 */
?>

<div id="required_fields_message" class="mb-3 text-sm text-text-muted"><?= lang('Common.fields_required_message') ?></div>
<ul id="error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<?= form_open("$controller_name/save/$person_info->person_id", ['id' => 'supplier_form']) ?>

<fieldset id="supplier_basic_info" class="space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="company_name_input" class="required ui-label sm:w-40 sm:shrink-0 sm:pt-2.5"><?= lang('Suppliers.company_name') ?></label>
        <div class="flex-1">
            <?= form_input([
                'name'  => 'company_name',
                'id'    => 'company_name_input',
                'class' => 'ui-input',
                'value' => html_entity_decode($person_info->company_name)
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="category" class="required ui-label sm:w-40 sm:shrink-0 sm:pt-2.5"><?= lang('Suppliers.category') ?></label>
        <div class="relative flex-1">
            <?= form_dropdown('category', $categories, $person_info->category, ['class' => 'ui-select', 'id' => 'category']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="agency_name_input" class="ui-label sm:w-40 sm:shrink-0 sm:pt-2.5"><?= lang('Suppliers.agency_name') ?></label>
        <div class="flex-1">
            <?= form_input([
                'name'  => 'agency_name',
                'id'    => 'agency_name_input',
                'class' => 'ui-input',
                'value' => $person_info->agency_name
            ]) ?>
        </div>
    </div>

    <?= view('people/form_basic_info') ?>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="account_number" class="ui-label sm:w-40 sm:shrink-0 sm:pt-2.5"><?= lang('Suppliers.account_number') ?></label>
        <div class="flex-1">
            <?= form_input([
                'name'  => 'account_number',
                'id'    => 'account_number',
                'class' => 'ui-input',
                'value' => $person_info->account_number
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="tax_id" class="ui-label sm:w-40 sm:shrink-0 sm:pt-2.5"><?= lang('Suppliers.tax_id') ?></label>
        <div class="flex-1">
            <?= form_input([
                'name'  => 'tax_id',
                'id'    => 'tax_id',
                'class' => 'ui-input',
                'value' => $person_info->tax_id
            ]) ?>
        </div>
    </div>

</fieldset>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#supplier_form').validate($.extend({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        dialog_support.hide();
                        table_support.handle_submit("<?= esc($controller_name) ?>", response);
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: '#error_message_box',

            rules: {
                company_name: 'required',
                first_name: 'required',
                last_name: 'required',
                email: 'email'
            },

            messages: {
                company_name: "<?= lang('Suppliers.company_name_required') ?>",
                first_name: "<?= lang('Common.first_name_required') ?>",
                last_name: "<?= lang('Common.last_name_required') ?>",
                email: "<?= lang('Common.email_invalid_format') ?>"
            }
        }, form_support.error));
    });
</script>
