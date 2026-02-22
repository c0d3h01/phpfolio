<?php
declare(strict_types=1);

function renderExperienceSection(array $experience): void
{
    ?>
    <section class="content-section">
        <div class="container">
            <div class="section-header">
                <h2>Professional Experience</h2>
                <p>My journey in software development and key achievements</p>
            </div>
            <div class="timeline">
                <?php foreach ($experience as $job): ?>
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <div class="timeline-date"><?= h($job['duration']) ?></div>
                            <h3 class="timeline-title"><?= h($job['position']) ?></h3>
                            <div class="timeline-company"><?= h($job['company']) ?></div>
                            <p><?= h($job['description']) ?></p>
                            <ul class="achievements">
                                <?php foreach ($job['achievements'] as $achievement): ?>
                                    <li><?= h((string) $achievement) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}
