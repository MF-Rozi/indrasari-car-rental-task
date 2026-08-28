# Design System

## Visual Identity & Theme Architecture

Indrasari Car Rental utilizes a clean, high-contrast, dual-theme design system built with Tailwind CSS v4 and Blade templates. The design system is directly extracted from and connected to the project's source design export files:
- **Light Theme Source:** [`documentations/design-export-light.html`](file:///home/mfrozi/Code/Website/php/indrasari-car-rental-task/documentations/design-export-light.html)
- **Dark Theme Source:** [`documentations/design-export-dark.html`](file:///home/mfrozi/Code/Website/php/indrasari-car-rental-task/documentations/design-export-dark.html)

---

## 0. Design Export Screen-to-Blade Mapping Matrix

| # | Screen / Feature in HTML Exports | Light & Dark Source Section | Target Blade Template |
|---|---|---|---|
| 1 | **Customer Navigation & Shell** | Top Navbar & Footer | `resources/views/layouts/app.blade.php`<br>`resources/views/components/navbar.blade.php` |
| 2 | **Admin Dashboard & Shell** | Admin Sidebar & KPI Header | `resources/views/layouts/admin.blade.php`<br>`resources/views/admin/dashboard.blade.php` |
| 3 | **Authentication & Registration** | User Management & Register Card | `resources/views/auth/register.blade.php`<br>`resources/views/auth/login.blade.php` |
| 4 | **Customer Profile** | My Profile View | `resources/views/profile/show.blade.php` |
| 5 | **Customer Catalog & Search** | Catalog Grid, Filters & Search Hero | `resources/views/catalog/index.blade.php` |
| 6 | **Vehicle Details** | Vehicle Specification & Sticky CTA | `resources/views/catalog/show.blade.php` |
| 7 | **Booking & Checkout** | Secure Checkout Modal / Page | `resources/views/rentals/checkout.blade.php` |
| 8 | **Customer Rentals Portal** | My Rentals Status Tabs & Cards | `resources/views/rentals/my-rentals.blade.php` |
| 9 | **Car Return by Plate** | Return Lookup & Cost Confirmation | `resources/views/rentals/return.blade.php` |
| 10 | **Digital Invoice & Receipt** | Invoice Summary & Print Sheet | `resources/views/invoices/show.blade.php` |
| 11 | **Admin Fleet Management** | Fleet Table & Add/Edit Car Modals | `resources/views/admin/cars/index.blade.php` |
| 12 | **Admin Booking Management** | System-Wide Bookings Table | `resources/views/admin/bookings/index.blade.php` |

---

## 1. Color Palette & Dual-Theme Tokens

### Light Mode (`html:not(.dark)`)
- **App Background:** `#F8FAFC` (Tailwind `slate-50`)
- **Card / Surface Background:** `#FFFFFF` (Tailwind `white`)
- **Surface Border:** `#E2E8F0` (Tailwind `slate-200`)
- **Primary Text (High Contrast):** `#0F172A` (Tailwind `slate-900`, Contrast > 12:1)
- **Secondary / Muted Text:** `#64748B` (Tailwind `slate-500`)
- **Input Background:** `#F8FAFC` (Tailwind `slate-50`)
- **Input Border:** `#CBD5E1` (Tailwind `slate-300`)

### Dark Mode (`html.dark`)
- **App Background:** `#0B0F19` / `#0F172A` (Deep navy-slate)
- **Card / Surface Background:** `#1E293B` (Tailwind `slate-800`)
- **Surface Border:** `#334155` (Tailwind `slate-700`)
- **Primary Text (High Contrast):** `#F8FAFC` (Tailwind `slate-50`, Contrast > 14:1)
- **Secondary / Muted Text:** `#94A3B8` (Tailwind `slate-400`)
- **Input Background:** `#0F172A` (Tailwind `slate-900`)
- **Input Border:** `#334155` (Tailwind `slate-700`)

### Brand & Status Accents
- **Primary Brand Action:** `bg-blue-600 hover:bg-blue-700 text-white` (Dark mode accent: `text-blue-400`)
- **Available / Active Status:** Emerald (`bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800`)
- **Upcoming Status:** Sky (`bg-sky-100 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 border-sky-200 dark:border-sky-800`)
- **Completed Status:** Slate (`bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700`)
- **Cancelled / Error Status:** Rose (`bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 border-rose-200 dark:border-rose-800`)
- **Maintenance Status:** Amber (`bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-800`)

---

## 2. Typography Hierarchy

- **Font Family:** Modern Sans-Serif system font stack (`Inter`, `system-ui`, `-apple-system`, `sans-serif`)
- **Display Headings (H1):** `text-2xl md:text-3xl font-bold tracking-tight text-slate-900 dark:text-white`
- **Section Headings (H2):** `text-xl md:text-2xl font-semibold text-slate-900 dark:text-white`
- **Card Titles (H3):** `text-lg font-semibold text-slate-900 dark:text-white`
- **Body Text:** `text-sm md:text-base text-slate-600 dark:text-slate-300 leading-relaxed max-w-prose`
- **Microcopy & Meta Badges:** `text-xs font-medium text-slate-500 dark:text-slate-400`
- **Price Display:** `text-lg md:text-xl font-bold text-blue-600 dark:text-blue-400`

---

## 3. Layouts & Navigation

### Customer Layout (`resources/views/layouts/app.blade.php`)
- **Header Navigation:** Sticky top navbar with glass backdrop-blur (`bg-white/90 dark:bg-[#0F172A]/90 backdrop-blur border-b border-slate-200 dark:border-slate-800`).
- **Brand Logo:** Car icon + "Indrasari Car Rental" text.
- **Nav Links:** Catalog, My Rentals, Return Car.
- **Action Group:**
  - Dark/Light mode toggle button (Sun/Moon icon).
  - User profile avatar dropdown (My Profile, My Rentals, Logout) or Guest Login/Register pills.
- **Mobile Navigation:** Responsive collapsible hamburger drawer for viewports under `768px`.

### Admin Layout (`resources/views/layouts/admin.blade.php`)
- **Sidebar Navigation:** Fixed left sidebar on desktop (`w-64 bg-white dark:bg-[#111827] border-r border-slate-200 dark:border-slate-800`).
- **Sidebar Links:** Dashboard Overview, Fleet Management, Booking Management, Return Audit, Back to Customer View.
- **Top Header:** Breadcrumb navigation, current date/time, Admin profile badge, Theme switcher.

---

## 4. UI Components & Craft Standards

### Form Controls & Inputs
- Rounded corners capped at `rounded-lg` (`8px`) or `rounded-xl` (`12px`) — no over-rounded 32px bubbles.
- Clear focus rings: `focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent`.
- Distinct field validation errors with red message text (`text-rose-600 dark:text-rose-400 text-xs mt-1`).

### Card Affordances
- Cards use clean 1px borders (`border border-slate-200 dark:border-slate-800`) paired with subtle elevation (`shadow-sm hover:shadow-md transition-shadow`).
- Avoid "ghost cards" (never pair deep 16px+ drop shadows with 1px borders).

### Modals & Dialogs
- Backdrop overlay: `bg-slate-900/60 backdrop-blur-sm fixed inset-0 z-50 flex items-center justify-center p-4`.
- Dialog container: `bg-white dark:bg-[#1E293B] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-2xl max-w-lg w-full p-6`.

### Digital Invoice & Print View
- Screen representation: Styled in dual-theme container with detailed cost breakdown and metadata.
- Print stylesheet: `@media print` forces pure white background, solid black text, and hides navigation headers and buttons for clean PDF generation.

---

## 5. Motion & Micro-Interactions

- Subtle transition durations: `transition-all duration-200 ease-out`.
- Card hover states: slight border highlight and `shadow-md`.
- Reduced Motion: All transitions disabled automatically when `@media (prefers-reduced-motion: reduce)` is detected.
