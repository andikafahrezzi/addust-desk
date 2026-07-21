# AddustDesk

**IT Helpdesk Ticketing System** built with Laravel & Tailwind CSS — designed around real-world helpdesk workflows: claim, escalate, reassign, and SLA tracking.

<!--
  Tip: replace this with an actual screenshot once your dashboard is ready.
  ![AddustDesk Dashboard](docs/screenshot-dashboard.png)
-->

## About

AddustDesk helps teams report, handle, escalate, and monitor IT tickets with a workflow modeled after common helpdesk practices used in real companies — not just a basic CRUD ticketing app.

The app is currently a Laravel fullstack app (Blade + Controller + Eloquent). The frontend layer is decoupled enough that it could later be swapped for React/Vue without touching the core business logic.

## Features

### 👤 User
- Create & track tickets
- Reply with attachments
- Reopen a resolved ticket if the solution isn't satisfactory
- Close a ticket once verified

### 🧑‍💻 Agent
- Claim incoming tickets
- Resolve, escalate, or reassign tickets
- Reply with attachments, edit/delete own messages
- View active vs. closed ticket queues separately

### 🛠️ Admin
- Monitoring dashboard with KPIs, SLA compliance, and charts (status, priority, category, monthly trend)
- Manage master data: Users, Departments, Categories, Priorities
- Admin does not handle tickets directly — separation of concerns between operational and administrative roles

## Core Workflow

```
OPEN → IN_PROGRESS → RESOLVED → (user verifies) → CLOSED
                          │
                          └── not satisfied → REOPENED → IN_PROGRESS → ...
```

**Claim** — an incoming ticket is unowned until an agent claims it. Claiming sets `current_handler_id`, records `response_at`, and logs an `ACCEPTED` event. Response SLA is calculated from this first claim only.

**Escalate** — moves the ticket to another department and clears `current_handler_id`, so an agent in the destination department must claim it again. Response SLA is **not** recalculated; Resolution SLA keeps running.

**Reassign** — moves a ticket to another agent within the same department, with no SLA impact.

**Ticket Events** — a full audit trail (`CREATED`, `ACCEPTED`, `REASSIGNED`, `ESCALATED`, `RESOLVED`, `CLOSED`, `REOPENED`) powers the activity timeline on each ticket.

## SLA Design

- **Response SLA** — `response_at - created_at`, fixed at first claim.
- **Resolution SLA** — `resolved_at - created_at`, compared against `due_at`.
- SLA status (On Time / Breached) is **calculated in real time** from existing timestamps — no `response_status` / `resolution_status` columns are stored, keeping the schema simple and avoiding data duplication.

## Tech Stack

| Layer          | Stack                          |
|----------------|---------------------------------|
| Backend        | Laravel, Eloquent ORM, MySQL    |
| Frontend       | Blade, Tailwind CSS             |
| Charts         | Chart.js                        |
| Auth           | Laravel Breeze                  |

## Design System

The UI follows a small, consistent design system rather than ad-hoc styling per page:

- Reusable Blade components: `<x-icon>`, `<x-field>`, `<x-nav-link>`, `<x-status-badge>`
- Centralized color tokens (`accent`, `canvas`, `border`, `status.*`) defined in `tailwind.config.js`
- Shared layout shell (`layouts/app.blade.php` + `layouts/sidebar.blade.php`) with role-aware navigation and active-state highlighting
- Consistent card-table pattern across all list views (Tickets, Users, Departments, Categories, Priorities)

## Getting Started

```bash
# Clone the repository
git clone https://github.com/andikafahrezzi/addustdesk.git
cd addustdesk

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure your database in .env, then:
php artisan migrate --seed

# Build frontend assets
npm run dev

# Serve the app
php artisan serve
```

## Roles & Access

| Role  | Access                                                                 |
|-------|-------------------------------------------------------------------------|
| User  | Create tickets, reply, reopen, close                                   |
| Agent | Claim, resolve, escalate, reassign tickets within their department     |
| Admin | Dashboard monitoring, master data management (no direct ticket work)   |

## Roadmap

- [ ] Read-only view for `CLOSED` tickets
- [ ] Finish remaining Tailwind styling pass
- [ ] Knowledge Base module (articles, categories, tags, search, publish/draft, linked to related tickets)
- [ ] Convert resolved tickets into Knowledge Base articles

## License

This project is open-sourced for portfolio and learning purposes.

## Author

**Andika Fahrezzi**
GitHub: [@andikafahrezzi](https://github.com/andikafahrezzi)