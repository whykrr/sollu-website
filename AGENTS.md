# Sollu Website - AI Agent Guidelines

## 1. Project Context & Stack
- **Backend:** Laravel 12, PHP 8.2+ (Strict types, constructor promotion).
- **Frontend:** Vue 3 (Script Setup), Inertia.js 2.0 SPA, Tailwind CSS v4.
- **Database:** PostgreSQL (Supabase) - Skema `website`, tanpa multi-tenant scoping.
- **Domain:** Marketing Website, Landing Pages, Blog (Tiptap), Contact & Inquiry Forms.

---

## 2. Core Rules Hierarchy (`.agents/rules/`)
Before designing or modifying code, ensure compliance with the standing rules:
- `01-ux-and-wording.md`: Marketing UX, SEO-friendly Wording, Call-to-Action (CTA), Wording Standards.
- `02-modular-architecture.md`: Controller-Service-Model Architecture for Website Features.
- `03-auth-and-enums.md`: PHP Enums SSOT (`$enums`), Basic Auth for Admin Panel (if applicable).
- `04-frontend-standards.md`: Public Layout, Form Standards (Inquiry/Contact), Performance (LCP, CWV).
- `05-backend-standards.md`: PHP 8.2+ practices, thin controllers, FormRequests, standard API/web responses.
- `06-tooling-and-testing.md`: Git MCP, Feature & Unit Tests, Definition of Done.
- `07-git-and-changelog.md`: SemVer, Conventional Commits, Keep a Changelog.

---

## 3. On-Demand Domain Skills (`.agents/skills/`)
Activate the relevant specialized skill when working in specific domains:
- `sollu-website`: Core project guidelines and architecture tailored for this website.
- `laravel-best-practices`, `tailwindcss-development`, `inertia-vue-development`, `testing-best-practices`.

---

## 4. Essential Commands & Verification
- **PHP Formatter:** `vendor/bin/pint --dirty` (Run before committing PHP code).
- **Frontend Lint:** `npm run lint` & `npm run format` (jika tersedia).
- **Run Tests:** `php artisan test --compact --filter=TestName`.
- **Database Inspection:** Gunakan MCP `sollu-db` (Postgres Supabase) atau `laravel-boost` `database-schema`.
