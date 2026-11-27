
# OLX Marketplace - Laravel 12

An OLX-inspired online marketplace application built using Laravel 12, PHP, MySQL, Bootstrap, and JavaScript.

The application allows users to register, log in, publish product or service listings, browse available listings, search and filter products, and manage their own advertisements.

## Project Overview

The main objective of this project is to develop an online classified marketplace where users can post products or services and other users can explore listings based on category, location, and price.

The application follows Laravel MVC architecture and uses Eloquent ORM for database operations and relationships.

## Features

### 1. User Authentication
- User registration and login.
- Secure password hashing.
- Session-based authentication.
- Logout functionality.
- Protected routes for authenticated users.

### 2. Listing Management
- Create product and service listings.
- Add listing name and description.
- Select category and subcategory.
- Select country, state, city, and area.
- Add product or service price.
- Automatically generate unique listing slugs.
- View individual listing details.

### 3. Dynamic Location Dropdowns
- Country-based state selection.
- State-based city selection.
- City-based area selection.
- Category-based subcategory selection.
- Dynamic data loading using JavaScript Fetch API.
- Laravel endpoints return JSON responses.

### 4. Homepage and Listings
- Display latest active listings.
- Display product and service information.
- Show category and location details.
- View complete listing details.
- Display related listings.

### 5. Search and Filters
- Search listings by name.
- Search listings by description.
- Filter by category.
- Filter by city.
- Filter by minimum price.
- Filter by maximum price.
- Combine multiple filters.
- Clear search filters.
- Pagination support.

### 6. My Listings
- View logged-in user's listings.
- Edit existing listings.
- Delete listings.
- Change listing status.
- Manage Active, Inactive, and Sold listings.
- Ownership verification before updating or deleting records.

### 7. Validation and Security
- Laravel Form Request validation.
- Server-side input validation.
- Authentication middleware.
- CSRF protection.
- Secure password hashing.
- User ownership authorization.
- Validation of category and location relationships.

## Technology Stack

| Technology | Purpose |
|---|---|
| PHP | Backend programming |
| Laravel 12 | Backend framework |
| MySQL | Database |
| HTML5 | Page structure |
| CSS3 | Styling |
| Bootstrap 5 | Responsive UI |
| JavaScript | Frontend interactions |
| Fetch API | Dynamic dropdowns |
| Eloquent ORM | Database relationships |

## Application Architecture

The project follows the MVC (Model-View-Controller) architecture.

```text
olx-marketplace/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── ListingController.php
│   │   │   ├── LocationController.php
│   │   │   └── CommonController.php
│   │   │
│   │   └── Requests/
│   │       ├── StoreListingRequest.php
│   │       └── UpdateListingRequest.php
│   │
│   └── Models/
│       ├── User.php
│       ├── Listing.php
│       ├── Category.php
│       ├── Subcategory.php
│       ├── Country.php
│       ├── State.php
│       ├── City.php
│       └── Area.php
│
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── CategorySeeder.php
│       ├── LocationSeeder.php
│       └── DatabaseSeeder.php
│
├── resources/
│   └── views/
│       ├── auth/
│       ├── common/
│       ├── layouts/
│       ├── listings/
│       └── home.blade.php
│
├── routes/
│   └── web.php
│
└── README.md
```

## Database Structure

The application uses MySQL with the following main tables:

| Table | Description |
|---|---|
| users | Stores registered user information |
| categories | Stores main categories |
| subcategories | Stores category-wise subcategories |
| countries | Stores country information |
| states | Stores states |
| cities | Stores cities |
| areas | Stores city-wise areas |
| listings | Stores product and service advertisements |

### Database Relationships

- User has many Listings.
- Category has many Subcategories.
- Category has many Listings.
- Subcategory belongs to Category.
- Country has many States and Cities.
- State belongs to Country and has many Cities.
- City belongs to Country and State and has many Areas.
- Area belongs to City.
- Listing belongs to User, Category, Subcategory, and Location.

## Installation and Setup

### Prerequisites

Make sure the following are installed:

- PHP 8.2 or higher
- Composer
- MySQL
- Laravel 12 compatible PHP extensions
- Web browser

### Step 1: Clone the Repository

```bash
git clone https://github.com/madhu97singh/olx-marketplace.git

cd olx-marketplace
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Configure Environment

Copy the environment file:

```bash
cp .env.example .env
```

For Windows:

```bash
copy .env.example .env
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Create Database

Create a MySQL database:

```sql
CREATE DATABASE olx_marketplace;
```

### Step 6: Configure Database

Update the database configuration in the `.env` file:

```env
APP_NAME="OLX Marketplace"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=olx_marketplace
DB_USERNAME=root
DB_PASSWORD=
```

Update the database username and password according to your local MySQL configuration.

### Step 7: Run Migrations

```bash
php artisan migrate
```

### Step 8: Seed Database

Insert default categories and location data:

```bash
php artisan db:seed
```

### Step 9: Clear Application Cache

```bash
php artisan optimize:clear
```

### Step 10: Start Development Server

```bash
php artisan serve
```

Open the application:

http://127.0.0.1:8000

## Application Routes

| URL | Description | Access |
|---|---|---|
| `/` | Homepage | Public |
| `/register` | User registration | Guest |
| `/login` | User login | Guest |
| `/listings` | Browse listings | Public |
| `/listing/{slug}` | Listing details | Public |
| `/listings/create` | Create listing | Authenticated |
| `/my-listings` | Manage own listings | Authenticated |
| `/my-listings/{id}/edit` | Edit listing | Owner |
| `/get-subcategories` | Fetch subcategories | Authenticated |
| `/get-states` | Fetch states | Authenticated |
| `/get-cities` | Fetch cities | Authenticated |
| `/get-areas` | Fetch areas | Authenticated |

## Listing Status

Every listing supports three statuses:

| Status | Description |
|---|---|
| Active | Listing is visible on the public website |
| Inactive | Listing is hidden from public listings |
| Sold | Product has been sold and is hidden from public listings |

## Search Examples

Users can combine different filters to find listings.

Example:

```text
Search: iPhone
Category: Mobiles
City: Bangalore
Minimum Price: 10000
Maximum Price: 50000
```

The application returns active listings matching the selected filters.

## Key Technical Implementations

- Laravel MVC architecture.
- Eloquent ORM and relational database design.
- One-to-many and many-to-one relationships.
- Form Request validation.
- Route model binding using listing slug.
- Authentication and authorization.
- Dynamic dependent dropdowns using Fetch API.
- Conditional database queries.
- Pagination with query string preservation.
- Secure CRUD operations.
- User-level listing ownership verification.

## Future Enhancements

The following features can be added in future versions:

- Multiple product image uploads.
- Product image gallery.
- Wishlist and favorite listings.
- Buyer and seller messaging system.
- Advanced location-based search.
- Sorting by price and latest listings.
- Admin dashboard.
- Category and location SEO pages.
- Email notifications.
- Listing approval and moderation.
- REST API integration.
- Automated feature and unit testing.

## Author

**Madhu Singh**

Backend Developer | PHP | Laravel | MySQL

---

## License

This project is developed for learning, portfolio, and demonstration purposes.
