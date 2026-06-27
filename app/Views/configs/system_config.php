<div x-data="{ subtab: 'system' }">

    <div class="-mb-px flex flex-wrap border-b border-brand-primary-border mb-4">
        <?php
        $subtabs = [
            'system'       => lang('Config.system_conf'),
            'email'        => lang('Config.email'),
            'message'      => lang('Config.message'),
            'integrations' => lang('Config.integrations'),
            'license'      => lang('Config.license'),
        ];
        ?>
        <?php foreach ($subtabs as $key => $label) : ?>
            <button type="button"
                    @click="subtab = '<?= $key ?>'"
                    :class="subtab === '<?= $key ?>'
                        ? 'border-b-2 border-brand-primary text-brand-primary-active font-semibold'
                        : 'text-text-muted hover:text-text-default'"
                    class="px-3 py-2 text-sm transition-colors -mb-px whitespace-nowrap">
                <?= $label ?>
            </button>
        <?php endforeach; ?>
    </div>

    <div>
        <div x-show="subtab === 'system'">
            <?= view('configs/system_info') ?>
        </div>
        <div x-show="subtab === 'email'" style="display:none">
            <?= view('configs/email_config') ?>
        </div>
        <div x-show="subtab === 'message'" style="display:none">
            <?= view('configs/message_config') ?>
        </div>
        <div x-show="subtab === 'integrations'" style="display:none">
            <?= view('configs/integrations_config') ?>
        </div>
        <div x-show="subtab === 'license'" style="display:none">
            <?= view('configs/license_config') ?>
        </div>
    </div>

</div>
