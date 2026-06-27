<?php
/**
 * @var object $category_info
 * @var string $controller_name
 */
?>

<div id="required_fields_message" class="mb-3 text-sm text-text-muted"><?= lang('Common.fields_required_message') ?></div>
<ul id="error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<?= form_open("expenses_categories/save/$category_info->expense_category_id", ['id' => 'expense_category_edit_form']) ?>

<fieldset id="expenses_categories" class="space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="category_name" class="required ui-label sm:w-40 sm:shrink-0 sm:pt-2.5"><?= lang('Expenses_categories.name') ?></label>
        <div class="flex-1">
            <?= form_input([
                'name'  => 'category_name',
                'id'    => 'category_name',
                'class' => 'ui-input',
                'value' => $category_info->category_name
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="category_description" class="ui-label sm:w-40 sm:shrink-0 sm:pt-2.5"><?= lang('Expenses_categories.description') ?></label>
        <div class="flex-1">
            <?= form_textarea([
                'name'  => 'category_description',
                'id'    => 'category_description',
                'class' => 'ui-input min-h-[80px] resize-y',
                'value' => $category_info->category_description
            ]) ?>
        </div>
    </div>

</fieldset>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#expense_category_edit_form').validate($.extend({
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
                category_name: 'required'
            },

            messages: {
                category_name: "<?= lang('Expenses_categories.category_name_required') ?>"
            }
        }, form_support.error));
    });
</script>
