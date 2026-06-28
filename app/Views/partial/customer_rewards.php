<?php
/**
 * @var array $customer_rewards
 */
?>

<?php
$i = 0;

foreach ($customer_rewards as $reward_key => $reward_category) {
    $customer_reward_id = $reward_category['package_id'];
    $customer_reward_name = $reward_category['package_name'];
    $customer_points_percent = $reward_category['points_percent'];
    ++$i;
?>

    <div class="flex items-center gap-3" style="<?= $reward_category['deleted'] ? 'display: none;' : 'display: flex;' ?>">
        <?= form_label(lang('Config.customer_reward') . " $i", "customer_reward_$i", ['class' => 'ui-label text-sm w-36 shrink-0']) ?>
        <div class="min-w-0 flex-1">
            <?php $form_data = [
                'name'  => 'customer_reward_' . $customer_reward_id,
                'id'    => 'customer_reward_' . $customer_reward_id,
                'class' => 'customer_reward valid_chars ui-input required',
                'value' => $customer_reward_name
            ];
            $reward_category['deleted'] && $form_data['disabled'] = 'disabled';
            echo form_input($form_data);
            ?>
        </div>
        <div class="w-24 shrink-0">
            <?php $form_data = [
                'name'  => 'reward_points_' . $customer_reward_id,
                'id'    => 'reward_points_' . $customer_reward_id,
                'class' => 'customer_reward valid_chars ui-input required',
                'value' => $customer_points_percent
            ];
            $reward_category['deleted'] && $form_data['disabled'] = 'disabled';
            echo form_input($form_data);
            ?>
        </div>
        <button type="button" class="add_customer_reward flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-brand-primary-border text-brand-primary hover:bg-brand-primary-soft">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </button>
        <button type="button" class="remove_customer_reward flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-state-danger/30 text-state-danger hover:bg-state-danger-soft">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </button>
    </div>

<?php } ?>
