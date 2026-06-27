<?php

use Config\OSPOS;

?>
            </div>
        </div>
    </main>
    </div><!-- /flex flex-1 -->

    <footer class="border-t border-brand-primary-border bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center text-xs text-text-muted">
            <strong>
                <?= lang('Common.copyrights', [date('Y')]) ?> ·
                <a href="https://opensourcepos.org" target="_blank" class="text-brand-primary hover:text-brand-primary-hover underline-offset-2 hover:underline"><?= lang('Common.website') ?></a> ·
                <?= esc(config('App')->application_version) ?> -
                <a target="_blank" href="https://github.com/opensourcepos/opensourcepos/commit/<?= esc(config(OSPOS::class)->commit_sha1) ?>" class="text-brand-primary hover:text-brand-primary-hover underline-offset-2 hover:underline">
                    <?= esc(substr(config(OSPOS::class)->commit_sha1, 0, 6)); ?>
                </a>
            </strong>.
        </div>
    </footer>
    </body>
</html>
