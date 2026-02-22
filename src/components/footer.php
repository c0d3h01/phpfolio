<?php
declare(strict_types=1);

function renderFooter(array $developer): void
{
    $socials = [
        ['url' => $developer['github'] ?? '', 'title' => 'GitHub', 'icon' => 'fa-brands fa-github'],
        ['url' => $developer['linkedin'] ?? '', 'title' => 'LinkedIn', 'icon' => 'fa-brands fa-linkedin'],
        ['url' => $developer['twitter'] ?? '', 'title' => 'Twitter', 'icon' => 'fa-brands fa-twitter'],
        ['url' => $developer['discord'] ?? '', 'title' => 'Discord', 'icon' => 'fa-brands fa-discord'],
    ];
    ?>
    <footer>
        <div class="container">
            <div class="social-links">
                <?php foreach ($socials as $social): ?>
                    <?php if ($social['url'] === ''): ?>
                        <?php continue; ?>
                    <?php endif; ?>
                    <a href="<?= h($social['url']) ?>" target="_blank" rel="noopener noreferrer" title="<?= h($social['title']) ?>">
                        <i class="<?= h($social['icon']) ?>"></i>
                    </a>
                <?php endforeach; ?>
            </div>
            <p>Credit c0d3h01 @ GitHub | License: MIT</p>
        </div>
    </footer>
    <?php
}
