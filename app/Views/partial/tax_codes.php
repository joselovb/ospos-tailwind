<?php
/**
 * @var array $tax_codes
 */
?>

<?php
$i = 0;

foreach ($tax_codes as $tax_code => $tax_code_data) {
    $tax_code_id   = $tax_code_data['tax_code_id'];
    $tax_code      = $tax_code_data['tax_code'];
    $tax_code_name = $tax_code_data['tax_code_name'];
    $city          = $tax_code_data['city'];
    $state         = $tax_code_data['state'];
    ++$i;
?>

    <div class="flex flex-wrap items-center gap-2 rounded-xl border border-brand-primary-border bg-surface px-4 py-3<?= $tax_code_data['deleted'] ? ' hidden' : '' ?>">
        <label for="tax_code_<?= $i ?>" class="ui-label text-sm font-medium text-text-default shrink-0"><?= lang('Taxes.tax_code') ?> <?= $i ?></label>
        <?= form_input([
            'name'        => 'tax_code[]',
            'id'          => "tax_code_$i",
            'class'       => 'valid_chars text-uppercase ui-input !py-1.5 !text-sm w-20 required',
            'placeholder' => lang('Taxes.code'),
            'value'       => $tax_code
        ]) ?>
        <?= form_input([
            'name'        => 'tax_code_name[]',
            'class'       => 'valid_chars ui-input !py-1.5 !text-sm flex-1 min-w-[120px]',
            'placeholder' => lang('Taxes.name'),
            'value'       => $tax_code_name
        ]) ?>
        <?= form_input([
            'name'        => 'city[]',
            'class'       => 'valid_chars ui-input !py-1.5 !text-sm w-28',
            'placeholder' => lang('Taxes.city'),
            'value'       => $city
        ]) ?>
        <?= form_input([
            'name'        => 'state[]',
            'class'       => 'valid_chars ui-input !py-1.5 !text-sm w-20',
            'placeholder' => lang('Taxes.state'),
            'value'       => $state
        ]) ?>
        <button type="button" class="add_tax_code ui-btn-secondary !p-1.5 shrink-0" title="<?= lang('Common.new') ?>">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </button>
        <button type="button" class="remove_tax_code ui-btn-secondary !p-1.5 !text-state-danger hover:!bg-state-danger-soft shrink-0" title="<?= lang('Common.delete') ?>">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </button>
        <?= form_hidden('tax_code_id[]', (string)$tax_code_id) ?>
    </div>

<?php } ?>
