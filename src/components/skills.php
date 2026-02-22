<?php
declare(strict_types=1);

function renderSkillsSection(array $skills): void
{
    ?>
    <section class="content-section">
        <div class="container">
            <div class="section-header">
                <h2>Skills & Technologies</h2>
                <p>Here are the technologies and tools I work with to create amazing applications</p>
            </div>
            <div class="skills-grid">
                <?php foreach ($skills as $category => $skillList): ?>
                    <div class="skill-category">
                        <h3><?= h((string) $category) ?></h3>
                        <div class="skills-list">
                            <?php foreach ($skillList as $skill): ?>
                                <span class="skill-tag"><?= h((string) $skill) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}
