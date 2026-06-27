<?php
/**
 * @var object $user_info
 * @var array $allowed_modules
 * @var CodeIgniter\HTTP\IncomingRequest $request
 * @var array $config
 */

use Config\Services;

$request = Services::request();
$active_module = $request->getUri()->getSegment(1);
?>

<!doctype html>
<html lang="<?= current_language_code() ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= base_url() ?>">
    <title><?= esc($config['company']) . ' | ' . lang('Common.powered_by') . ' OSPOS ' . esc(config('App')->application_version) ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap">
    <?php $theme = (empty($config['theme']) ? 'flatly' : esc($config['theme'])); ?>
    <link rel="stylesheet" href="resources/bootswatch/<?= "$theme" ?>/bootstrap.min.css">

    <?php if (ENVIRONMENT == 'development' || get_cookie('debug') == 'true' || $request->getGet('debug') == 'true') : ?>
        <!-- inject:debug:css -->
        <link rel="stylesheet" href="resources/css/jquery-ui-fe010342cb.css">
        <link rel="stylesheet" href="resources/css/bootstrap-dialog-1716ef6e7c.css">
        <link rel="stylesheet" href="resources/css/jasny-bootstrap-40bf85f3ed.css">
        <link rel="stylesheet" href="resources/css/bootstrap-datetimepicker-66374fba71.css">
        <link rel="stylesheet" href="resources/css/bootstrap-select-66d5473b84.css">
        <link rel="stylesheet" href="resources/css/bootstrap-table-ed9d1a3360.css">
        <link rel="stylesheet" href="resources/css/bootstrap-table-sticky-header-07d65e7533.css">
        <link rel="stylesheet" href="resources/css/daterangepicker-85523b7dfe.css">
        <link rel="stylesheet" href="resources/css/chartist-c19aedb81a.css">
        <link rel="stylesheet" href="resources/css/chartist-plugin-tooltip-2e0ec92e60.css">
        <link rel="stylesheet" href="resources/css/bootstrap-tagsinput-5a6d46a06c.css">
        <link rel="stylesheet" href="resources/css/bootstrap-toggle-e12db6c1f3.css">
        <link rel="stylesheet" href="resources/css/bootstrap-4875cf7b0d.autocomplete.css">
        <link rel="stylesheet" href="resources/css/invoice-a99a4dfac3.css">
        <link rel="stylesheet" href="resources/css/ospos_print-bf10c1438b.css">
        <link rel="stylesheet" href="resources/css/ospos-d0b91fdf8f.css">
        <link rel="stylesheet" href="resources/css/popupbox-57d45cb822.css">
        <link rel="stylesheet" href="resources/css/receipt-0606f1c54e.css">
        <link rel="stylesheet" href="resources/css/register-a6a6cc948d.css">
        <link rel="stylesheet" href="resources/css/reports-ace7faf688.css">
        <!-- endinject -->
        <!-- inject:debug:js -->
        <script src="resources/js/jquery-12e87d2f3a.js"></script>
        <script src="resources/js/jquery-4fa896f615.form.js"></script>
        <script src="resources/js/jquery-a0350e8820.validate.js"></script>
        <script src="resources/js/jquery-ui-cbc65ff85e.js"></script>
        <script src="resources/js/bootstrap-894d79839f.js"></script>
        <script src="resources/js/bootstrap-dialog-27123abb65.js"></script>
        <script src="resources/js/jasny-bootstrap-7c6d7b8adf.js"></script>
        <script src="resources/js/bootstrap-datetimepicker-25e39b7ef8.js"></script>
        <script src="resources/js/bootstrap-select-b01896a67b.js"></script>
        <script src="resources/js/bootstrap-table-bdb06552ea.js"></script>
        <script src="resources/js/bootstrap-table-export-6389dc2aa5.js"></script>
        <script src="resources/js/bootstrap-table-mobile-fc655b68ab.js"></script>
        <script src="resources/js/bootstrap-table-sticky-header-cb4d83d172.js"></script>
        <script src="resources/js/moment-d65dc6d2e6.min.js"></script>
        <script src="resources/js/daterangepicker-048c56a690.js"></script>
        <script src="resources/js/es6-promise-855125e6f5.js"></script>
        <script src="resources/js/FileSaver-e73b1946e8.js"></script>
        <script src="resources/js/html2canvas-e1d3a8d7cd.js"></script>
        <script src="resources/js/jspdf-bbbebb610c.umd.js"></script>
        <script src="resources/js/purify-d160df429f.js"></script>
        <script src="resources/js/jspdf-92d87e47e8.plugin.autotable.js"></script>
        <script src="resources/js/tableExport-3d506dfa61.min.js"></script>
        <script src="resources/js/chartist-8a7ecb4445.js"></script>
        <script src="resources/js/chartist-plugin-pointlabels-0a1ab6aa4e.js"></script>
        <script src="resources/js/chartist-plugin-tooltip-116cb48831.js"></script>
        <script src="resources/js/chartist-plugin-axistitle-80a1198058.js"></script>
        <script src="resources/js/chartist-plugin-barlabels-4165273742.js"></script>
        <script src="resources/js/bootstrap-notify-376bc6eb87.js"></script>
        <script src="resources/js/bootstrap-tagsinput-855a7c7670.js"></script>
        <script src="resources/js/bootstrap-toggle-1c7a19a049.js"></script>
        <script src="resources/js/clipboard-908af414ab.js"></script>
        <script src="resources/js/imgpreview-1db063409f.full.jquery.js"></script>
        <script src="resources/js/manage_tables-e5dae00ba1.js"></script>
        <script src="resources/js/nominatim-89be77a11a.autocomplete.js"></script>
        <!-- endinject -->
    <?php else : ?>
        <!--inject:prod:css -->
        <link rel="stylesheet" href="resources/opensourcepos-8f45024eca.min.css">
        <!-- endinject -->

        <!-- Tweaks to the UI for a particular theme should drop here  -->
        <?php if ($config['theme'] != 'flatly' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/css/' . esc($config['theme']) . '.css')) { ?>
            <link rel="stylesheet" href="<?= 'css/' . esc($config['theme']) . '.css' ?>">
        <?php } ?>
        <!-- inject:prod:js -->
        <script src="resources/jquery-2c872dbe60.min.js"></script>
        <script src="resources/opensourcepos-0c4b48a0bf.min.js"></script>
        <!-- endinject -->
    <?php endif; ?>

    <!-- Tailwind refactor visual - convive con Bootstrap durante la transicion -->
    <link rel="stylesheet" href="<?= base_url('css/tailwind-build.css') ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

    <?= view('partial/header_js') ?>
    <?= view('partial/lang_lines') ?>

    <style>
        html {
            overflow: auto;
        }
    </style>
</head>

<?php
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
?>

<body class="tw min-h-screen flex flex-col"
      x-data="{
          mobileOpen: false,
          sidebarExpanded: localStorage.getItem('sidebar-expanded') !== 'false',
          toggleSidebar() {
              this.sidebarExpanded = !this.sidebarExpanded;
              localStorage.setItem('sidebar-expanded', this.sidebarExpanded);
          }
      }">

    <!-- ── TOP HEADER ─────────────────────────────────────────────────── -->
    <header class="sticky top-0 z-20 h-16 shrink-0 bg-surface border-b border-brand-primary-border">
        <div class="h-full px-4 flex items-center justify-between gap-4">

            <div class="flex items-center gap-2">
                <!-- Hamburguesa (mobile) -->
                <button type="button"
                        @click="mobileOpen = !mobileOpen"
                        class="md:hidden inline-flex h-10 w-10 items-center justify-center rounded-lg text-text-muted hover:bg-brand-primary-soft hover:text-brand-primary transition-colors"
                        :aria-expanded="mobileOpen.toString()"
                        aria-label="Menu">
                    <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/>
                    </svg>
                    <svg x-show="mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Logo -->
                <a href="<?= site_url() ?>" class="flex items-center gap-2 shrink-0 min-w-0">
                    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-brand-primary-soft to-brand-primary-border text-brand-primary">
                        <?php if (isset($config['company_logo']) && !empty($config['company_logo'])): ?>
                            <img class="h-full w-full object-cover"
                                 src="<?= base_url('uploads/' . esc($config['company_logo'], 'url')) ?>"
                                 alt="<?= esc(lang('Common.logo') . ' ' . $config['company']) ?>">
                        <?php else: ?>
                            <svg viewBox="0 0 308.57998 308.57997" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                                <circle cx="154.28999" cy="154.28999" r="154.28999" fill="currentColor"/>
                                <path fill="#fff" d="M154.88998 145.66999c-.03-1.26-.03-3.29.19-4.29 4.6-11.1 15.57-18.82 28.3-18.82h.41v58.3c0 .12-.03.78-.04.9-.54 16.46-14.01 29.7-30.59 29.7v27.08c21 0 39.17-11.27 49.29-28.07l.07-.11c2.9.45 5.86.75 8.9.75 31.95 0 57.81-26 57.81-57.81 0-30.87-24.37-56.46-55.1-57.81h-30.74c-17.18 0-32.61 7.64-43.22 19.63-10.59-11.92-25.86-19.59-43.02-19.59-31.86 0-57.77 25.91-57.77 57.77 0 31.86 25.91 57.77 57.77 57.77 31.86 0 57.77-25.91 57.77-57.77v-3.68c-.01.01-.02-3.31-.03-3.95zm-57.75 38.33c-16.92 0-30.69-13.77-30.69-30.69s13.77-30.69 30.69-30.69 30.69 13.77 30.69 30.69-13.77 30.69-30.69 30.69zm142.96-19.87c-4.33 11.64-15.57 19.9-28.7 19.9h-.54v-61.47h.54c13.13 0 24.37 8.26 28.7 19.9 1.35 3.25 2.03 6.91 2.03 10.83s-.67 7.59-2.03 10.84z"/>
                            </svg>
                        <?php endif; ?>
                    </span>
                    <span class="font-display text-lg font-semibold text-brand-primary-active truncate max-sm:hidden">
                        <?= esc($config['company']) ?>
                    </span>
                </a>
            </div>

            <!-- Reloj + usuario -->
            <div class="flex items-center gap-4 text-sm">
                <div id="liveclock" class="text-text-muted tabular-nums max-sm:hidden"></div>
                <span class="h-4 w-px bg-brand-primary-border max-sm:hidden"></span>
                <div class="flex items-center gap-3">
                    <?= anchor("home/changePassword/$user_info->person_id", "$user_info->first_name $user_info->last_name", ['class' => 'modal-dlg font-medium text-text-default hover:text-brand-primary transition-colors', 'data-btn-submit' => lang('Common.submit'), 'title' => lang('Employees.change_password')]) ?>
                    <span class="text-brand-primary-border">|</span>
                    <?= anchor('home/logout', lang('Login.logout'), ['class' => 'text-text-muted hover:text-state-danger transition-colors', 'id' => 'logout']) ?>
                </div>
            </div>
        </div>
    </header>

    <!-- ── LAYOUT: sidebar + contenido ───────────────────────────────── -->
    <div class="flex flex-1">

        <!-- SIDEBAR (desktop) ───────────────────────────────────────── -->
        <aside class="hidden md:flex flex-col sticky top-16 self-start shrink-0 bg-surface border-r border-brand-primary-border overflow-hidden transition-all duration-300 ease-in-out"
               style="height: calc(100vh - 4rem)"
               :class="sidebarExpanded ? 'w-56' : 'w-14'">

            <nav class="flex-1 overflow-y-auto overflow-x-hidden py-3 px-2 space-y-0.5">
                <?php foreach ($allowed_modules as $module): ?>
                    <?php $is_active = $module->module_id == $active_module; ?>
                    <a href="<?= base_url($module->module_id) ?>"
                       class="menu-icon flex items-center gap-3 rounded-lg px-2 py-2.5 text-sm font-medium transition-colors <?= $is_active ? 'bg-brand-primary-soft text-brand-primary' : 'text-text-muted hover:bg-brand-primary-soft hover:text-brand-primary' ?>"
                       :title="sidebarExpanded ? undefined : '<?= lang('Module.' . $module->module_id) ?>'">
                        <iconify-icon icon="<?= $module_icons[$module->module_id] ?? 'ph:circle' ?>" width="20" height="20" class="shrink-0" aria-hidden="true"></iconify-icon>
                        <span class="whitespace-nowrap transition-[opacity] duration-200"
                              :class="sidebarExpanded ? 'opacity-100' : 'opacity-0 pointer-events-none'">
                            <?= lang('Module.' . $module->module_id) ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </nav>

            <!-- Botón toggle collapse/expand -->
            <div class="border-t border-brand-primary-border p-2 shrink-0">
                <button @click="toggleSidebar()"
                        class="w-full flex items-center justify-center h-9 rounded-lg text-text-muted hover:bg-brand-primary-soft hover:text-brand-primary transition-colors"
                        :title="sidebarExpanded ? 'Colapsar menú' : 'Expandir menú'">
                    <svg class="h-5 w-5 transition-transform duration-300"
                         :class="sidebarExpanded ? '' : 'rotate-180'"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7M18 19l-7-7 7-7"/>
                    </svg>
                </button>
            </div>
        </aside>

        <!-- OVERLAY backdrop (mobile) ──────────────────────────────── -->
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileOpen = false"
             class="fixed inset-0 z-40 bg-black/50 md:hidden"
             style="display:none"
             aria-hidden="true">
        </div>

        <!-- DRAWER mobile ──────────────────────────────────────────── -->
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 z-50 w-64 flex flex-col bg-surface border-r border-brand-primary-border md:hidden"
             style="display:none">

            <!-- Drawer header -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-brand-primary-border shrink-0">
                <span class="font-display text-base font-semibold text-brand-primary-active">
                    <?= esc($config['company']) ?>
                </span>
                <button @click="mobileOpen = false"
                        class="h-9 w-9 flex items-center justify-center rounded-lg text-text-muted hover:bg-brand-primary-soft hover:text-brand-primary transition-colors">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Drawer nav -->
            <nav class="flex-1 overflow-y-auto py-3 px-2 space-y-0.5">
                <?php foreach ($allowed_modules as $module): ?>
                    <?php $is_active = $module->module_id == $active_module; ?>
                    <a href="<?= base_url($module->module_id) ?>"
                       class="menu-icon flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors <?= $is_active ? 'bg-brand-primary-soft text-brand-primary' : 'text-text-default hover:bg-brand-primary-soft hover:text-brand-primary' ?>">
                        <iconify-icon icon="<?= $module_icons[$module->module_id] ?? 'ph:circle' ?>" width="20" height="20" class="shrink-0" aria-hidden="true"></iconify-icon>
                        <?= lang('Module.' . $module->module_id) ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <!-- Drawer user info -->
            <div class="border-t border-brand-primary-border px-4 py-3 shrink-0 text-sm space-y-1">
                <?= anchor("home/changePassword/$user_info->person_id", "$user_info->first_name $user_info->last_name", ['class' => 'modal-dlg block font-medium text-text-default hover:text-brand-primary transition-colors', 'data-btn-submit' => lang('Common.submit'), 'title' => lang('Employees.change_password')]) ?>
                <?= anchor('home/logout', lang('Login.logout'), ['class' => 'block text-text-muted hover:text-state-danger transition-colors']) ?>
            </div>
        </div>

        <!-- MAIN CONTENT ────────────────────────────────────────────── -->
        <main class="flex-1 min-w-0">
            <div class="container">
                <div class="row">
