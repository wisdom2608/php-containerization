**DISCLAIMER !!!!**



*environment variables:* This is for dev purpose. Do not provide your secrete variables anywhere as plaintext in any repository.

For a containerized PHP application, a good .dockerignore should exclude dependencies, Git files, local configuration, logs, IDE files, and other files that don’t need to be copied into the Docker build context.

You can use this:

`.dockerignore`
```bash
# Git
.git
.gitignore
.gitattributes

# Environment / secrets
.env
.env.*
!.env.example

# Dependencies
vendor/
node_modules/

# Logs
*.log
logs/
log/

# Cache / temporary files
tmp/
temp/
cache/
*.tmp
*.temp

# PHPUnit / testing
.phpunit.result.cache
.phpunit.cache/
coverage/
tests/

# IDE / editors
.vscode/
.idea/
*.swp
*.swo

# OS files
.DS_Store
Thumbs.db

# Documentation
README.md
README
docs/

# Docker files
Dockerfile*
docker-compose*.yml
.dockerignore

# CI/CD
.github/
.gitlab-ci.yml
Jenkinsfile

# Local development
docker/
*.local

# PHP configuration generated locally
php.ini

# Backup files
*.bak
*.backup
*~
```

Important note

If your application needs tests/ during the Docker build, don’t exclude it. Similarly, if you’re using Composer and want to run composer install inside the image, you can keep composer.json and composer.lock—the vendor/ directory should normally be excluded because it can be installed during the image build.

For example, a typical PHP project might look like:

```plaintext
my-php-app/
├── Dockerfile
├── .dockerignore
├── composer.json
├── composer.lock
├── public/
│   └── index.php
├── src/
├── config/
└── vendor/        # ignored; installed during Docker build
```
For a containerized PHP application, this .gitignore is a good production-friendly starting point:


`.gitignore`
```bash
# ==========================================
# PHP / Composer
# ==========================================

/vendor/
composer.phar

# Composer cache
.phpunit.cache/
.phpunit.result.cache

# ==========================================
# Environment & Secrets
# ==========================================

.env
.env.local
.env.*.local

# Keep an example configuration
!.env.example

# ==========================================
# Logs
# ==========================================

*.log
/logs/
/storage/logs/

# ==========================================
# Cache / Temporary Files
# ==========================================

/cache/
/tmp/
/temp/
/storage/cache/
/bootstrap/cache/*

# ==========================================
# Testing / Coverage
# ==========================================

/coverage/
/.phpunit.cache/
clover.xml
coverage.xml

# ==========================================
# IDE / Editors
# ==========================================

.vscode/
.idea/
*.swp
*.swo
*.swn
*~

# ==========================================
# Operating System
# ==========================================

.DS_Store
.DS_Store?
._*
.Spotlight-V100
.Trashes
Thumbs.db
Desktop.ini

# ==========================================
# Docker
# ==========================================

# Local Docker environment files
docker-compose.override.yml
docker-compose.local.yml

# Docker volumes
/docker-volumes/

# ==========================================
# Node.js / Frontend
# ==========================================

/node_modules/
/npm-debug.log*
/yarn-debug.log*
/yarn-error.log*
/pnpm-debug.log*

# Build output
/dist/
/build/

# ==========================================
# Application Generated Files
# ==========================================

/uploads/
/storage/uploads/

# ==========================================
# Backup Files
# ==========================================

*.bak
*.backup
*.old
*.orig

# ==========================================
# Local Database Files
# ==========================================

*.sqlite
*.sqlite3
*.db

# ==========================================
# CI/CD Local Files
# ==========================================

/.trivy/
/scan-results/
trivy-report.*
```
A few important points

Do not put these in `.gitignore`:

```bash
Dockerfile
docker-compose.yml
nginx.conf
composer.json
composer.lock
.github/
```

These are normally part of your source code and should be committed to Git.

Also, never commit .env if it contains passwords, database credentials, API keys, or other secrets. Commit an .env.example containing only placeholder values.

For example:

`.env`
```bash
APP_ENV=production
DB_HOST=localhost
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
For GitHub Actions + Docker + Trivy + Kubernetes setup, we would also recommend keeping .gitignore and .dockerignore separate: .gitignore controls what goes into Git, while .dockerignore controls what gets sent to the Docker build context.
