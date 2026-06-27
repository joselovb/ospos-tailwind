<?php
/**
 * @var array $tax_jurisdictions
 * @var array $tax_types
 */
?>

<?php
$i = 0;

foreach ($tax_jurisdictions as $tax_jurisdiction => $jurisdiction) {
    $jurisdiction_id      = $jurisdiction['jurisdiction_id'];
    $jurisdiction_name    = $jurisdiction['jurisdiction_name'];
    $tax_group            = $jurisdiction['tax_group'];
    $reporting_authority  = $jurisdiction['reporting_authority'];
    $tax_type             = $jurisdiction['tax_type'];
    $tax_group_sequence   = $jurisdiction['tax_group_sequence'];
    $cascade_sequence     = $jurisdiction['cascade_sequence'];
    ++$i;
?>

    <div class="flex flex-wrap items-center gap-2 rounded-xl border border-brand-primary-border bg-surface px-4 py-3">
        <label for="jurisdiction_name_<?= $i ?>" class="ui-label text-sm font-medium text-text-default shrink-0"><?= lang('Taxes.tax_jurisdiction') ?> <?= $i ?></label>
        <?= form_input([
            'name'        => 'jurisdiction_name[]',
            'id'          => "jurisdiction_name_$i",
            'class'       => 'valid_chars ui-input !py-1.5 !text-sm flex-1 min-w-[120px]',
            'placeholder' => lang('Taxes.jurisdiction_name'),
            'value'       => $jurisdiction_name
        ]) ?>
        <?= form_input([
            'name'        => 'tax_group[]',
            'class'       => 'valid_chars ui-input !py-1.5 !text-sm w-24',
            'placeholder' => lang('Taxes.tax_group'),
            'value'       => $tax_group
        ]) ?>
        <div class="relative">
            <?= form_dropdown('tax_type[]' . $i, $tax_types, $tax_type, ['class' => 'ui-select !py-1.5 !text-sm !pr-7 !pl-2']) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
        <?= form_input([
            'name'        => 'reporting_authority[]',
            'class'       => 'valid_chars ui-input !py-1.5 !text-sm w-32',
            'placeholder' => lang('Taxes.reporting_authority'),
            'value'       => $reporting_authority
        ]) ?>
        <?= form_input([
            'name'        => 'tax_group_sequence[]',
            'class'       => 'valid_chars ui-input !py-1.5 !text-sm w-20',
            'placeholder' => lang('Taxes.sequence'),
            'value'       => $tax_group_sequence
        ]) ?>
        <?= form_input([
            'name'        => 'cascade_sequence[]',
            'class'       => 'valid_chars ui-input !py-1.5 !text-sm w-20',
            'placeholder' => lang('Taxes.cascade_sequence'),
            'value'       => $cascade_sequence
        ]) ?>
        <button type="button" class="add_tax_jurisdiction ui-btn-secondary !p-1.5 shrink-0" title="<?= lang('Common.new') ?>">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </button>
        <button type="button" class="remove_tax_jurisdiction ui-btn-secondary !p-1.5 !text-state-danger hover:!bg-state-danger-soft shrink-0" title="<?= lang('Common.delete') ?>">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </button>
        <?= form_hidden('jurisdiction_id[]', (string)$jurisdiction_id) ?>
    </div>

<?php } ?>
