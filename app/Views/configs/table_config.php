<?php
/**
 * @var array $dinner_tables
 * @var array $config
 */
?>

<?= form_open('config/saveTables/', ['id' => 'table_config_form']) ?>

<ul id="table_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<div class="max-w-2xl space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.dinner_table_enable') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'dinner_table_enable', 'value' => 'dinner_table_enable', 'id' => 'dinner_table_enable', 'checked' => $config['dinner_table_enable'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div id="dinner_tables" class="space-y-2">
        <?= view('partial/dinner_tables', ['dinner_tables' => $dinner_tables]) ?>
    </div>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_table" id="submit_table" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {

        var enable_disable_dinner_table_enable = (function() {
            var dinner_table_enable = $("#dinner_table_enable").is(":checked");
            $("input[name*='dinner_table']:not(input[name=dinner_table_enable])").prop("disabled", !dinner_table_enable);
            if (dinner_table_enable) {
                $(".add_dinner_table, .remove_dinner_table").show();
            } else {
                $(".add_dinner_table, .remove_dinner_table").hide();
            }
            return arguments.callee;
        })();

        $("#dinner_table_enable").change(enable_disable_dinner_table_enable);

        var table_count = <?= sizeof($dinner_tables) ?>;

        var hide_show_remove = function() {
            if ($("input[name*='dinner_tables']:enabled").length > 1) {
                $(".remove_dinner_tables").show();
            } else {
                $(".remove_dinner_tables").hide();
            }
        };

        var add_dinner_table = function() {
            var id = $(this).parent().find('input').attr('id');
            id = id.replace(/.*?_(\d+)$/g, "$1");
            var block = $(this).parent().clone(true);
            var new_block = block.insertAfter($(this).parent());
            var new_block_id = 'dinner_table_' + ++id;
            $(new_block).find('label').html("<?= lang('Config.dinner_table') ?> " + ++table_count).attr('for', new_block_id).attr('class', 'ui-label text-sm w-36 shrink-0');
            $(new_block).find('input').attr('id', new_block_id).removeAttr('disabled').attr('name', new_block_id).attr('class', 'dinner_table valid_chars ui-input').val('');
            hide_show_remove();
        };

        var remove_dinner_table = function() {
            $(this).parent().remove();
            hide_show_remove();
        };

        var init_add_remove_tables = function() {
            $('.add_dinner_table').click(add_dinner_table);
            $('.remove_dinner_table').click(remove_dinner_table);
            hide_show_remove();
            enable_disable_dinner_table_enable();
        };
        init_add_remove_tables();

        var duplicate_found = false;
        $.validator.addMethod('dinner_table', function(value, element) {
            var value_count = 0;
            $("input[name*='dinner_table']:not(input[name=dinner_table_enable])").each(function() {
                value_count = $(this).val() == value ? value_count + 1 : value_count;
            });
            return value_count < 2;
        }, "<?= lang('Config.dinner_table_duplicate') ?>");

        $.validator.addMethod('valid_chars', function(value, element) {
            return value.indexOf('_') === -1;
        }, "<?= lang('Config.dinner_table_invalid_chars') ?>");

        $('#table_config_form').validate($.extend(form_support.handler, {
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    beforeSerialize: function(arr, $form, options) {
                        $("input[name*='dinner_table']:not(input[name=dinner_table_enable])").prop("disabled", false);
                        return true;
                    },
                    success: function(response) {
                        $.notify({
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        });
                        $("#dinner_tables").load('<?= "config/dinnerTables" ?>', init_add_remove_tables);
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: "#table_error_message_box",

            rules: {
                <?php
                $i = 0;
                foreach ($dinner_tables as $dinner_table => $table) {
                ?>
                    <?= 'dinner_table_' . ++$i ?>: {
                        required: true,
                        dinner_table: true,
                        valid_chars: true
                    },
                <?php } ?>
            },

            messages: {
                <?php
                $i = 0;
                foreach ($dinner_tables as $dinner_table => $table) {
                ?>
                    <?= 'dinner_table_' . ++$i ?>: "<?= lang('Config.dinner_table_required') ?>",
                <?php } ?>
            }
        }));
    });
</script>
