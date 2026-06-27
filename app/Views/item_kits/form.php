<?php
/**
 * @var object $item_kit_info
 * @var string $selected_kit_item
 * @var int $selected_kit_item_id
 * @var array $item_kit_items
 * @var string $controller_name
 */
?>

<div id="required_fields_message" class="mb-3 text-sm text-text-muted"><?= lang('Common.fields_required_message') ?></div>
<ul id="error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<?= form_open("item_kits/save/$item_kit_info->item_kit_id", ['id' => 'item_kit_form']) ?>

<fieldset id="item_kit_basic_info" class="space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="item_kit_number" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Item_kits.item_kit_number') ?></label>
        <div class="relative flex-1">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 5v14M7 5v14M11 5v14M15 5v8M19 5v8M15 17h4M17 15v4"/></svg>
            </span>
            <?= form_input([
                'name'  => 'item_kit_number',
                'id'    => 'item_kit_number',
                'class' => 'ui-input pl-10',
                'value' => $item_kit_info->item_kit_number
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="name" class="required ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Item_kits.name') ?></label>
        <div class="flex-1">
            <?= form_input([
                'name'  => 'name',
                'id'    => 'name',
                'class' => 'ui-input',
                'value' => $item_kit_info->name
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="item_name" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Item_kits.find_kit_item') ?></label>
        <div class="flex-1">
            <?= form_input([
                'name'  => 'item_name',
                'id'    => 'item_name',
                'class' => 'ui-input',
                'value' => $selected_kit_item
            ]) ?>
            <?= form_hidden('kit_item_id', (string)$selected_kit_item_id) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Item_kits.discount_type') ?></label>
        <div class="flex flex-wrap gap-4 pt-1">
            <label class="flex items-center gap-2 cursor-pointer">
                <?= form_radio([
                    'name'    => 'kit_discount_type',
                    'value'   => 0,
                    'checked' => $item_kit_info->kit_discount_type == PERCENT,
                    'class'   => 'h-4 w-4 cursor-pointer accent-brand-primary'
                ]) ?>
                <span class="text-sm text-text-default"><?= lang('Item_kits.discount_percent') ?></span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <?= form_radio([
                    'name'    => 'kit_discount_type',
                    'value'   => 1,
                    'checked' => $item_kit_info->kit_discount_type == FIXED,
                    'class'   => 'h-4 w-4 cursor-pointer accent-brand-primary'
                ]) ?>
                <span class="text-sm text-text-default"><?= lang('Item_kits.discount_fixed') ?></span>
            </label>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="kit_discount" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Item_kits.discount') ?></label>
        <div class="w-32">
            <?= form_input([
                'name'      => 'kit_discount',
                'id'        => 'kit_discount',
                'class'     => 'ui-input',
                'maxlength' => '5',
                'value'     => $item_kit_info->kit_discount_type === FIXED ? to_currency_no_money($item_kit_info->kit_discount) : to_decimals($item_kit_info->kit_discount)
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5<?= !empty($basic_version) ? ' required' : '' ?>"><?= lang('Item_kits.price_option') ?></label>
        <div class="flex flex-wrap gap-4 pt-1">
            <label class="flex items-center gap-2 cursor-pointer">
                <?= form_radio([
                    'name'    => 'price_option',
                    'value'   => 0,
                    'checked' => $item_kit_info->price_option == PRICE_ALL,
                    'class'   => 'h-4 w-4 cursor-pointer accent-brand-primary'
                ]) ?>
                <span class="text-sm text-text-default"><?= lang('Item_kits.kit_and_components') ?></span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <?= form_radio([
                    'name'    => 'price_option',
                    'value'   => 1,
                    'checked' => $item_kit_info->price_option == PRICE_KIT,
                    'class'   => 'h-4 w-4 cursor-pointer accent-brand-primary'
                ]) ?>
                <span class="text-sm text-text-default"><?= lang('Item_kits.kit_only') ?></span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <?= form_radio([
                    'name'    => 'price_option',
                    'value'   => 2,
                    'checked' => $item_kit_info->price_option == PRICE_KIT_ITEMS,
                    'class'   => 'h-4 w-4 cursor-pointer accent-brand-primary'
                ]) ?>
                <span class="text-sm text-text-default"><?= lang('Item_kits.kit_and_stock') ?></span>
            </label>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5<?= !empty($basic_version) ? ' required' : '' ?>"><?= lang('Item_kits.print_option') ?></label>
        <div class="flex flex-wrap gap-4 pt-1">
            <label class="flex items-center gap-2 cursor-pointer">
                <?= form_radio([
                    'name'    => 'print_option',
                    'value'   => 0,
                    'checked' => $item_kit_info->print_option == PRINT_ALL,
                    'class'   => 'h-4 w-4 cursor-pointer accent-brand-primary'
                ]) ?>
                <span class="text-sm text-text-default"><?= lang('Item_kits.all') ?></span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <?= form_radio([
                    'name'    => 'print_option',
                    'value'   => 1,
                    'checked' => $item_kit_info->print_option == PRINT_PRICED,
                    'class'   => 'h-4 w-4 cursor-pointer accent-brand-primary'
                ]) ?>
                <span class="text-sm text-text-default"><?= lang('Item_kits.priced_only') ?></span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <?= form_radio([
                    'name'    => 'print_option',
                    'value'   => 2,
                    'checked' => $item_kit_info->print_option == PRINT_KIT,
                    'class'   => 'h-4 w-4 cursor-pointer accent-brand-primary'
                ]) ?>
                <span class="text-sm text-text-default"><?= lang('Item_kits.kit_only') ?></span>
            </label>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="description" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Item_kits.description') ?></label>
        <div class="flex-1">
            <?= form_textarea([
                'name'  => 'description',
                'id'    => 'description',
                'class' => 'ui-input min-h-[80px] resize-y',
                'value' => $item_kit_info->description
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="item" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Item_kits.add_item') ?></label>
        <div class="flex-1">
            <?= form_input([
                'name'  => 'item',
                'id'    => 'item',
                'class' => 'ui-input'
            ]) ?>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl border border-brand-primary-border">
        <table id="item_kit_items" class="w-full text-sm">
            <thead class="bg-surface-muted">
                <tr>
                    <th class="px-3 py-2 text-left font-medium text-text-muted w-12"><?= lang('Common.delete') ?></th>
                    <th class="px-3 py-2 text-left font-medium text-text-muted w-24"><?= lang('Item_kits.sequence') ?></th>
                    <th class="px-3 py-2 text-left font-medium text-text-muted"><?= lang('Item_kits.item') ?></th>
                    <th class="px-3 py-2 text-left font-medium text-text-muted w-28"><?= lang('Item_kits.quantity') ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-primary-border">
                <?php foreach ($item_kit_items as $item_kit_item) { ?>
                    <tr class="bg-surface hover:bg-surface-muted transition-colors">
                        <td class="px-3 py-2">
                            <a href="#" onclick="return delete_item_kit_row(this);" class="text-state-danger hover:text-state-danger inline-flex">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                            </a>
                        </td>
                        <td class="px-3 py-2">
                            <input class="ui-input !py-1 !text-sm w-20"
                                   id="item_seq_<?= $item_kit_item['item_id'] ?>"
                                   name="item_kit_seq[<?= $item_kit_item['item_id'] ?>]"
                                   value="<?= parse_decimals($item_kit_item['kit_sequence'], 0) ?>">
                        </td>
                        <td class="px-3 py-2 text-text-default"><?= esc($item_kit_item['name']) ?></td>
                        <td class="px-3 py-2">
                            <input class="ui-input !py-1 !text-sm w-20"
                                   id="item_qty_<?= $item_kit_item['item_id'] ?>"
                                   name="item_kit_qty[<?= $item_kit_item['item_id'] ?>]"
                                   value="<?= to_quantity_decimals($item_kit_item['quantity']) ?>">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</fieldset>

<?= form_close() ?>

<script type="text/javascript">
    var trash_svg = '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>';

    function delete_item_kit_row(link) {
        $(link).parent().parent().remove();
        return false;
    }

    $(document).ready(function() {
        $('#item').autocomplete({
            source: '<?= "items/suggest" ?>',
            minChars: 0,
            autoFocus: false,
            delay: 10,
            appendTo: '.modal-content',
            select: function(e, ui) {
                if ($('#item_kit_item_' + ui.item.value).length == 1) {
                    $('#item_kit_item_' + ui.item.value).val(parseFloat($('#item_kit_item_' + ui.item.value).val()) + 1);
                } else {
                    $('#item_kit_items tbody').append('<tr class="bg-surface hover:bg-surface-muted transition-colors">' +
                        '<td class="px-3 py-2"><a href="#" onclick="return delete_item_kit_row(this);" class="text-state-danger hover:text-state-danger inline-flex">' + trash_svg + '</a></td>' +
                        '<td class="px-3 py-2"><input class="ui-input !py-1 !text-sm w-20" id="item_seq_' + ui.item.value + '" name="item_kit_seq[' + ui.item.value + ']" value="0"></td>' +
                        '<td class="px-3 py-2 text-text-default">' + DOMPurify.sanitize(ui.item.label) + '</td>' +
                        '<td class="px-3 py-2"><input class="ui-input !py-1 !text-sm w-20" id="item_qty_' + ui.item.value + '" name="item_kit_qty[' + ui.item.value + ']" value="1"></td>' +
                        '</tr>');
                }
                $('#item').val('');
                return false;
            }
        });

        $("input[name='item_name']").change(function() {
            if (!$("input[name='item_name']").val()) {
                $("input[name='kit_item_id']").val('');
            }
        });

        var fill_value = function(event, ui) {
            event.preventDefault();
            $("input[name='kit_item_id']").val(ui.item.value);
            $("input[name='item_name']").val(DOMPurify.sanitize(ui.item.label));
        };

        $('#item_name').autocomplete({
            source: "<?= 'items/suggestKits' ?>",
            minChars: 0,
            delay: 15,
            cacheLength: 1,
            appendTo: '.modal-content',
            select: fill_value,
            focus: fill_value
        });

        $('#item_kit_form').validate($.extend({
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
                name: 'required',
                category: 'required',
                item_kit_number: {
                    required: false,
                    remote: {
                        url: '<?= esc("$controller_name/checkItemNumber") ?>',
                        type: 'POST',
                        data: {
                            'item_kit_id': "<?= $item_kit_info->item_kit_id ?>",
                            'item_kit_number': function() {
                                return $('#item_kit_number').val();
                            }
                        }
                    }
                }
            },

            messages: {
                name: "<?= lang('Items.name_required') ?>",
                category: "<?= lang('Items.category_required') ?>",
                item_kit_number: "<?= lang('Item_kits.item_number_duplicate') ?>"
            }
        }, form_support.error));
    });
</script>
