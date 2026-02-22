<?php
declare(strict_types=1);

function renderHomeSection(array $developer): void
{
    ?>
    <section class="hero">
        <div class="container hero-content">
            <h1><?= h($developer['name']) ?></h1>
            <p class="subtitle"><?= h($developer['title']) ?></p>
            <p class="bio"><?= h($developer['bio']) ?></p>
            <div class="cta-buttons">
                <a href="<?= section_url('projects') ?>" class="btn btn-primary">View My Work</a>
                <a href="<?= section_url('contact') ?>" class="btn btn-outline">Get In Touch</a>
            </div>
        </div>
    </section>
    <?php
}
