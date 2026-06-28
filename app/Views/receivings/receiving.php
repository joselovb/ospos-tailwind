<?php
/**
 * @var string $controller_name
 * @var array $modes
 * @var string $mode
 * @var bool $show_stock_locations
 * @var array $stock_locations
 * @var int $stock_source
 * @var string $stock_destination
 * @var array $cart
 * @var bool $items_module_allowed
 * @var float $total
 * @var string $comment
 * @var bool $print_after_sale
 * @var string $reference
 * @var array $payment_options
 * @var array $config
 */
?>

<?= view('partial/header') ?>

<?php if (isset($error)): ?>
    <div class="mb-4 rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger"><?= esc($error) ?></div>
<?php endif; ?>
<?php if (!empty($warning)): ?>
    <div class="mb-4 rounded-xl bg-[var(--color-state-warning-soft,#fef9c3)] px-4 py-3 text-sm text-[var(--color-state-warning,#854d0e)]"><?= esc($warning) ?></div>
<?php endif; ?>
<?php if (isset($success)): ?>
    <div class="mb-4 rounded-xl bg-state-success-soft px-4 py-3 text-sm text-state-success"><?= esc($success) ?></div>
<?php endif; ?>

<div id="register_wrapper" class="space-y-4">

    <!-- Mode / Stock Location form -->
    <?= form_open("$controller_name/changeMode", ['id' => 'mode_form']) ?>
    <div class="flex flex-wrap items-center gap-3 rounded-xl border border-brand-primary-border bg-surface px-4 py-3">
        <span class="text-sm font-medium text-text-default shrink-0"><?= lang(ucfirst($controller_name) . '.mode') ?></span>
        <div class="relative inline-flex items-center">
            <?= form_dropdown('mode', $modes, $mode, ['onchange' => "$('#mode_form').submit();", 'class' => 'ui-select !w-auto !py-1.5 !pl-3 !pr-8 !text-xs']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg></div>
        </div>

        <?php if ($show_stock_locations): ?>
            <span class="text-sm font-medium text-text-default shrink-0"><?= lang(ucfirst($controller_name) . '.stock_source') ?></span>
            <div class="relative inline-flex items-center">
                <?= form_dropdown('stock_source', $stock_locations, $stock_source, ['onchange' => "$('#mode_form').submit();", 'class' => 'ui-select !w-auto !py-1.5 !pl-3 !pr-8 !text-xs']) ?>
                <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg></div>
            </div>

            <?php if ($mode == 'requisition'): ?>
                <span class="text-sm font-medium text-text-default shrink-0"><?= lang(ucfirst($controller_name) . '.stock_destination') ?></span>
                <div class="relative inline-flex items-center">
                    <?= form_dropdown('stock_destination', $stock_locations, $stock_destination, ['onchange' => "$('#mode_form').submit();", 'class' => 'ui-select !w-auto !py-1.5 !pl-3 !pr-8 !text-xs']) ?>
                    <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg></div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?= form_close() ?>

    <!-- Item search -->
    <?= form_open("$controller_name/add", ['id' => 'add_item_form']) ?>
    <div class="flex flex-wrap items-center gap-3 rounded-xl border border-brand-primary-border bg-surface px-4 py-3">
        <label for="item" class="text-sm font-medium text-text-default shrink-0">
            <?php if ($mode == 'receive' or $mode == 'requisition'): ?>
                <?= lang(ucfirst($controller_name) . '.find_or_scan_item') ?>
            <?php else: ?>
                <?= lang(ucfirst($controller_name) . '.find_or_scan_item_or_receipt') ?>
            <?php endif; ?>
        </label>
        <?= form_input(['name' => 'item', 'id' => 'item', 'class' => 'ui-input flex-1 min-w-[200px]', 'tabindex' => '1']) ?>
        <button id="new_item_button" class="ui-btn-primary modal-dlg shrink-0"
                data-btn-submit="<?= lang('Common.submit') ?>"
                data-btn-new="<?= lang('Common.new') ?>"
                data-href="<?= "items/view" ?>"
                title="<?= lang('Sales.new_item') ?>">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            <?= lang('Sales.new_item') ?>
        </button>
    </div>
    <?= form_close() ?>

    <!-- Cart table -->
    <div class="overflow-x-auto rounded-xl border border-brand-primary-border">
        <table class="w-full text-sm" id="register">
            <thead class="bg-surface-muted">
                <tr>
                    <th class="px-3 py-2 text-left font-medium text-text-muted w-10"><?= lang('Common.delete') ?></th>
                    <th class="px-3 py-2 text-left font-medium text-text-muted"><?= lang('Sales.item_number') ?></th>
                    <th class="px-3 py-2 text-left font-medium text-text-muted"><?= lang(ucfirst($controller_name) . '.item_name') ?></th>
                    <th class="px-3 py-2 text-left font-medium text-text-muted"><?= lang(ucfirst($controller_name) . '.cost') ?></th>
                    <th class="px-3 py-2 text-left font-medium text-text-muted"><?= lang(ucfirst($controller_name) . '.quantity') ?></th>
                    <th class="px-3 py-2 text-left font-medium text-text-muted"><?= lang(ucfirst($controller_name) . '.ship_pack') ?></th>
                    <th class="px-3 py-2 text-left font-medium text-text-muted"><?= lang(ucfirst($controller_name) . '.discount') ?></th>
                    <th class="px-3 py-2 text-right font-medium text-text-muted"><?= lang(ucfirst($controller_name) . '.total') ?></th>
                    <th class="px-3 py-2 text-center font-medium text-text-muted"><?= lang(ucfirst($controller_name) . '.update') ?></th>
                </tr>
            </thead>

            <tbody id="cart_contents" class="divide-y divide-brand-primary-border">
                <?php if (count($cart) == 0): ?>
                    <tr>
                        <td colspan="9" class="px-4 py-6 text-center text-sm text-text-muted">
                            <?= lang('Sales.no_items_in_cart') ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach (array_reverse($cart, true) as $line => $item): ?>

                        <?= form_open("$controller_name/editItem/$line", ['class' => 'hidden', 'id' => "cart_$line"]) ?>

                        <tr class="bg-surface hover:bg-surface-muted transition-colors">
                            <td class="px-3 py-2">
                                <?= anchor("$controller_name/deleteItem/$line", '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>', ['class' => 'inline-flex text-state-danger hover:text-state-danger']) ?>
                            </td>
                            <td class="px-3 py-2 text-text-muted text-xs"><?= esc($item['item_number']) ?></td>
                            <td class="px-3 py-2">
                                <div class="text-sm text-text-default"><?= esc($item['name'] . ' ' . implode(' ', [$item['attribute_values'], $item['attribute_dtvalues']])) ?></div>
                                <div class="text-xs text-text-muted"><?= '[' . to_quantity_decimals($item['in_stock']) . ' in ' . esc($item['stock_name']) . ']' ?></div>
                                <?= form_hidden('location', (string)$item['item_location']) ?>
                            </td>

                            <?php if ($items_module_allowed && $mode != 'requisition'): ?>
                                <td class="px-3 py-2">
                                    <?= form_input(['name' => 'price', 'class' => 'ui-input !py-1 !text-sm w-24', 'value' => to_currency_no_money($item['price']), 'onClick' => 'this.select();']) ?>
                                </td>
                            <?php else: ?>
                                <td class="px-3 py-2 text-sm text-text-default">
                                    <?= $item['price'] ?>
                                    <?= form_hidden('price', to_currency_no_money($item['price'])) ?>
                                </td>
                            <?php endif; ?>

                            <td class="px-3 py-2">
                                <?= form_input(['name' => 'quantity', 'class' => 'ui-input !py-1 !text-sm w-20', 'value' => to_quantity_decimals($item['quantity']), 'onClick' => 'this.select();']) ?>
                            </td>
                            <td class="px-3 py-2">
                                <div class="relative">
                                    <?= form_dropdown('receiving_quantity', $item['receiving_quantity_choices'], $item['receiving_quantity'], ['class' => 'ui-select !py-1 !text-sm !pr-7 !pl-2']) ?>
                                    <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
                                </div>
                            </td>

                            <?php if ($items_module_allowed && $mode != 'requisition'): ?>
                                <td class="px-3 py-2">
                                    <div class="flex items-center gap-1">
                                        <?= form_input(['name' => 'discount', 'class' => 'ui-input !py-1 !text-sm w-20', 'value' => $item['discount_type'] ? to_currency_no_money($item['discount']) : to_decimals($item['discount']), 'onClick' => 'this.select();']) ?>
                                        <?= form_checkbox([
                                            'id'           => 'discount_toggle',
                                            'name'         => 'discount_toggle',
                                            'value'        => 1,
                                            'data-toggle'  => "toggle",
                                            'data-size'    => 'small',
                                            'data-onstyle' => 'success',
                                            'data-on'      => '<b>' . $config['currency_symbol'] . '</b>',
                                            'data-off'     => '<b>%</b>',
                                            'data-line'    => $line,
                                            'checked'      => $item['discount_type'] == 1
                                        ]) ?>
                                    </div>
                                </td>
                            <?php else: ?>
                                <td class="px-3 py-2 text-sm text-text-default">
                                    <?= $item['discount'] ?>
                                    <?= form_hidden('discount', (string)$item['discount']) ?>
                                </td>
                            <?php endif; ?>

                            <td class="px-3 py-2 text-right text-sm font-medium text-text-default">
                                <?= to_currency(($item['discount_type'] == PERCENT) ? $item['price'] * $item['quantity'] * $item['receiving_quantity'] - $item['price'] * $item['quantity'] * $item['receiving_quantity'] * $item['discount'] / 100 : $item['price'] * $item['quantity'] * $item['receiving_quantity'] - $item['discount']) ?>
                            </td>
                            <td class="px-3 py-2 text-center">
                                <a href="javascript:$('#<?= esc("cart_$line", 'js') ?>').submit();" title="<?= lang(ucfirst($controller_name) . '.update') ?>" class="inline-flex text-brand-primary hover:text-brand-primary-hover">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                                </a>
                            </td>
                        </tr>
                        <tr class="bg-surface">
                            <?php if ($item['allow_alt_description'] == 1): ?>
                                <td class="px-3 py-1 text-xs text-text-muted"><?= lang('Sales.description_abbrv') . ':' ?></td>
                            <?php endif; ?>
                            <td colspan="<?= $item['allow_alt_description'] == 1 ? '2' : '9' ?>" class="px-3 py-1">
                                <?php if ($item['allow_alt_description'] == 1): ?>
                                    <?= form_input(['name' => 'description', 'class' => 'ui-input !py-1 !text-sm w-full', 'value' => $item['description']]) ?>
                                <?php else: ?>
                                    <?php if ($item['description'] != ''): ?>
                                        <span class="text-xs text-text-muted"><?= esc($item['description']) ?></span>
                                        <?= form_hidden('description', $item['description']) ?>
                                    <?php else: ?>
                                        <i class="text-xs text-text-muted"><?= lang('Sales.no_description') ?></i>
                                        <?= form_hidden('description', '') ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php if ($item['allow_alt_description'] != 1): ?>
                            <?php else: ?>
                                <td colspan="7"></td>
                            <?php endif; ?>
                        </tr>

                        <?= form_close() ?>

                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Overall Receiving -->
<div id="overall_sale" class="mt-4 rounded-xl border border-brand-primary-border bg-surface">
    <div class="p-4 space-y-4">

        <?php if (isset($supplier)): ?>
            <div class="rounded-xl border border-brand-primary-border bg-surface-muted overflow-hidden">
                <table class="w-full text-sm">
                    <tr class="border-b border-brand-primary-border">
                        <th class="px-4 py-2 text-left font-medium text-text-default"><?= lang(ucfirst($controller_name) . '.supplier') ?></th>
                        <td class="px-4 py-2 text-right text-text-muted"><?= esc($supplier) ?></td>
                    </tr>
                    <?php if (!empty($supplier_email)): ?>
                        <tr class="border-b border-brand-primary-border">
                            <th class="px-4 py-2 text-left font-medium text-text-default"><?= lang(ucfirst($controller_name) . '.supplier_email') ?></th>
                            <td class="px-4 py-2 text-right text-text-muted"><?= esc($supplier_email) ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (!empty($supplier_address)): ?>
                        <tr class="border-b border-brand-primary-border">
                            <th class="px-4 py-2 text-left font-medium text-text-default"><?= lang(ucfirst($controller_name) . '.supplier_address') ?></th>
                            <td class="px-4 py-2 text-right text-text-muted"><?= esc($supplier_address) ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (!empty($supplier_location)): ?>
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-text-default"><?= lang(ucfirst($controller_name) . '.supplier_location') ?></th>
                            <td class="px-4 py-2 text-right text-text-muted"><?= esc($supplier_location) ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
            <?= anchor(
                "$controller_name/removeSupplier",
                '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' . lang('Common.remove') . ' ' . lang('Suppliers.supplier'),
                [
                    'class' => 'ui-btn-secondary !text-state-danger hover:!bg-state-danger-soft',
                    'id'    => 'remove_supplier_button',
                    'title' => lang('Common.remove') . ' ' . lang('Suppliers.supplier')
                ]
            ) ?>

        <?php else: ?>

            <?= form_open("$controller_name/selectSupplier", ['id' => 'select_supplier_form']) ?>
            <div id="select_customer" class="space-y-2">
                <label id="supplier_label" for="supplier" class="ui-label"><?= lang(ucfirst($controller_name) . '.select_supplier') ?></label>
                <div class="flex items-center gap-2">
                    <?= form_input([
                        'name'  => 'supplier',
                        'id'    => 'supplier',
                        'class' => 'ui-input flex-1',
                        'value' => lang(ucfirst($controller_name) . '.start_typing_supplier_name')
                    ]) ?>
                    <button id="new_supplier_button" class="ui-btn-secondary modal-dlg shrink-0"
                            data-btn-submit="<?= lang('Common.submit') ?>"
                            data-href="<?= "suppliers/view" ?>"
                            title="<?= lang(ucfirst($controller_name) . '.new_supplier') ?>">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <?= lang(ucfirst($controller_name) . '.new_supplier') ?>
                    </button>
                </div>
            </div>
            <?= form_close() ?>

        <?php endif; ?>

        <!-- Sale totals -->
        <table id="sale_totals" class="w-full text-sm">
            <tr>
                <?php if ($mode != 'requisition'): ?>
                    <td class="py-2 font-semibold text-text-default"><?= lang('Sales.total') ?></td>
                    <td class="py-2 text-right font-bold text-brand-primary-active text-lg"><?= to_currency($total) ?></td>
                <?php else: ?>
                    <td class="py-2"></td>
                    <td class="py-2"></td>
                <?php endif; ?>
            </tr>
        </table>

        <?php if (count($cart) > 0): ?>
            <div id="finish_sale">

                <?php if ($mode == 'requisition'): ?>

                    <?= form_open("$controller_name/requisitionComplete", ['id' => 'finish_receiving_form']) ?>
                    <div class="space-y-3">
                        <div>
                            <label id="comment_label" for="comment" class="ui-label mb-1"><?= lang('Common.comments') ?></label>
                            <?= form_textarea(['name' => 'comment', 'id' => 'comment', 'class' => 'ui-input min-h-[80px] resize-y', 'value' => $comment]) ?>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <button type="button" id="cancel_receiving_button" class="ui-btn-secondary !text-state-danger hover:!bg-state-danger-soft">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                <?= lang(ucfirst($controller_name) . '.cancel_receiving') ?>
                            </button>
                            <button type="button" id="finish_receiving_button" class="ui-btn-primary">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                <?= lang(ucfirst($controller_name) . '.complete_receiving') ?>
                            </button>
                        </div>
                    </div>
                    <?= form_close() ?>

                <?php else: ?>

                    <?= form_open("$controller_name/complete", ['id' => 'finish_receiving_form']) ?>
                    <div class="space-y-3">
                        <div>
                            <label id="comment_label" for="comment" class="ui-label mb-1"><?= lang('Common.comments') ?></label>
                            <?= form_textarea(['name' => 'comment', 'id' => 'comment', 'class' => 'ui-input min-h-[80px] resize-y', 'value' => $comment]) ?>
                        </div>
                        <div id="payment_details" class="space-y-2 text-sm">
                            <div class="flex items-center justify-between gap-4 py-1 border-b border-brand-primary-border">
                                <span class="text-text-default"><?= lang(ucfirst($controller_name) . '.print_after_sale') ?></span>
                                <?= form_checkbox([
                                    'name'    => 'recv_print_after_sale',
                                    'id'      => 'recv_print_after_sale',
                                    'value'   => 1,
                                    'class'   => 'h-4 w-4 cursor-pointer rounded accent-brand-primary',
                                    'checked' => $print_after_sale == 1
                                ]) ?>
                            </div>
                            <?php if ($mode == "receive"): ?>
                                <div class="flex items-center justify-between gap-4 py-1 border-b border-brand-primary-border">
                                    <span class="text-text-default"><?= lang(ucfirst($controller_name) . '.reference') ?></span>
                                    <?= form_input(['name' => 'recv_reference', 'id' => 'recv_reference', 'class' => 'ui-input !py-1 !text-sm w-32', 'value' => $reference]) ?>
                                </div>
                            <?php endif; ?>
                            <div class="flex items-center justify-between gap-4 py-1 border-b border-brand-primary-border">
                                <span class="text-text-default"><?= lang('Sales.payment') ?></span>
                                <div class="relative inline-flex items-center">
                                    <?= form_dropdown('payment_type', $payment_options, [], ['id' => 'payment_types', 'class' => 'ui-select !w-auto !py-1 !pl-3 !pr-8 !text-sm']) ?>
                                    <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg></div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between gap-4 py-1">
                                <span class="text-text-default"><?= lang('Sales.amount_tendered') ?></span>
                                <?= form_input(['name' => 'amount_tendered', 'value' => '', 'class' => 'ui-input !py-1 !text-sm w-28']) ?>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <button type="button" id="cancel_receiving_button" class="ui-btn-secondary !text-state-danger hover:!bg-state-danger-soft">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                <?= lang(ucfirst($controller_name) . '.cancel_receiving') ?>
                            </button>
                            <button type="button" id="finish_receiving_button" class="ui-btn-primary">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                <?= lang(ucfirst($controller_name) . '.complete_receiving') ?>
                            </button>
                        </div>
                    </div>
                    <?= form_close() ?>

                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#item").autocomplete({
            source: '<?= esc("$controller_name/stockItemSearch") ?>',
            minChars: 0,
            delay: 10,
            autoFocus: false,
            select: function(a, ui) {
                $(this).val(ui.item.value);
                $("#add_item_form").submit();
                return false;
            }
        });

        $('#item').focus();

        $('#item').keypress(function(e) {
            if (e.which == 13) {
                $('#add_item_form').submit();
                return false;
            }
        });

        $('#item').blur(function() {
            $(this).attr('value', "<?= lang('Sales.start_typing_item_name') ?>");
        });

        $('#comment').keyup(function() {
            $.post('<?= esc("$controller_name/setComment") ?>', {
                comment: $('#comment').val()
            });
        });

        $('#recv_reference').keyup(function() {
            $.post('<?= esc("$controller_name/setReference") ?>', {
                recv_reference: $('#recv_reference').val()
            });
        });

        $("#recv_print_after_sale").change(function() {
            $.post('<?= esc("$controller_name/setPrintAfterSale") ?>', {
                recv_print_after_sale: $(this).is(":checked")
            });
        });

        $('#item,#supplier').click(function() {
            $(this).attr('value', '');
        });

        $("#supplier").autocomplete({
            source: '<?= "suppliers/suggest" ?>',
            minChars: 0,
            delay: 10,
            select: function(a, ui) {
                $(this).val(ui.item.value);
                $("#select_supplier_form").submit();
            }
        });

        dialog_support.init("a.modal-dlg, button.modal-dlg");

        $('#supplier').blur(function() {
            $(this).attr('value', "<?= lang(ucfirst($controller_name) . '.start_typing_supplier_name') ?>");
        });

        $("#finish_receiving_button").click(function() {
            $('#finish_receiving_form').submit();
        });

        $("#cancel_receiving_button").click(function() {
            if (confirm('<?= lang(ucfirst($controller_name) . '.confirm_cancel_receiving') ?>')) {
                $('#finish_receiving_form').attr('action', '<?= esc("$controller_name/cancelReceiving") ?>');
                $('#finish_receiving_form').submit();
            }
        });

        $("#cart_contents input").keypress(function(event) {
            if (event.which == 13) {
                $(this).parents("tr").prevAll("form:first").submit();
            }
        });

        table_support.handle_submit = function(resource, response, stay_open) {
            if (response.success) {
                if (resource.match(/suppliers$/)) {
                    $("#supplier").val(response.id);
                    $("#select_supplier_form").submit();
                } else {
                    $("#item").val(response.id);
                    if (stay_open) {
                        $("#add_item_form").ajaxSubmit();
                    } else {
                        $("#add_item_form").submit();
                    }
                }
            }
        }

        $('[name="price"],[name="quantity"],[name="receiving_quantity"],[name="discount"],[name="description"],[name="serialnumber"]').change(function() {
            $(this).parents("tr").prevAll("form:first").submit()
        });

        $('[name="discount_toggle"]').change(function() {
            var input = $("<input>").attr("type", "hidden").attr("name", "discount_type").val(($(this).prop('checked')) ? 1 : 0);
            $('#cart_' + $(this).attr('data-line')).append($(input));
            $('#cart_' + $(this).attr('data-line')).submit();
        });

    });
</script>

<?= view('partial/footer') ?>
