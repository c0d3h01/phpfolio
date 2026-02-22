<?php
declare(strict_types=1);

function renderContactSection(array $developer, array $state): void
{
    $message = $state['message'] ?? '';
    $type = $state['type'] ?? '';
    $values = $state['values'] ?? [];
    ?>
    <section class="content-section">
        <div class="container">
            <div class="section-header">
                <h2>Get In Touch</h2>
                <p>Let us work together to bring your ideas to life</p>
            </div>
            <div class="contact-grid">
                <div class="contact-info">
                    <h3>Contact Information</h3>
                    <div class="contact-item">
                        <strong>Email:</strong> <?= h($developer['email']) ?>
                    </div>
                    <div class="contact-item">
                        <strong>Phone:</strong> <?= h($developer['phone']) ?>
                    </div>
                    <div class="contact-item">
                        <strong>Location:</strong> <?= h($developer['location']) ?>
                    </div>
                </div>
                <div class="contact-form">
                    <h3>Send Me a Message</h3>
                    <?php if ($message !== ''): ?>
                        <div class="<?= $type === 'success' ? 'success-message' : 'error-message' ?>">
                            <?= h($message) ?>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="<?= section_url('contact') ?>" novalidate>
                        <input type="hidden" name="section" value="contact">
                        <input type="hidden" name="_token" value="<?= h(csrf_token()) ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="<?= h($values['name'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?= h($values['email'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" value="<?= h($values['subject'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" required><?= h($values['message'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
}
