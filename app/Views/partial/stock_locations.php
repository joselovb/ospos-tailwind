<?php
/**
 * @var array $stock_locations
 */
?>

<?php
$i = 0;

foreach ($stock_locations as $location => $location_data) {
    $location_id = $location_data['location_id'];
    $location_name = $location_data['location_name'];
    ++$i;
?>

    <div class="flex items-center gap-3" style="<?= $location_data['deleted'] ? 'display: none;' : 'display: flex;' ?>">
        <?= form_label(lang('Config.stock_location') . " $i", "stock_location_$i", ['class' => 'ui-label text-sm w-36 shrink-0']) ?>
        <div class="flex-1 max-w-xs">
            <?php $form_data = [
                'name'  => "stock_location[$location_id]",
                'id'    => "stock_location[$location_id]",
                'class' => 'stock_location valid_chars ui-input required',
                'value' => $location_name
            ];
            $location_data['deleted'] && $form_data['disabled'] = 'disabled';
            echo form_input($form_data);
            ?>
        </div>
        <button type="button" class="add_stock_location flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-brand-primary-border text-brand-primary hover:bg-brand-primary-soft">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </button>
        <button type="button" class="remove_stock_location flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-state-danger/30 text-state-danger hover:bg-state-danger-soft">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </button>
    </div>

<?php } ?>
