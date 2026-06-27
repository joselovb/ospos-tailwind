<?php
/**
 * @var object $user_info
 * @var array  $allowed_modules
 * @var array  $config
 */

use Config\OSPOS;

$module_icons = [
    'home'                => 'ph:house',
    'sales'               => 'ph:shopping-cart',
    'items'               => 'ph:tag',
    'customers'           => 'ph:users',
    'employees'           => 'ph:user-list',
    'suppliers'           => 'ph:truck',
    'receivings'          => 'ph:package',
    'reports'             => 'ph:chart-bar',
    'expenses'            => 'ph:money',
    'expenses_categories' => 'ph:folder-simple',
    'giftcards'           => 'ph:gift',
    'item_kits'           => 'ph:stack',
    'taxes'               => 'ph:receipt',
    'attributes'          => 'ph:sliders-horizontal',
    'cashups'             => 'ph:currency-dollar',
    'messages'            => 'ph:envelope-simple',
    'config'              => 'ph:gear',
    'migrate'             => 'ph:arrows-clockwise',
    'office'              => 'ph:buildings',
];

$visible_modules = array_filter($allowed_modules, fn($m) => $m->module_id !== 'home' && $m->module_id !== 'office');
?>

<?= view('partial/header') ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>

<div class="flex flex-col gap-6 px-4 sm:px-6 py-8 max-w-5xl mx-auto w-full">

    <!-- ── HERO ────────────────────────────────────────────────────── -->
    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand-primary-soft via-surface to-surface border border-brand-primary-border shadow-sm px-8 py-10 flex flex-col items-center text-center gap-4">
        <div class="pointer-events-none absolute -top-16 -right-16 h-48 w-48 rounded-full bg-brand-primary opacity-5"></div>
        <div class="pointer-events-none absolute -bottom-10 -left-10 h-32 w-32 rounded-full bg-brand-accent opacity-5"></div>

        <!-- Logo -->
        <div class="relative z-10 flex h-32 w-32 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-white shadow-lg border border-brand-primary-border">
            <?php if (isset($config['company_logo']) && !empty($config['company_logo'])): ?>
                <img class="h-full w-full object-contain p-2"
                     src="<?= base_url('uploads/' . esc($config['company_logo'], 'url')) ?>"
                     alt="<?= esc($config['company']) ?>">
            <?php else: ?>
                <svg viewBox="0 0 308.57998 308.57997" class="h-20 w-20 text-brand-primary" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <circle cx="154.28999" cy="154.28999" r="154.28999" fill="currentColor"/>
                    <path fill="#ffffff" d="M154.88998 145.66999c-.03-1.26-.03-3.29.19-4.29 4.6-11.1 15.57-18.82 28.3-18.82h.41v58.3c0 .12-.03.78-.04.9-.54 16.46-14.01 29.7-30.59 29.7v27.08c21 0 39.17-11.27 49.29-28.07l.07-.11c2.9.45 5.86.75 8.9.75 31.95 0 57.81-26 57.81-57.81 0-30.87-24.37-56.46-55.1-57.81h-30.74c-17.18 0-32.61 7.64-43.22 19.63-10.59-11.92-25.86-19.59-43.02-19.59-31.86 0-57.77 25.91-57.77 57.77 0 31.86 25.91 57.77 57.77 57.77 31.86 0 57.77-25.91 57.77-57.77v-3.68c-.01.01-.02-3.31-.03-3.95zm-57.75 38.33c-16.92 0-30.69-13.77-30.69-30.69s13.77-30.69 30.69-30.69 30.69 13.77 30.69 30.69-13.77 30.69-30.69 30.69zm142.96-19.87c-4.33 11.64-15.57 19.9-28.7 19.9h-.54v-61.47h.54c13.13 0 24.37 8.26 28.7 19.9 1.35 3.25 2.03 6.91 2.03 10.83s-.67 7.59-2.03 10.84z"/>
                </svg>
            <?php endif; ?>
        </div>

        <!-- Nombre + bienvenida -->
        <div class="relative z-10">
            <h1 class="font-display text-3xl font-bold text-brand-primary-active">
                <?= esc($config['company']) ?>
            </h1>
            <p class="mt-1 text-text-muted text-base">
                <?= lang('Common.welcome_message') ?>,
                <span class="font-medium text-text-default"><?= esc($user_info->first_name) ?></span>
            </p>
        </div>

        <div class="relative z-10 h-px w-24 bg-gradient-to-r from-transparent via-brand-primary-border to-transparent"></div>
    </section>

    <!-- ── WIDGETS ──────────────────────────────────────────────────── -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <!-- Reloj en vivo -->
        <div class="flex items-center gap-4 rounded-xl bg-surface border border-brand-primary-border shadow-sm px-5 py-4">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-primary-soft text-brand-primary">
                <iconify-icon icon="ph:clock" width="22" height="22"></iconify-icon>
            </span>
            <div>
                <p class="text-xs font-medium text-text-muted uppercase tracking-wide">Hora actual</p>
                <p id="office-clock" class="text-xl font-semibold text-text-default tabular-nums">--:--:--</p>
            </div>
        </div>

        <!-- Fecha completa -->
        <div class="flex items-center gap-4 rounded-xl bg-surface border border-brand-primary-border shadow-sm px-5 py-4">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-primary-soft text-brand-primary">
                <iconify-icon icon="ph:calendar-blank" width="22" height="22"></iconify-icon>
            </span>
            <div>
                <p class="text-xs font-medium text-text-muted uppercase tracking-wide">Fecha</p>
                <p id="office-date" class="text-sm font-semibold text-text-default capitalize">—</p>
            </div>
        </div>

        <!-- Info del sistema -->
        <div class="flex items-center gap-4 rounded-xl bg-surface border border-brand-primary-border shadow-sm px-5 py-4">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-primary-soft text-brand-primary">
                <iconify-icon icon="ph:info" width="22" height="22"></iconify-icon>
            </span>
            <div>
                <p class="text-xs font-medium text-text-muted uppercase tracking-wide">OSPOS</p>
                <p class="text-sm font-semibold text-text-default">
                    v<?= esc(config('App')->application_version) ?>
                </p>
            </div>
        </div>
    </div>

    <!-- ── ACCESOS RÁPIDOS ──────────────────────────────────────────── -->
    <?php if (!empty($visible_modules)): ?>
    <section>
        <h2 class="text-sm font-semibold text-text-muted uppercase tracking-wide mb-4">Accesos rápidos</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
            <?php foreach ($visible_modules as $module): ?>
                <?php
                $mid  = $module->module_id;
                $icon = $module_icons[$mid] ?? 'ph:circle';
                $desc = lang("Module.{$mid}_desc");
                ?>
                <a href="<?= base_url($mid) ?>"
                   class="group flex flex-col items-center gap-3 rounded-xl border border-brand-primary-border bg-surface p-5 text-center shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-brand-primary hover:shadow-md hover:bg-gradient-to-b hover:from-surface hover:to-brand-primary-soft">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-primary-soft text-brand-primary transition-colors group-hover:bg-brand-primary group-hover:text-text-on-brand">
                        <iconify-icon icon="<?= $icon ?>" width="24" height="24"></iconify-icon>
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-text-default group-hover:text-brand-primary transition-colors">
                            <?= lang("Module.$mid") ?>
                        </p>
                        <?php if (!empty($desc)): ?>
                        <p class="mt-0.5 text-xs text-text-muted leading-snug line-clamp-2">
                            <?= esc($desc) ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

</div>

<script>
(function () {
    function pad(n) { return String(n).padStart(2, '0'); }

    function tick() {
        var now = new Date();
        var el  = document.getElementById('office-clock');
        if (el) el.textContent = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
    }

    function setDate() {
        var el = document.getElementById('office-date');
        if (!el) return;
        try {
            el.textContent = new Intl.DateTimeFormat(navigator.language || 'es', {
                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
            }).format(new Date());
        } catch (e) {
            el.textContent = new Date().toLocaleDateString();
        }
    }

    tick();
    setDate();
    setInterval(tick, 1000);
})();
</script>

<?= view('partial/footer') ?>
