# 🚗 Indrasari Car Rental Management System

A modern, full-stack vehicle rental and fleet management platform built with **Laravel 13**, **Tailwind CSS v4**, **Alpine.js**, and **Pest PHP**. Designed with strict atomic transaction safety to prevent double-booking collisions, responsive dual-theme (Light/Dark) UI, digital invoicing, and a real-time admin command center.

---

## 🌟 Key Features

### 1. 🔐 User Authentication, Profiles & Role-Based Access Control
- **Dual User Roles**: `customer` and `admin` with dedicated navigation, guards, and middleware (`AdminMiddleware`).
- **Profile Management**: Customer profile updates including driver license (**SIM A**) verification, phone numbers, and secure password changes.
- **Dual-Theme Support**: System-detected and toggleable Light & Dark mode with zero-FOUC (Flash of Unstyled Content).

### 2. 🚙 Admin Fleet Inventory & Asset Management
- **Full CRUD Management**: Create, view, update, and soft-delete fleet vehicles.
- **Image Processing**: Vehicle photo uploads (`jpeg, png, jpg, webp`) with automatic disk cleanup on replacement/deletion.
- **Fleet Metrics**: Live tracking of vehicle statuses (`available`, `rented`, `maintenance`).

### 3. 🔍 Customer Catalog Browsing & Multi-Attribute Search
- **Dynamic Search & Filters**: Filter by brand pills (Toyota, Honda, Mitsubishi, etc.), transmission, seating capacity, price sorting, and specific rental dates.
- **Smart Date Availability Scope**: Automatically excludes vehicles booked by overlapping active/upcoming rentals.
- **Interactive Vehicle Details**: Technical specifications grid, similar vehicle recommendations, and live client-side date rental estimator.

### 4. 📅 Car Booking & Collision-Free Reservation System
- **Pessimistic Row-Level Locking**: Atomic database transactions (`DB::transaction` with `Car::lockForUpdate()`) preventing date collision race conditions.
- **Pre-filled Checkout**: Seamless booking confirmation pre-populating verified driver info (SIM number) and real-time pricing breakdown.
- **Customer "My Rentals" Portal**: Multi-tab interface (All, Active, Upcoming, Completed, Cancelled) with reservation cancellation safeguards.

### 5. 🧾 Vehicle Return Processing & Digital Invoicing
- **License Plate Verification**: Customer return verification by license plate number with active rentals quick-select chips.
- **Atomic Settlement**: Automatic duration calculation with a 1-day floor (`elapsed_days * daily_rate`), vehicle state restoration, and instant invoice generation (`INV-YYYYMMDD-XXXX`).
- **Printable Receipts**: Dual-theme digital invoice with `@media print` white-background stylesheet for clean physical printing and PDF export.

### 6. 📊 Admin Command Center & Global Booking Audits
- **Real-Time KPI Cards**: Total Fleet breakdown, Active Ongoing Rentals, Registered Customer accounts, and Total Settled Paid Revenue (in IDR).
- **System-Wide Booking Management**: Filter by status (Active, Completed, Cancelled), multi-attribute keyword search, and active date filters.
- **Single Booking Audit**: Inspection view showing customer driver license (SIM A), vehicle specifications, rental duration timeline, and direct invoice link.

---

## 🛠️ Technology Stack

- **Framework:** Laravel 13 (PHP 8.2+)
- **Database:** MySQL / MariaDB (production) / SQLite (testing)
- **Frontend:** Tailwind CSS v4, Blade Templating, Alpine.js, Vite
- **Testing:** Pest PHP Testing Framework (100 Feature Tests, 406 Assertions)
- **Architecture:** Service Layer pattern (`BookingService`, `ReturnService`), Form Requests, Eloquent Query Scopes

---

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL or Docker / Podman

### Installation Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/MF-Rozi/indrasari-car-rental-task.git
   cd indrasari-car-rental-task
   ```

2. **Install PHP and Node dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run Database Migrations & Seeders:**
   ```bash
   php artisan migrate:fresh --seed
   php artisan storage:link
   ```

5. **Build Frontend Assets:**
   ```bash
   npm run build
   # or for active development:
   npm run dev
   ```

6. **Start the Local Development Server:**
   ```bash
   php artisan serve
   ```
   Access the application at `http://localhost:8000`.

---

## 🔑 Default Credentials

The database seeder automatically creates the following default accounts:

| Role | Email | Password | Access Level |
|---|---|---|---|
| **Administrator** | `admin@indrasari.test` | `password` | Admin Dashboard, Fleet Management, Booking Audits |
| **Customer** | `customer@indrasari.test` | `password` | Catalog Browsing, Checkout, My Rentals, Vehicle Returns |

---

## 🧪 Running Automated Tests

The application features a comprehensive test suite of **100 feature tests** covering authentication, fleet validation, booking collision prevention, return processing, digital invoices, and admin KPIs:

```bash
php artisan test
```

### Test Suite Overview:
```
   PASS  Tests\Feature\Admin\AdminBookingManagementTest
   PASS  Tests\Feature\Admin\AdminBookingViewRenderingTest
   PASS  Tests\Feature\Admin\CarManagementTest
   PASS  Tests\Feature\Admin\CarSchemaAndSeederTest
   PASS  Tests\Feature\Admin\CarValidationTest
   PASS  Tests\Feature\Admin\CarViewRenderingTest
   PASS  Tests\Feature\Admin\DashboardControllerTest
   PASS  Tests\Feature\Admin\DashboardViewRenderingTest
   PASS  Tests\Feature\Auth\AuthenticationTest
   PASS  Tests\Feature\Auth\AuthorizationAndRoleTest
   PASS  Tests\Feature\Auth\ProfileTest
   PASS  Tests\Feature\Auth\UserSchemaTest
   PASS  Tests\Feature\Catalog\CarDetailsEndpointTest
   PASS  Tests\Feature\Catalog\CarDetailsViewRenderingTest
   PASS  Tests\Feature\Catalog\CarSearchScopeTest
   PASS  Tests\Feature\Catalog\CatalogControllerTest
   PASS  Tests\Feature\Catalog\CatalogViewRenderingTest
   PASS  Tests\Feature\Invoices\InvoiceSchemaTest
   PASS  Tests\Feature\Invoices\InvoiceViewRenderingTest
   PASS  Tests\Feature\Invoices\ReturnControllerTest
   PASS  Tests\Feature\Invoices\ReturnServiceTest
   PASS  Tests\Feature\Invoices\ReturnViewRenderingTest
   PASS  Tests\Feature\Rentals\BookingCollisionTest
   PASS  Tests\Feature\Rentals\CheckoutViewRenderingTest
   PASS  Tests\Feature\Rentals\MyRentalsViewRenderingTest
   PASS  Tests\Feature\Rentals\RentalControllerTest
   PASS  Tests\Feature\Rentals\RentalSchemaTest

  Tests:    100 passed (406 assertions)
  Duration: 2.40s
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).
