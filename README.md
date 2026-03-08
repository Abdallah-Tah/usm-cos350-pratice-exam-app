# USM COS 350 Practice Exam App

A Laravel study app for COS 350 Systems Programming. It provides randomized exam practice based on the local lecture materials and a seeded question pool covering Unix commands, C programming, file I/O, strings, permissions, buffering, function pointers, dynamic memory, directories, devices, and signals.

## Features

- `Comprehensive Review` mode builds a randomized 50-question attempt from the full pool.
- `Realistic Mock Exam` mode builds a randomized 20-question attempt using a lecture-weighted mix intended to feel closer to an actual exam.
- Automatic grading with per-question explanations and attempt-order review.
- Seeded local question bank with `74` multiple-choice questions in `database/seeders/questions_data.json`.
- Dashboard entry points for the exam modes.
- Separate code practice pages exposed under `/practice`.
- Local lecture exports stored in `lectures/` and used as the reference source for topic coverage.

## Stack

- Laravel
- Blade views
- SQLite for local development
- Vite for frontend assets

## Routes

- `/exam` for the main exam experience
- `/exam?mode=comprehensive` for the full 50-question review
- `/exam?mode=realistic` for the 20-question realistic mock exam
- `/practice` for code practice listings

## Local Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan db:seed
npm run dev
php artisan serve
```

If your local `.env` already exists, do not overwrite it. The app expects the database to be available and the questions table to be seeded before using the exam pages.

## Seeding

The question bank is loaded by [QuestionSeeder](./database/seeders/QuestionSeeder.php), which reads from `database/seeders/questions_data.json`.

Useful commands:

```bash
php artisan db:seed --class=QuestionSeeder
php artisan migrate --seed
```

## Testing

```bash
php artisan test
```

The feature tests cover randomized attempt generation and realistic-mode grading behavior.

## Notes

- Generated and local-only files such as `vendor/`, `node_modules/`, `.env`, `public/hot`, caches, and the archived `.git.backup-*` directory are ignored by `.gitignore`.
- The exam attempt order is stored in session so grading matches the exact questions shown to the student.
