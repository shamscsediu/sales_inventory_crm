# Sales, Inventory & CRM System

A comprehensive Sales, Inventory, and Customer Relationship Management (CRM) system built for the SinodTech Technical Assessment. This application manages products, customers, multi-branch inventory, and sales — with automated emailing, event-driven KPI tracking, and a REST API.

---

## ✅ Completed Features

### Core Modules
- **Product Management** — Full CRUD with SKU (unique), price, and stock quantity tracking
- **Customer Management** — Full CRUD with email, phone, and employee assignment
- **Sales Management** — Create sales with multiple line items; total amount auto-calculated

### Inventory & Stock Control
- **Stock Deduction** — Automatically deducts stock (branch-level and global) on every sale using database transactions with pessimistic locking to prevent race conditions
- **Oversell Prevention** — Throws a user-friendly error if a branch or global stock is insufficient before completing a sale

### CRM
- **Lost Customer Detection** — Customers inactive beyond a configurable threshold (default: 90 days) are automatically flagged with a **Lost** badge in the UI
- **Employee Assignment** — Customers can be assigned to a specific employee
- **Customer Recovery Tracking** — When a lost customer makes a new purchase, a `CustomerRecovered` event fires automatically

### Events & KPI
- **`CustomerRecovered` Event** — Fires when a previously "lost" customer completes a new sale
- **`IncrementEmployeeKPI` Listener** — Automatically increments the assigned employee's `kpi_score` when their lost customer is recovered

### Email (via Mailtrap)
- **Invoice Email** — Automatically sent to the customer upon every successful sale, containing an itemized product list and grand total
- **Promotion Emails** — Bulk promotional emails can be sent to lost or all customers via an Artisan command

### REST API
- `GET /api/products` — List all products
- `GET /api/customers` — List all customers with their assigned employee
- `GET /api/sales/{id}` — Retrieve a specific sale with full nested details

### Bonus Feature: Multi-Branch Support ⭐
- **Branch Management** — Full CRUD for store locations
- **Branch-Specific Inventory** — Each branch maintains its own per-product stock
- **Sales tied to Branches** — Every sale is recorded against a specific branch
- **Inventory Management UI** — Dedicated screen to view and update stock at each branch

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 |
| Language | PHP 8.3+ |
| Database | MySQL |
| Frontend | Blade + Bootstrap 5 |
| Email | Mailtrap SMTP |
| API Auth | Laravel Sanctum |

---

## ⚙️ Setup Instructions

### Prerequisites
- PHP 8.3+
- Composer
- MySQL
- A [Mailtrap](https://mailtrap.io) account (for email testing)

---

### 1. Clone the Repository

```bash
git clone <your-repo-url> sales_inventory_crm
cd sales_inventory_crm
```

---

### 2. Install Dependencies

```bash
composer install
```

---

### 3. Environment Configuration

Copy the example environment file and open it for editing:

```bash
cp .env.example .env
```

Update the following values in your `.env` file:

```env
APP_NAME="Sales & Inventory CRM"
APP_URL=http://127.0.0.1:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sales_inventory_crm
DB_USERNAME=root
DB_PASSWORD=your_password

# Mailtrap SMTP (get credentials from mailtrap.io)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=d857492fd0e5f4
MAIL_PASSWORD=fb4d508bcb64bf
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@salescrm.com"
MAIL_FROM_NAME="${APP_NAME}"

# CRM Configuration (optional)
LOST_CUSTOMER_INACTIVITY_DAYS=90
```

---

### 4. Generate Application Key

```bash
php artisan key:generate
```

---

### 5. Create the Database

Log into MySQL and create the database:

```sql
CREATE DATABASE sales_inventory_crm;
```

---

### 6. Run Database Migrations

```bash
php artisan migrate
```

---

### 7. Seed the Database

Populate the database with sample data (products, customers, employees, branches, and sales):

```bash
php artisan db:seed
```

Or to do a fresh migration and seed in one command:

```bash
php artisan migrate:fresh --seed
```

This seeds:
- 1 Branch
- 20 Products (with branch inventory)
- 10 Employees
- 50 Customers (some assigned to employees)
- 200 Sales with sale items

---

### 8. Run the Application Locally

```bash
php artisan serve
```

The application will be available at: **http://127.0.0.1:8000**

---

## 📧 Sending Promotion Emails

To send promotional emails to **lost customers only**:

```bash
php artisan crm:send-promotions --lost
```

To send to **all customers**:

```bash
php artisan crm:send-promotions --all
```

> Make sure your Mailtrap credentials are configured in `.env` before running these commands.

---

## 🔗 Navigation

| URL | Description |
|---|---|
| `/products` | Product management |
| `/customers` | Customer management |
| `/sales` | Sales list & creation |
| `/branches` | Branch & inventory management |
| `/api/products` | REST API – products |
| `/api/customers` | REST API – customers |
| `/api/sales/{id}` | REST API – sale detail |

---

## 📁 Project Structure (Key Files)

```
app/
├── Console/Commands/SendPromotionsCommand.php
├── Events/CustomerRecovered.php
├── Http/
│   ├── Controllers/
│   │   ├── BranchController.php
│   │   ├── CustomerController.php
│   │   ├── ProductController.php
│   │   └── SaleController.php
│   └── Requests/
├── Listeners/IncrementEmployeeKPI.php
├── Mail/
│   ├── InvoiceEmail.php
│   └── PromotionEmail.php
├── Models/
│   ├── Branch.php, BranchInventory.php
│   ├── Customer.php, Employee.php
│   ├── Product.php, Sale.php, SaleItem.php
└── Services/
    ├── CustomerService.php
    ├── ProductService.php
    └── SaleService.php
config/
└── crm.php          ← Lost customer inactivity days
resources/views/
├── branches/        ← Branch & inventory UI
├── customers/       ← Customer CRUD UI
├── emails/          ← Invoice & promotion email templates
├── layouts/app.blade.php
├── products/        ← Product CRUD UI
└── sales/           ← Sales UI
routes/
├── api.php          ← REST API routes
└── web.php          ← Web routes
```

---

## 🧪 Key Business Rules

1. **Stock Deduction** runs inside a `DB::transaction` with `lockForUpdate()` to prevent overselling under concurrent requests.
2. **Lost Customer** is determined by `last_purchase_date` being older than `LOST_CUSTOMER_INACTIVITY_DAYS` (default: 90 days).
3. **`last_purchase_date`** is automatically updated on the customer record whenever a new sale is completed.
4. **KPI Score** on an employee is automatically incremented when their assigned lost customer makes a new purchase.
5. **Invoice emails** are dispatched automatically after every successful sale transaction.
