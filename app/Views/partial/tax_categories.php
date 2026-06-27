<?php
/**
 * @var array $tax_categories
 */
?>

<?php
$i = 0;

foreach ($tax_categories as $key => $category) {
    $tax_category_id   = $category['tax_category_id'];
    $tax_category      = $category['tax_category'];
    $tax_group_sequence = $category['tax_group_sequence'];
    ++$i;
?>

    <div class="flex flex-wrap items-center gap-2 rounded-xl border border-brand-primary-border bg-surface px-4 py-3">
        <label for="tax_category_<?= $i ?>" class="ui-label text-sm font-medium text-text-default shrink-0"><?= lang('Taxes.tax_category') ?> <?= $i ?></label>
        <?= form_input([
            'name'        => 'tax_category[]',
            'id'          => "tax_category_$i",
            'class'       => 'valid_chars ui-input !py-1.5 !text-sm flex-1 min-w-[120px]',
            'placeholder' => lang('Taxes.tax_category_name'),
            'value'       => $tax_category
        ]) ?>
        <?= form_input([
            'name'        => 'tax_group_sequence[]',
            'class'       => 'valid_chars ui-input !py-1.5 !text-sm w-24',
            'placeholder' => lang('Taxes.sequence'),
            'value'       => $tax_group_sequence
        ]) ?>
        <button type="button" class="add_tax_category ui-btn-secondary !p-1.5 shrink-0" title="<?= lang('Common.new') ?>">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </button>
        <button type="button" class="remove_tax_category ui-btn-secondary !p-1.5 !text-state-danger hover:!bg-state-danger-soft shrink-0" title="<?= lang('Common.delete') ?>">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </button>
        <?= form_hidden('tax_category_id[]', (string)$tax_category_id) ?>
    </div>

<?php } ?>
