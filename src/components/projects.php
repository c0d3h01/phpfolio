<?php
declare(strict_types=1);

function renderProjectsSection(array $projects): void
{
    ?>
    <section class="content-section">
        <div class="container">
            <div class="section-header">
                <h2>Featured Projects</h2>
                <p>Some of my recent work that I am proud to share</p>
            </div>
            <div class="projects-grid">
                <?php foreach ($projects as $project): ?>
                    <div class="project-card">
                        <img
                            src="<?= h($project['image']) ?>"
                            alt="<?= h($project['title']) ?>"
                            class="project-image"
                        >
                        <div class="project-content">
                            <h3 class="project-title"><?= h($project['title']) ?></h3>
                            <p class="project-description"><?= h($project['description']) ?></p>
                            <div class="tech-tags">
                                <?php foreach ($project['technologies'] as $tech): ?>
                                    <span class="tech-tag"><?= h((string) $tech) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <div class="project-links">
                                <a href="<?= h($project['github']) ?>" target="_blank" rel="noopener noreferrer">GitHub</a>
                                <a href="<?= h($project['demo']) ?>" target="_blank" rel="noopener noreferrer">Live Demo</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}
