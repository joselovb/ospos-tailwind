<?php
/**
 * @var array $licenses
 */
?>

<?= form_open('', ['id' => 'license_config_form', 'enctype' => 'multipart/form-data']) ?>

<div class="space-y-6">
    <?php
    $counter = 0;
    foreach ($licenses as $license) {
    ?>
        <div>
            <label class="ui-label mb-2 block"><?= $license['title'] ?></label>
            <?= form_textarea([
                'name'     => 'license',
                'id'       => 'license_' . $counter++,
                'class'    => 'ui-input min-h-[280px] font-mono text-xs resize-y',
                'rows'     => '14',
                'readonly' => '',
                'value'    => $license['text']
            ]) ?>
        </div>
    <?php } ?>
</div>

<?= form_close() ?>
