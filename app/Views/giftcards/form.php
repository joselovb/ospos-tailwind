<?php
/**
 * @var int $giftcard_id
 * @var string $selected_person_name
 * @var int $selected_person_id
 * @var string $giftcard_number
 * @var float $giftcard_value
 * @var string $controller_name
 * @var array $config
 */
?>

<div id="required_fields_message" class="mb-3 text-sm text-text-muted"><?= lang('Common.fields_required_message') ?></div>
<ul id="error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<?= form_open("giftcards/save/$giftcard_id", ['id' => 'giftcard_form']) ?>

<fieldset id="giftcard_basic_info" class="space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="person_name" class="ui-label sm:w-40 sm:shrink-0 sm:pt-2.5"><?= lang('Giftcards.person_id') ?></label>
        <div class="relative flex-1">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </span>
            <?= form_input([
                'name'  => 'person_name',
                'id'    => 'person_name',
                'class' => 'ui-input pl-10',
                'value' => $selected_person_name
            ]) ?>
            <?= form_hidden('person_id', (string)$selected_person_id) ?>
        </div>
    </div>

    <?php $number_class = $config['giftcard_number'] == 'series' ? 'required ui-label sm:w-40 sm:shrink-0 sm:pt-2.5' : 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5'; ?>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="giftcard_number" class="<?= $number_class ?>"><?= lang('Giftcards.giftcard_number') ?></label>
        <div class="w-48">
            <?= form_input([
                'name'  => 'giftcard_number',
                'id'    => 'giftcard_number',
                'class' => 'ui-input',
                'value' => $giftcard_number
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="giftcard_amount" class="required ui-label sm:w-40 sm:shrink-0 sm:pt-2.5"><?= lang('Giftcards.card_value') ?></label>
        <div class="flex items-center gap-1">
            <?php if (!is_right_side_currency_symbol()): ?>
                <span class="font-semibold text-text-muted text-sm"><?= esc($config['currency_symbol']) ?></span>
            <?php endif; ?>
            <div class="w-36">
                <?= form_input([
                    'name'  => 'giftcard_amount',
                    'id'    => 'giftcard_amount',
                    'class' => 'ui-input',
                    'value' => to_currency_no_money($giftcard_value)
                ]) ?>
            </div>
            <?php if (is_right_side_currency_symbol()): ?>
                <span class="font-semibold text-text-muted text-sm"><?= esc($config['currency_symbol']) ?></span>
            <?php endif; ?>
        </div>
    </div>

</fieldset>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("input[name='person_name']").change(function() {
            !$(this).val() && $(this).val('');
        });

        var fill_value = function(event, ui) {
            event.preventDefault();
            $(this).val((ui.item ? ui.item.label : ""));
            $("input[name='person_id']").val(ui.item.value);
            $("input[name='person_name']").val(ui.item.label);
        };

        $('#person_name').autocomplete({
            source: "<?= esc("customers/suggest") ?>",
            minChars: 0,
            delay: 15,
            change: fill_value,
            cacheLength: 1,
            appendTo: '.modal-content',
            select: fill_value,
            focus: fill_value
        });

        $('#giftcard_form').validate($.extend({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        dialog_support.hide();
                        table_support.handle_submit("<?= esc($controller_name) ?>", response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        table_support.handle_submit("<?= esc($controller_name) ?>", {
                            message: errorThrown
                        });
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: '#error_message_box',

            rules: {
                <?php if ($config['giftcard_number'] == 'series') { ?>
                    giftcard_number: {
                        required: true,
                        number: true,
                        remote: {
                            url: "<?= esc("$controller_name/checkNumberGiftcard") ?>",
                            type: 'POST',
                            data: {
                                'giftcard_number': function() { return $('#giftcard_number').val() },
                                'giftcard_id': '<?= esc($giftcard_id) ?>'
                            }
                        }
                    },
                <?php } ?>
                giftcard_amount: {
                    required: true,
                    remote: "<?= esc("$controller_name/checkNumeric") ?>"
                }
            },

            messages: {
                <?php if ($config['giftcard_number'] == 'series') { ?>
                    giftcard_number: {
                        required: "<?= lang('Giftcards.number_required') ?>",
                        number: "<?= lang('Giftcards.number') ?>",
                        remote: "<?= lang('Giftcards.number_required') ?>"
                    },
                <?php } ?>
                giftcard_amount: {
                    required: "<?= lang('Giftcards.value_required') ?>",
                    remote: "<?= lang('Giftcards.value') ?>"
                }
            }
        }, form_support.error));
    });
</script>
