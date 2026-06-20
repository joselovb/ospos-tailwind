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
        <!-- endinject -->
        <!-- inject:debug:js -->
        <!-- endinject -->
    <?php else : ?>
        <!--inject:prod:css -->
        <!-- endinject -->

        <!-- Tweaks to the UI for a particular theme should drop here  -->
        <?php if ($config['theme'] != 'flatly' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/css/' . esc($config['theme']) . '.css')) { ?>
            <link rel="stylesheet" href="<?= 'css/' . esc($config['theme']) . '.css' ?>">
        <?php } ?>
        <!-- inject:prod:js -->
        <!-- endinject -->
    <?php endif; ?>

    <!-- Tailwind refactor visual - convive con Bootstrap durante la transicion -->
    <link rel="stylesheet" href="<?= base_url('css/tailwind-build.css') ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <?= view('partial/header_js') ?>
    <?= view('partial/lang_lines') ?>

    <style>
        html {
            overflow: auto;
        }
    </style>
</head>

<body class="tw min-h-screen flex flex-col">

    <header class="sticky top-0 z-20 bg-surface border-b border-brand-primary-border" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-4">
                <a href="<?= site_url() ?>" class="flex items-center gap-2 shrink-0 min-w-0">
                    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-brand-primary-soft to-brand-primary-border text-brand-primary">
                        <?php if (isset($config['company_logo']) && !empty($config['company_logo'])): ?>
                            <img class="h-full w-full object-cover" src="<?= base_url('uploads/' . esc($config['company_logo'], 'url')) ?>" alt="<?= esc(lang('Common.logo') . '&nbsp;' . $config['company']) ?>">
                        <?php else: ?>
                            <svg viewBox="0 0 308.57998 308.57997" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                                <circle cx="154.28999" cy="154.28999" r="154.28999" fill="currentColor" />
                                <path fill="#fff" d="M154.88998 145.66999c-.03-1.26-.03-3.29.19-4.29 4.6-11.1 15.57-18.82 28.3-18.82h.41v58.3c0 .12-.03.78-.04.9-.54 16.46-14.01 29.7-30.59 29.7v27.08c21 0 39.17-11.27 49.29-28.07l.07-.11c2.9.45 5.86.75 8.9.75 31.95 0 57.81-26 57.81-57.81 0-30.87-24.37-56.46-55.1-57.81h-30.74c-17.18 0-32.61 7.64-43.22 19.63-10.59-11.92-25.86-19.59-43.02-19.59-31.86 0-57.77 25.91-57.77 57.77 0 31.86 25.91 57.77 57.77 57.77 31.86 0 57.77-25.91 57.77-57.77v-3.68c-.01.01-.02-3.31-.03-3.95zm-57.75 38.33c-16.92 0-30.69-13.77-30.69-30.69s13.77-30.69 30.69-30.69 30.69 13.77 30.69 30.69-13.77 30.69-30.69 30.69zm142.96-19.87c-4.33 11.64-15.57 19.9-28.7 19.9h-.54v-61.47h.54c13.13 0 24.37 8.26 28.7 19.9 1.35 3.25 2.03 6.91 2.03 10.83s-.67 7.59-2.03 10.84z" />
                            </svg>
                        <?php endif; ?>
                    </span>
                    <span class="font-display text-lg font-semibold text-brand-primary-active truncate hidden sm:inline"><?= esc($config['company']) ?></span>
                </a>

                <!-- Reloj + menu de usuario (desktop) -->
                <div class="hidden md:flex items-center gap-4 text-sm">
                    <div id="liveclock" class="text-text-muted tabular-nums"></div>
                    <span class="h-4 w-px bg-brand-primary-border"></span>
                    <div class="flex items-center gap-3">
                        <?= anchor("home/changePassword/$user_info->person_id", "$user_info->first_name $user_info->last_name", ['class' => 'modal-dlg font-medium text-text-default hover:text-brand-primary transition-colors', 'data-btn-submit' => lang('Common.submit'), 'title' => lang('Employees.change_password')]) ?>
                        <span class="text-brand-primary-border">|</span>
                        <?= anchor('home/logout', lang('Login.logout'), ['class' => 'text-text-muted hover:text-state-danger transition-colors']) ?>
                    </div>
                </div>

                <!-- Hamburguesa (mobile) -->
                <button type="button" @click="mobileOpen = !mobileOpen" class="md:hidden inline-flex h-11 w-11 items-center justify-center rounded-lg text-text-muted hover:bg-brand-primary-soft hover:text-brand-primary transition-colors" :aria-expanded="mobileOpen.toString()" aria-label="Menu">
                    <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                    </svg>
                    <svg x-show="mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Nav de modulos (desktop) -->
        <nav class="hidden md:block border-t border-brand-primary-border bg-surface-muted">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <ul class="flex gap-1 overflow-x-auto py-1.5">
                    <?php foreach ($allowed_modules as $module): ?>
                        <?php $is_active = $module->module_id == $active_module; ?>
                        <li>
                            <a href="<?= base_url($module->module_id) ?>" title="<?= lang("Module.$module->module_id") ?>"
                               class="menu-icon flex items-center gap-2 whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium transition-colors <?= $is_active ? 'bg-brand-primary-soft text-brand-primary' : 'text-text-muted hover:bg-brand-primary-soft hover:text-brand-primary' ?>">
                                <img src="<?= base_url("images/menubar/$module->module_id.svg") ?>" style="border: none;" alt="" class="h-5 w-5 shrink-0">
                                <?= lang('Module.' . $module->module_id) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>

        <!-- Panel colapsable (mobile) -->
        <div
            x-show="mobileOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden border-t border-brand-primary-border bg-surface"
            style="display: none;"
        >
            <ul class="space-y-1 px-4 py-3">
                <?php foreach ($allowed_modules as $module): ?>
                    <?php $is_active = $module->module_id == $active_module; ?>
                    <li>
                        <a href="<?= base_url($module->module_id) ?>" title="<?= lang("Module.$module->module_id") ?>"
                           class="menu-icon flex items-center gap-3 rounded-lg px-3 py-2.5 text-base font-medium transition-colors <?= $is_active ? 'bg-brand-primary-soft text-brand-primary' : 'text-text-default hover:bg-brand-primary-soft hover:text-brand-primary' ?>">
                            <img src="<?= base_url("images/menubar/$module->module_id.svg") ?>" style="border: none;" alt="" class="h-6 w-6 shrink-0">
                            <?= lang('Module.' . $module->module_id) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="border-t border-brand-primary-border px-4 py-3 space-y-2 text-sm">
                <div class="flex items-center gap-3">
                    <?= anchor("home/changePassword/$user_info->person_id", "$user_info->first_name $user_info->last_name", ['class' => 'modal-dlg font-medium text-text-default hover:text-brand-primary transition-colors', 'data-btn-submit' => lang('Common.submit'), 'title' => lang('Employees.change_password')]) ?>
                    <span class="text-brand-primary-border">|</span>
                    <?= anchor('home/logout', lang('Login.logout'), ['class' => 'text-text-muted hover:text-state-danger transition-colors']) ?>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1">
        <div class="container">
            <div class="row">
