<?php
/**
 * @var bool $has_errors
 * @var bool $is_latest
 * @var bool $is_new_install
 * @var string $latest_version
 * @var bool $gcaptcha_enabled
 * @var CodeIgniter\HTTP\IncomingRequest $request
 * @var array $config
 * @var $validation
 */

use Config\Services;

$request = Services::request();
?>

<!doctype html>
<html lang="<?= current_language_code() ?>">

<head>
    <meta charset="utf-8">
    <base href="<?= base_url() ?>">
    <title><?= esc($config['company']) . '&nbsp;|&nbsp;' . esc(lang('Common.software_short')) . '&nbsp;|&nbsp;' . esc(lang('Login.login')) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <?php
    $theme = (empty($config['theme'])
        || 'paper' == $config['theme']
        || 'readable' == $config['theme']
        ? 'flatly'
        : $config['theme']);
    ?>
    <link rel="stylesheet" href="resources/bootswatch5/<?= "$theme" ?>/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('css/tailwind-build.css') ?>">
    <meta name="theme-color" content="#2c3e50">
</head>

<body class="tw min-h-screen flex flex-col bg-gradient-to-br from-surface-muted to-brand-primary-soft">
    <main class="flex flex-1 items-center justify-center p-4 sm:p-6">
        <div class="card-elevated w-full max-w-3xl overflow-hidden md:grid md:grid-cols-2">

            <!-- Panel de marca -->
            <div class="flex flex-col items-center justify-center gap-4 bg-gradient-to-br from-brand-primary to-brand-primary-active px-6 py-10 text-text-on-brand sm:px-10">
                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-surface shadow-lg sm:h-28 sm:w-28">
                    <?php if (isset($config['company_logo']) && !empty($config['company_logo'])): ?>
                        <img class="h-16 w-16 object-contain sm:h-20 sm:w-20" src="<?= base_url('uploads/' . esc($config['company_logo'], 'url')) ?>" alt="<?= esc(lang('Common.logo') . '&nbsp;' . $config['company']) ?>">
                    <?php else: ?>
                        <svg class="h-14 w-14 text-brand-primary sm:h-16 sm:w-16" role="img" viewBox="0 0 308.57998 308.57997" xmlns="http://www.w3.org/2000/svg">
                            <title><?= lang('Common.software_title') . '&nbsp;' . lang('Common.logo') ?></title>
                            <circle cx="154.28999" cy="154.28999" r="154.28999" fill="currentColor" />
                            <path fill="#fff" d="M154.88998 145.66999c-.03-1.26-.03-3.29.19-4.29 4.6-11.1 15.57-18.82 28.3-18.82h.41v58.3c0 .12-.03.78-.04.9-.54 16.46-14.01 29.7-30.59 29.7v27.08c21 0 39.17-11.27 49.29-28.07l.07-.11c2.9.45 5.86.75 8.9.75 31.95 0 57.81-26 57.81-57.81 0-30.87-24.37-56.46-55.1-57.81h-30.74c-17.18 0-32.61 7.64-43.22 19.63-10.59-11.92-25.86-19.59-43.02-19.59-31.86 0-57.77 25.91-57.77 57.77 0 31.86 25.91 57.77 57.77 57.77 31.86 0 57.77-25.91 57.77-57.77v-3.68c-.01.01-.02-3.31-.03-3.95zm-57.75 38.33c-16.92 0-30.69-13.77-30.69-30.69s13.77-30.69 30.69-30.69 30.69 13.77 30.69 30.69-13.77 30.69-30.69 30.69zm142.96-19.87c-4.33 11.64-15.57 19.9-28.7 19.9h-.54v-61.47h.54c13.13 0 24.37 8.26 28.7 19.9 1.35 3.25 2.03 6.91 2.03 10.83s-.67 7.59-2.03 10.84z" />
                        </svg>
                    <?php endif; ?>
                </div>
                <p class="text-center font-display text-lg font-semibold"><?= esc($config['company']) ?></p>
                <p class="text-center text-sm text-text-on-brand/80"><?= lang('Common.software_title') ?></p>
            </div>

            <!-- Panel de formulario -->
            <section class="flex flex-col justify-center gap-1 px-6 py-10 sm:px-10">
                <?= form_open('login', ['id' => 'login-form', 'class' => 'flex flex-col gap-1']) ?>

                <h3 id="form-heading" class="text-center text-xl font-semibold text-text-default">
                    <?php if (!$is_latest || $is_new_install): ?>
                        <?= lang('Login.migration_required') ?>
                    <?php else: ?>
                        <?= lang('Login.welcome', [lang('Common.software_short')]) ?>
                    <?php endif; ?>
                </h3>

                <div id="migration-warning" class="alert-warning mt-3<?= $is_new_install ? '' : ' d-none' ?>">
                    <strong><?= lang('Login.migration_auth_message', [$latest_version]) ?></strong>
                </div>

                <?php if ($has_errors): ?>
                    <?php foreach ($validation->getErrors() as $error): ?>
                        <div class="alert-danger mt-3">
                            <?= $error ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div id="migration-success" class="alert-success d-none mt-3">
                    <strong><?= lang('Login.migration_complete') ?></strong> <?= lang('Login.migration_complete_login') ?>
                </div>

                <div id="migration-progress" class="d-none mt-4">
                    <h3 class="text-center mb-4 text-base font-semibold text-text-default"><?= lang('Login.migration_initializing') ?></h3>
                    <div class="mb-3 h-2.5 w-full overflow-hidden rounded-full bg-brand-primary-soft">
                        <div class="h-full w-full animate-pulse rounded-full bg-gradient-to-r from-brand-primary to-brand-accent" role="progressbar"></div>
                    </div>
                    <p class="text-center text-sm text-text-muted" id="migration-status">
                        <?= lang('Login.migration_running') ?>
                    </p>
                </div>

                <div id="migration-error" class="alert-danger d-none mt-3" role="alert">
                    <strong>Error:</strong> <span id="migration-error-message"></span>
                </div>

                <div id="login-fields" class="w-full<?= $is_new_install ? ' d-none' : '' ?>">
                    <?php if (empty($config['login_form']) || 'floating_labels' == ($config['login_form'])): ?>
                        <div class="mt-3">
                            <label for="input-username" class="label-base"><?= lang('Login.username') ?></label>
                            <input class="input-base" id="input-username" name="username" type="text" placeholder="<?= lang('Login.username') ?>" <?php if (ENVIRONMENT == "testing") echo 'value="admin"'; ?>>
                        </div>
                        <div class="mt-3">
                            <label for="input-password" class="label-base"><?= lang('Login.password') ?></label>
                            <input class="input-base" id="input-password" name="password" type="password" placeholder="<?= lang('Login.password') ?>" <?php if (ENVIRONMENT == "testing") echo 'value="pointofsale"'; ?>>
                        </div>
                    <?php elseif ('input_groups' == ($config['login_form'])): ?>
                        <div class="mt-3">
                            <label for="username" class="label-base"><?= lang('Login.username') ?></label>
                            <div class="relative">
                                <span id="input-username" class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                        <title><?= lang('Common.icon') . '&nbsp;' . lang('Login.username') ?></title>
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                    </svg>
                                </span>
                                <input class="input-base pl-10" name="username" type="text" placeholder="<?= lang('Login.username'); ?>" aria-label="<?= lang('Login.username') ?>" aria-describedby="input-username" <?php if (ENVIRONMENT == "testing") echo 'value="admin"'; ?>>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="password" class="label-base"><?= lang('Login.password') ?></label>
                            <div class="relative">
                                <span id="input-password" class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-text-muted">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                        <title><?= lang('Common.icon') . '&nbsp;' . lang('Login.password') ?></title>
                                        <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2M2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                    </svg>
                                </span>
                                <input class="input-base pl-10" name="password" type="password" placeholder="<?= lang('Login.password') ?>" aria-label="<?= lang('Login.password') ?>" aria-describedby="input-password" <?php if (ENVIRONMENT == "testing") echo 'value="pointofsale"'; ?>>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($gcaptcha_enabled): ?>
                        <script src="https://www.google.com/recaptcha/api.js"></script>
                        <div class="g-recaptcha mb-3 mt-3 overflow-x-auto" style="text-align: center;" data-sitekey="<?= esc($config['gcaptcha_site_key']) ?>"></div>
                    <?php endif; ?>
                </div>

                <button id="submit-button" class="btn-primary mt-4 w-full" name="login-button" type="submit">
                    <?php if ($is_new_install): ?>
                        <?= lang('Module.migrate') ?>
                    <?php else: ?>
                        <?= lang('Login.go') ?>
                    <?php endif; ?>
                </button>
                <?= form_close() ?>
            </section>
        </div>
    </main>

    <footer class="flex shrink-0 justify-center pb-6 text-center">
        <div class="flex items-center gap-2 rounded-full bg-surface px-4 py-2 text-sm text-text-muted shadow">
            <span class="text-brand-primary">
                <svg height="1.25em" role="img" viewBox="0 0 308.57998 308.57997" xmlns="http://www.w3.org/2000/svg">
                    <title><?= lang('Common.software_title') . '&nbsp;' . lang('Common.logo') ?></title>
                    <circle cx="154.28999" cy="154.28999" r="154.28999" fill="currentColor" />
                    <path fill="#fff" d="M154.88998 145.66999c-.03-1.26-.03-3.29.19-4.29 4.6-11.1 15.57-18.82 28.3-18.82h.41v58.3c0 .12-.03.78-.04.9-.54 16.46-14.01 29.7-30.59 29.7v27.08c21 0 39.17-11.27 49.29-28.07l.07-.11c2.9.45 5.86.75 8.9.75 31.95 0 57.81-26 57.81-57.81 0-30.87-24.37-56.46-55.1-57.81h-30.74c-17.18 0-32.61 7.64-43.22 19.63-10.59-11.92-25.86-19.59-43.02-19.59-31.86 0-57.77 25.91-57.77 57.77 0 31.86 25.91 57.77 57.77 57.77 31.86 0 57.77-25.91 57.77-57.77v-3.68c-.01.01-.02-3.31-.03-3.95zm-57.75 38.33c-16.92 0-30.69-13.77-30.69-30.69s13.77-30.69 30.69-30.69 30.69 13.77 30.69 30.69-13.77 30.69-30.69 30.69zm142.96-19.87c-4.33 11.64-15.57 19.9-28.7 19.9h-.54v-61.47h.54c13.13 0 24.37 8.26 28.7 19.9 1.35 3.25 2.03 6.91 2.03 10.83s-.67 7.59-2.03 10.84z" />
                </svg>
            </span>
            <span><?= lang('Common.software_title') ?></span>
        </div>
    </footer>

    <?php if (ENVIRONMENT == 'development' || get_cookie('debug') == 'true' || $request->getGet('debug') == 'true') : ?>
        <!-- inject:login:debug:js -->
        <!-- endinject -->
    <?php else : ?>
        <!-- inject:login:prod:js -->
        <!-- endinject -->
    <?php endif; ?>
    <script>
        const APP_STATE = {
            isNewInstall: <?= $is_new_install ? 'true' : 'false' ?>,
            isLatest: <?= $is_latest ? 'true' : 'false' ?>,
            csrfToken: '<?= csrf_token() ?>',
            csrfHash: '<?= csrf_hash() ?>',
            migrateUrl: '<?= site_url('migrate') ?>',
            loginUrl: '<?= site_url('login') ?>',
            i18n: {
                welcome: <?= json_encode(lang('Login.welcome', [lang('Common.software_short')])) ?>,
                migrate: <?= json_encode(lang('Module.migrate')) ?>,
                go: <?= json_encode(lang('Login.go')) ?>,
                migrationRequired: <?= json_encode(lang('Login.migration_required')) ?>,
                migrationInitializing: <?= json_encode(lang('Login.migration_initializing')) ?>,
                migrationRunning: <?= json_encode(lang('Login.migration_running')) ?>,
                migrationComplete: <?= json_encode(lang('Login.migration_complete')) ?>,
                migrationCompleteLogin: <?= json_encode(lang('Login.migration_complete_login')) ?>,
                migrationFailed: <?= json_encode(lang('Login.migration_failed')) ?>,
                migrationErrorConnection: <?= json_encode(lang('Login.migration_error_connection')) ?>
            }
        };

        $(document).ready(function() {
            const $form = $('#login-form');
            const $heading = $('#form-heading');
            const $warning = $('#migration-warning');
            const $success = $('#migration-success');
            const $progress = $('#migration-progress');
            const $error = $('#migration-error');
            const $errorMessage = $('#migration-error-message');
            const $loginFields = $('#login-fields');
            const $submitButton = $('#submit-button');

            function showMigrationRequired() {
                $heading.text(APP_STATE.i18n.migrationRequired);
                $warning.removeClass('d-none');
                $success.addClass('d-none');
                $progress.addClass('d-none');
                $error.addClass('d-none');
                $loginFields.addClass('d-none');
                $submitButton.text(APP_STATE.i18n.migrate);
            }

            function showMigrationProgress() {
                $warning.addClass('d-none');
                $success.addClass('d-none');
                $error.addClass('d-none');
                $loginFields.addClass('d-none');
                $progress.removeClass('d-none');
                $submitButton.prop('disabled', true);
            }

            function showMigrationSuccess() {
                $progress.addClass('d-none');
                $error.addClass('d-none');
                $warning.addClass('d-none');
                $success.removeClass('d-none');
                $heading.text(APP_STATE.i18n.welcome);
                $loginFields.removeClass('d-none');
                $submitButton.text(APP_STATE.i18n.go);
                $submitButton.prop('disabled', false);
            }

            function showMigrationError(message) {
                $progress.addClass('d-none');
                $success.addClass('d-none');
                $loginFields.addClass('d-none');
                $errorMessage.text(message);
                $error.removeClass('d-none');
                $warning.addClass('d-none');
                $submitButton.text(APP_STATE.i18n.migrate);
                $submitButton.prop('disabled', false);
            }

            function showLoginForm() {
                $heading.text(APP_STATE.i18n.welcome);
                $warning.addClass('d-none');
                $progress.addClass('d-none');
                $error.addClass('d-none');
                $success.addClass('d-none');
                $loginFields.removeClass('d-none');
                $submitButton.text(APP_STATE.i18n.go);
            }

            if (!APP_STATE.isNewInstall) {
                showLoginForm();
            }

            $form.on('submit', function(e) {
                if (APP_STATE.isNewInstall) {
                    e.preventDefault();

                    showMigrationProgress();

                    $.ajax({
                        url: APP_STATE.migrateUrl,
                        type: 'POST',
                        dataType: 'json',
                        timeout: 3600000,
                        data: {
                            [APP_STATE.csrfToken]: APP_STATE.csrfHash
                        },
                        success: function(response) {
                            if (response.success) {
                                APP_STATE.isNewInstall = false;
                                showMigrationSuccess();
                            } else {
                                showMigrationError(response.message || APP_STATE.i18n.migrationFailed);
                            }
                        },
                        error: function(xhr, status, error) {
                            let message = APP_STATE.i18n.migrationErrorConnection;
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            showMigrationError(message);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
