<?php
/**
 * @var array $customer_rewards
 * @var array $config
 */
?>

<?= form_open('config/saveRewards/', ['id' => 'reward_config_form']) ?>

<ul id="reward_error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<div class="max-w-2xl space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0"><?= lang('Config.customer_reward_enable') ?></label>
        <div class="flex items-center pt-2">
            <?= form_checkbox(['name' => 'customer_reward_enable', 'value' => 'customer_reward_enable', 'id' => 'customer_reward_enable', 'checked' => $config['customer_reward_enable'] == 1, 'class' => 'h-4 w-4 cursor-pointer rounded']) ?>
        </div>
    </div>

    <div id="customer_rewards" class="space-y-2">
        <?= view('partial/customer_rewards', ['customer_rewards' => $customer_rewards]) ?>
    </div>

    <div class="flex justify-end border-t border-brand-primary-border pt-4">
        <button type="submit" name="submit_reward" id="submit_reward" class="ui-btn-primary"><?= lang('Common.submit') ?></button>
    </div>

</div>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {

        var enable_disable_customer_reward_enable = (function() {
            var customer_reward_enable = $("#customer_reward_enable").is(":checked");
            $("input[name*='customer_reward']:not(input[name=customer_reward_enable])").prop("disabled", !customer_reward_enable);
            $("input[name*='reward_points_']:not(input[name=customer_reward_enable])").prop("disabled", !customer_reward_enable);
            if (customer_reward_enable) {
                $(".add_customer_reward, .remove_customer_reward").show();
            } else {
                $(".add_customer_reward, .remove_customer_reward").hide();
            }
            return arguments.callee;
        })();

        $("#customer_reward_enable").change(enable_disable_customer_reward_enable);

        var table_count = <?= sizeof($customer_rewards) ?>;

        var hide_show_remove = function() {
            if ($("input[name*='customer_rewards']:enabled").length > 1) {
                $(".remove_customer_rewards").show();
            } else {
                $(".remove_customer_rewards").hide();
            }
        };

        var add_customer_reward = function() {
            var id = $(this).parent().find('input').attr('id');
            id = id.replace(/.*?_(\d+)$/g, "$1");
            var previous_id = 'customer_reward_' + id;
            var previous_id_next = 'reward_points_' + id;
            var block = $(this).parent().clone(true);
            var new_block = block.insertAfter($(this).parent());
            var new_block_id = 'customer_reward_' + ++id;
            var new_block_id_next = 'reward_points_' + id;
            $(new_block).find('label').html("<?= lang('Config.customer_reward') ?> " + ++table_count).attr('for', new_block_id).attr('class', 'ui-label text-sm w-36 shrink-0');
            $(new_block).find("input[id='" + previous_id + "']").attr('id', new_block_id).removeAttr('disabled').attr('name', new_block_id).attr('class', 'customer_reward valid_chars ui-input').val('');
            $(new_block).find("input[id='" + previous_id_next + "']").attr('id', new_block_id_next).removeAttr('disabled').attr('name', new_block_id_next).attr('class', 'customer_reward valid_chars ui-input').val('');
            hide_show_remove();
        };

        var remove_customer_reward = function() {
            $(this).parent().remove();
            hide_show_remove();
        };

        var init_add_remove_tables = function() {
            $('.add_customer_reward').click(add_customer_reward);
            $('.remove_customer_reward').click(remove_customer_reward);
            hide_show_remove();
            enable_disable_customer_reward_enable();
        };
        init_add_remove_tables();

        var duplicate_found = false;
        $.validator.addMethod('customer_reward', function(value, element) {
            var value_count = 0;
            $("input[name*='customer_reward']:not(input[name=customer_reward_enable])").each(function() {
                value_count = $(this).val() == value ? value_count + 1 : value_count;
            });
            return value_count < 2;
        }, "<?= lang('Config.customer_reward_duplicate') ?>");

        $.validator.addMethod('valid_chars', function(value, element) {
            return value.indexOf('_') === -1;
        }, "<?= lang('Config.customer_reward_invalid_chars') ?>");

        $('#reward_config_form').validate($.extend(form_support.handler, {
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    beforeSerialize: function(arr, $form, options) {
                        $("input[name*='customer_reward']:not(input[name=customer_reward_enable])").prop("disabled", false);
                        return true;
                    },
                    success: function(response) {
                        $.notify({
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        });
                        $("#customer_rewards").load('<?= "config/customerRewards" ?>', init_add_remove_tables);
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: "#reward_error_message_box",

            rules: {
                <?php
                $i = 0;
                foreach ($customer_rewards as $customer_reward => $table) {
                ?>
                    <?= 'customer_reward_' . ++$i ?>: {
                        required: true,
                        customer_reward: true,
                        valid_chars: true
                    },
                <?php } ?>
            },

            messages: {
                <?php
                $i = 0;
                foreach ($customer_rewards as $customer_reward => $table) {
                ?>
                    <?= 'customer_reward_' . ++$i ?>: "<?= lang('Config.customer_reward_required') ?>",
                <?php } ?>
            }
        }));
    });
</script>
