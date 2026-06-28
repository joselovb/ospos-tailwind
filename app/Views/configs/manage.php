<?= view('partial/header') ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>

<div class="mb-6 flex items-center gap-3">
    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-primary to-brand-accent">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-text-on-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/><line x1="12" y1="2" x2="12" y2="4"/><line x1="12" y1="20" x2="12" y2="22"/></svg>
    </div>
    <h1 class="font-display text-2xl font-semibold text-brand-primary-active">Configuration</h1>
</div>

<div x-data="{ tab: 'info' }">

    <!-- Tab bar -->
    <div class="-mb-px flex flex-wrap border-b border-brand-primary-border">
        <?php
        $tabs = [
            'info'      => lang('Config.info'),
            'general'   => lang('Config.general'),
            'tax'       => lang('Config.tax'),
            'locale'    => lang('Config.locale'),
            'barcode'   => lang('Config.barcode'),
            'stock'     => lang('Config.location'),
            'receipt'   => lang('Config.receipt'),
            'invoice'   => lang('Config.invoice'),
            'shortcuts' => lang('Config.shortcuts'),
            'reward'    => lang('Config.reward'),
            'table'     => lang('Config.table'),
            'system'    => lang('Config.system_conf'),
        ];
        ?>
        <?php foreach ($tabs as $key => $label) : ?>
            <button type="button"
                    @click="tab = '<?= $key ?>'"
                    :class="tab === '<?= $key ?>'
                        ? 'border-b-2 border-brand-primary text-brand-primary-active font-semibold'
                        : 'text-text-muted hover:text-text-default'"
                    class="px-3 py-2 text-sm transition-colors -mb-px whitespace-nowrap">
                <?= $label ?>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Tab panes -->
    <div class="mt-6">
        <div x-show="tab === 'info'">
            <?= view('configs/info_config') ?>
        </div>
        <div x-show="tab === 'general'" style="display:none">
            <?= view('configs/general_config') ?>
        </div>
        <div x-show="tab === 'tax'" style="display:none">
            <?= view('configs/tax_config') ?>
        </div>
        <div x-show="tab === 'locale'" style="display:none">
            <?= view('configs/locale_config') ?>
        </div>
        <div x-show="tab === 'barcode'" style="display:none">
            <?= view('configs/barcode_config') ?>
        </div>
        <div x-show="tab === 'stock'" style="display:none">
            <?= view('configs/stock_config') ?>
        </div>
        <div x-show="tab === 'receipt'" style="display:none">
            <?= view('configs/receipt_config') ?>
        </div>
        <div x-show="tab === 'invoice'" style="display:none">
            <?= view('configs/invoice_config') ?>
        </div>
        <div x-show="tab === 'shortcuts'" style="display:none">
            <?= view('configs/shortcuts_config') ?>
        </div>
        <div x-show="tab === 'reward'" style="display:none">
            <?= view('configs/reward_config') ?>
        </div>
        <div x-show="tab === 'table'" style="display:none">
            <?= view('configs/table_config') ?>
        </div>
        <div x-show="tab === 'system'" style="display:none">
            <?= view('configs/system_config') ?>
        </div>
    </div>

</div>

<?= view('partial/footer') ?>
