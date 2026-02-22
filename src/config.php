<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

const NAV_ITEMS = [
    'home' => 'Home',
    'skills' => 'Skills',
    'projects' => 'Projects',
    'experience' => 'Experience',
    'contact' => 'Contact',
];

function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function section_url(string $section): string
{
    return '?section=' . rawurlencode($section);
}

function is_post_request(): bool
{
    return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function csrf_token(): string
{
    $existing = $_SESSION['_csrf'] ?? null;
    if (!is_string($existing) || $existing === '') {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }

    return (string) $_SESSION['_csrf'];
}

function is_valid_csrf_token(?string $token): bool
{
    $stored = $_SESSION['_csrf'] ?? null;
    if (!is_string($stored) || $stored === '' || !is_string($token) || $token === '') {
        return false;
    }

    return hash_equals($stored, $token);
}

final class SectionResolver
{
    private const DEFAULT_SECTION = 'home';

    private const ALLOWED_SECTIONS = [
        'home',
        'skills',
        'projects',
        'experience',
        'contact',
    ];

    public static function resolve(?string $section): string
    {
        if ($section === null) {
            return self::DEFAULT_SECTION;
        }

        $section = strtolower(trim($section));

        return in_array($section, self::ALLOWED_SECTIONS, true)
            ? $section
            : self::DEFAULT_SECTION;
    }

    public static function navItems(): array
    {
        return NAV_ITEMS;
    }
}

final class PortfolioRepository
{
    public function getDeveloper(): array
    {
        return [
            'name' => 'Harshal Sawant',
            'title' => 'Full-Stack Software Developer',
            'email' => 'harshalsawant.dev@gmail.com',
            'phone' => '+91 8828166801',
            'location' => 'Mumbai, IN',
            'bio' => 'Passionate software developer focused on building fast, usable, and reliable web applications.',
            'github' => 'https://github.com/c0d3h01',
            'linkedin' => 'https://linkedin.com/in/haarshalsawant',
            'twitter' => 'https://twitter.com/haarshalsawant',
            'discord' => 'https://discordapp.com/users/904361015171481610',
        ];
    }

    public function getSkills(): array
    {
        return [
            'Frontend' => ['JavaScript', 'React', 'TypeScript'],
            'Backend' => ['PHP', 'Node.js', 'Python', 'Rust'],
            'Database' => ['MySQL', 'PostgreSQL', 'MongoDB'],
            'DevOps' => ['Docker', 'Nix', 'CI/CD', 'Linux', 'Nginx'],
        ];
    }

    public function getProjects(): array
    {
        return [
            [
                'title' => 'E-Commerce Platform',
                'description' => 'An end-to-end commerce platform with inventory tracking and payment integration.',
                'technologies' => ['React', 'Node.js', 'MongoDB', 'Stripe API'],
                'github' => 'https://github.com/c0d3h01',
                'demo' => 'https://example.com/ecommerce-demo',
                'image' => $this->svgPlaceholder('E-Commerce', '#6366F1'),
            ],
            [
                'title' => 'Task Management App',
                'description' => 'A collaborative planning app with real-time updates and team workflows.',
                'technologies' => ['Vue.js', 'PHP', 'MySQL', 'WebSocket'],
                'github' => 'https://github.com/c0d3h01',
                'demo' => 'https://example.com/task-demo',
                'image' => $this->svgPlaceholder('Task Manager', '#10B981'),
            ],
            [
                'title' => 'Weather Dashboard',
                'description' => 'Forecast dashboards with map overlays, alerts, and trend visualizations.',
                'technologies' => ['JavaScript', 'PHP', 'OpenWeather API', 'Chart.js'],
                'github' => 'https://github.com/c0d3h01',
                'demo' => 'https://example.com/weather-demo',
                'image' => $this->svgPlaceholder('Weather App', '#0594EA'),
            ],
        ];
    }

    public function getExperience(): array
    {
        return [
            [
                'position' => 'Junior Developer',
                'company' => 'X | X.com',
                'duration' => '2022 - 2023',
                'description' => 'Built backend services, fixed production defects, and improved release quality.',
                'achievements' => [
                    'Completed 20+ projects',
                    'Learned 5 new technologies',
                    'Received excellence award',
                ],
            ],
            [
                'position' => 'Software Developer',
                'company' => 'X | X.com',
                'duration' => '2023 - 2024',
                'description' => 'Delivered full-stack features and collaborated with designers on UX improvements.',
                'achievements' => [
                    'Reduced API response time by 30%',
                    'Introduced CI checks for pull requests',
                    'Mentored incoming junior developers',
                ],
            ],
            [
                'position' => 'Full-Stack Developer',
                'company' => 'X | X.com',
                'duration' => '2024 - Present',
                'description' => 'Leading implementation of user-facing features and internal tooling.',
                'achievements' => [
                    'Shipped multi-service authentication flow',
                    'Improved deployment reliability',
                    'Maintained high customer satisfaction',
                ],
            ],
        ];
    }

    private function svgPlaceholder(string $text, string $color): string
    {
        $safeText = htmlspecialchars($text, ENT_QUOTES | ENT_XML1, 'UTF-8');
        $safeColor = htmlspecialchars($color, ENT_QUOTES | ENT_XML1, 'UTF-8');

        $svg = sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" width="300" height="200">' .
            '<rect width="300" height="200" fill="%s"/>' .
            '<text x="150" y="100" fill="white" text-anchor="middle" dy=".3em" font-family="Arial" font-size="18">%s</text>' .
            '</svg>',
            $safeColor,
            $safeText
        );

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}

final class ContactFormProcessor
{
    private string $logFilePath;

    public function __construct(string $logFilePath)
    {
        $this->logFilePath = $logFilePath;
    }

    public function emptyState(): array
    {
        return [
            'type' => '',
            'message' => '',
            'values' => [
                'name' => '',
                'email' => '',
                'subject' => '',
                'message' => '',
            ],
        ];
    }

    public function process(array $post): array
    {
        $state = $this->emptyState();
        $state['values'] = $this->collectValues($post);

        if (!is_valid_csrf_token($post['_token'] ?? null)) {
            $state['type'] = 'error';
            $state['message'] = 'Session validation failed. Please refresh and submit again.';
            return $state;
        }

        if (!$this->isValid($state['values'])) {
            $state['type'] = 'error';
            $state['message'] = 'Please provide valid values for every form field.';
            return $state;
        }

        $this->persist($state['values']);
        $state['type'] = 'success';
        $state['message'] = 'Thank you for your message. I will get back to you soon.';
        $state['values'] = $this->emptyState()['values'];

        return $state;
    }

    private function collectValues(array $post): array
    {
        return [
            'name' => $this->normalizeSingleLine($post['name'] ?? ''),
            'email' => $this->normalizeSingleLine($post['email'] ?? ''),
            'subject' => $this->normalizeSingleLine($post['subject'] ?? ''),
            'message' => $this->normalizeMultiLine($post['message'] ?? ''),
        ];
    }

    private function normalizeSingleLine($value): string
    {
        $value = trim((string) $value);
        $value = preg_replace('/\s+/', ' ', $value);

        return is_string($value) ? $value : '';
    }

    private function normalizeMultiLine($value): string
    {
        $value = str_replace("\r\n", "\n", (string) $value);
        $value = preg_replace("/\n{3,}/", "\n\n", $value);

        return trim(is_string($value) ? $value : '');
    }

    private function isValid(array $values): bool
    {
        if ($values['name'] === '' || strlen($values['name']) < 2) {
            return false;
        }

        if ($values['email'] === '' || filter_var($values['email'], FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        if ($values['subject'] === '' || strlen($values['subject']) < 3) {
            return false;
        }

        return $values['message'] !== '' && strlen($values['message']) >= 10;
    }

    private function persist(array $values): void
    {
        $directory = dirname($this->logFilePath);
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            return;
        }

        $record = [
            'received_at' => gmdate('c'),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'name' => $values['name'],
            'email' => $values['email'],
            'subject' => $values['subject'],
            'message' => $values['message'],
        ];

        $json = json_encode($record, JSON_UNESCAPED_SLASHES);
        if (!is_string($json)) {
            return;
        }

        file_put_contents(
            $this->logFilePath,
            $json . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );
    }
}
