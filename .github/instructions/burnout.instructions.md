{
  "$schema": "https://copilot.github.com/schemas/copilot.json",
  "projectName": "Burnout",
  "description": "Burnout is a social network 100% dedicated to motorcycle enthusiasts. Built with Laravel, Tailwind CSS, Redis, Horizon, MySQL and Vite. Includes authentication, messaging, and real-time features via Pusher.",
  "tags": [
    "laravel",
    "php",
    "tailwind",
    "vite",
    "redis",
    "mysql",
    "pusher",
    "horizon",
    "docker",
    "messaging",
    "authentication",
    "social-network",
    "motorcycles"
  ],
  "languages": ["php", "blade", "js", "html", "css", "bash", "json", "yaml"],
  "tools": {
    "frameworks": ["laravel", "tailwindcss"],
    "queue": ["redis", "horizon"],
    "broadcast": ["pusher"],
    "database": ["mysql"],
    "devops": ["docker", "docker-compose", "mailhog", "github-actions"],
    "tests": ["phpunit"]
  },
  "constraints": {
    "noFrameworks": ["livewire"],
    "preferredTech": {
      "frontend": "Tailwind CSS with Blade components",
      "realtime": "Pusher (not WebSockets server)",
      "backend": "Laravel MVC structure",
      "database": "MySQL"
    },
    "dev": {
      "useDocker": true,
      "vite": true,
      "npmScripts": ["npm run dev", "npm run build"]
    },
    "testing": {
      "unit": true,
      "integration": true
    },
    "authentication": {
      "features": ["OAuth (social login)", "2FA"]
    }
  },
  "readmeHints": [
    "Mention Horizon for queue monitoring",
    "Mention MailHog for email testing",
    "Mention Docker stack (PHP, MySQL, Redis, Mailhog)",
    "CI/CD via GitHub Actions planned"
  ],
  "author": {
    "name": "Axel Duquelzar",
    "website": "https://axelduquelzar.fr",
    "linkedin": "https://www.linkedin.com/in/axel-duquelzar"
  }
}
{
  "instructions": [
    "Use Laravel for the backend with a clean MVC structure.",
    "Use Tailwind CSS for styling and Blade components for the frontend.",
    "Implement authentication with Laravel Breeze or Fortify, including OAuth and 2FA.",
    "Use Redis for caching and Horizon for queue management.",
    "Use Pusher for real-time features like messaging.",
    "Set up MySQL as the database.",
    "Use Docker for development and production environments.",
    "Include MailHog for email testing in development.",
    "Write unit and integration tests using PHPUnit.",
    "Set up GitHub Actions for CI/CD workflows."
  ]
}
