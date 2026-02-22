<?php
declare(strict_types=1);

require_once __DIR__ . '/src/config.php';
require_once __DIR__ . '/src/components/header.php';
require_once __DIR__ . '/src/components/home.php';
require_once __DIR__ . '/src/components/skills.php';
require_once __DIR__ . '/src/components/projects.php';
require_once __DIR__ . '/src/components/experience.php';
require_once __DIR__ . '/src/components/contact.php';
require_once __DIR__ . '/src/components/footer.php';

$repository = new PortfolioRepository();
$currentSection = SectionResolver::resolve($_GET['section'] ?? $_POST['section'] ?? null);
$navItems = SectionResolver::navItems();

$developer = $repository->getDeveloper();
$skills = $repository->getSkills();
$projects = $repository->getProjects();
$experience = $repository->getExperience();

$contactFormProcessor = new ContactFormProcessor(__DIR__ . '/storage/contact_messages.log');
$contactState = $contactFormProcessor->emptyState();
if ($currentSection === 'contact' && is_post_request()) {
    $contactState = $contactFormProcessor->process($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($developer['name']) ?> - <?= h($developer['title']) ?></title>
    <link rel="stylesheet" href="/src/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php renderHeader($developer, $navItems, $currentSection); ?>

    <main>
        <?php
        switch ($currentSection) {
            case 'skills':
                renderSkillsSection($skills);
                break;
            case 'projects':
                renderProjectsSection($projects);
                break;
            case 'experience':
                renderExperienceSection($experience);
                break;
            case 'contact':
                renderContactSection($developer, $contactState);
                break;
            case 'home':
            default:
                renderHomeSection($developer);
                break;
        }
        ?>
    </main>

    <?php renderFooter($developer); ?>

    <script src="/src/index.js"></script>
</body>
</html>
