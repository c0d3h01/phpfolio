<?php
declare(strict_types=1);

function renderHeader(array $developer, array $navItems, string $currentSection): void
{
    ?>
    <header>
        <nav class="container">
            <a href="<?= section_url('home') ?>" class="logo"><?= h($developer['name']) ?></a>
            <ul class="nav-links">
                <?php foreach ($navItems as $sectionKey => $label): ?>
                    <?php $isActive = $currentSection === $sectionKey; ?>
                    <li>
                        <a href="<?= section_url((string) $sectionKey) ?>"<?= $isActive ? ' class="active"' : '' ?>>
                            <?= h((string) $label) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </header>
    <?php
}
