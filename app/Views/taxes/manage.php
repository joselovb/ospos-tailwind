<?php
/**
 * @var string $controller_name
 */
?>

<?= view('partial/header') ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>

<div x-data="{ tab: 'tax_codes' }">

    <div class="flex gap-1 border-b border-brand-primary-border mb-6 overflow-x-auto">
        <button type="button"
                @click="tab = 'tax_codes'"
                :class="tab === 'tax_codes' ? 'border-b-2 border-brand-primary text-brand-primary font-semibold' : 'text-text-muted hover:text-brand-primary'"
                class="px-4 py-2.5 text-sm transition-colors whitespace-nowrap -mb-px">
            <?= lang(ucfirst($controller_name) . '.tax_codes') ?>
        </button>
        <button type="button"
                @click="tab = 'tax_jurisdictions'"
                :class="tab === 'tax_jurisdictions' ? 'border-b-2 border-brand-primary text-brand-primary font-semibold' : 'text-text-muted hover:text-brand-primary'"
                class="px-4 py-2.5 text-sm transition-colors whitespace-nowrap -mb-px">
            <?= lang(ucfirst($controller_name) . '.tax_jurisdictions') ?>
        </button>
        <button type="button"
                @click="tab = 'tax_categories'"
                :class="tab === 'tax_categories' ? 'border-b-2 border-brand-primary text-brand-primary font-semibold' : 'text-text-muted hover:text-brand-primary'"
                class="px-4 py-2.5 text-sm transition-colors whitespace-nowrap -mb-px">
            <?= lang(ucfirst($controller_name) . '.tax_categories') ?>
        </button>
        <button type="button"
                @click="tab = 'tax_rates'"
                :class="tab === 'tax_rates' ? 'border-b-2 border-brand-primary text-brand-primary font-semibold' : 'text-text-muted hover:text-brand-primary'"
                class="px-4 py-2.5 text-sm transition-colors whitespace-nowrap -mb-px">
            <?= lang(ucfirst($controller_name) . '.tax_rates') ?>
        </button>
    </div>

    <div x-show="tab === 'tax_codes'">
        <?= view('taxes/tax_codes') ?>
    </div>

    <div x-show="tab === 'tax_jurisdictions'" style="display:none">
        <?= view('taxes/tax_jurisdictions') ?>
    </div>

    <div x-show="tab === 'tax_categories'" style="display:none">
        <?= view('taxes/tax_categories') ?>
    </div>

    <div x-show="tab === 'tax_rates'" style="display:none">
        <?= view('taxes/tax_rates') ?>
    </div>

</div>

<?= view('partial/footer') ?>
