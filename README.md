
# Estia - Accommodation Booking Platform

Estia is a full-stack accommodation booking platform built with Laravel, designed to offer a seamless reservation experience for both guests and hosts. It features interactive Leaflet.js mapping, secure role-based authorization policies, dynamic review systems, and comprehensive listing and booking state management.

---

## Features

### For Guests

- **Explore Accommodations:** Browse available listings with pagination and interactive Leaflet.js maps.
- **Search & Filter:** Find places quickly by name, location, and price.
- **Favorites System:** Toggle and save your favorite listings to a personal collection.
- **Booking Management:** Request dates, track reservation statuses, and manage active stays.
- **Review System:** Leave ratings and comments on listings only after successfully completing a stay.

### For Hosts

- **Listing Management:** Create, edit, and delete property listings with multi-photo support, cover images, and precise GPS coordinates.
- **Owner Dashboard:** Review incoming reservation requests, approve or reject bookings with a single click, and oversee property performance.
- **Role-Based Authorization:** Secure endpoints and actions guarded by Laravel Policies.

---

## Tech Stack

- **Backend:** PHP, Laravel (MVC, Resource Controllers, Form Requests, Policies)
- **Frontend:** Blade Templates, HTML5/CSS3, JavaScript
- **Database:** MySQL / Eloquent ORM
- **Maps & UI Integration:** Leaflet.js (OpenStreetMap)

---

## Getting Started

### Prerequisites

Before installing the project, make sure you have the following installed:

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL

---

### Installation

#### 1. Clone the repository

```bash
git clone https://github.com/charalamposmakridis/Estia.git
cd Estia
```

#### 2. Install PHP dependencies

```bash
composer install
```

#### 3. Install frontend dependencies and build assets

```bash
npm install
npm run dev
```

#### 4. Configure your environment file

Copy the example environment file:

```bash
cp .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

#### 5. Configure the database

Update your database credentials in the `.env` file.

Then run the migrations and seeders:

```bash
php artisan migrate --seed
```

#### 6. Link the storage directory

Create the symbolic link required for image uploads:

```bash
php artisan storage:link
```

#### 7. Run the local development server

```bash
php artisan serve
```

The application should now be available at:

```text
http://127.0.0.1:8000
```

---

## Project Structure & Highlights

### Routing

**`routes/web.php`**

Clean separation of:

- Guest browsing
- Authenticated actions
- Nested resource booking routes
- Dedicated owner dashboards

### Policies

**`app/Policies/`**

Strict authorization logic ensuring that users can:

- Modify only their own listings
- Manage relevant bookings
- Review properties only after completing a stay

### Validation

The application uses robust **FormRequest** classes for:

- Date-time preparation
- Pricing rules
- File uploads
- Input validation

---

## Core Functionality

The platform provides a complete accommodation booking workflow:

```text
Guest
  │
  ├── Browse Listings
  │
  ├── Search & Filter
  │
  ├── View Accommodation
  │
  ├── Add to Favorites
  │
  ├── Request Booking
  │
  └── Complete Stay
          │
          └── Leave Review


Host
  │
  ├── Create Listing
  ├── Upload Photos
  ├── Set Cover Image
  ├── Set GPS Coordinates
  ├── View Booking Requests
  ├── Approve / Reject Booking
  └── Monitor Property Performance
```

---

## Security & Authorization

Estia uses Laravel Policies and authentication mechanisms to ensure that sensitive operations are properly protected.

Authorization is applied to actions such as:

- Creating and managing listings
- Editing or deleting properties
- Managing reservations
- Approving or rejecting booking requests
- Creating reviews
- Accessing owner-specific dashboards

This ensures that users can only perform actions they are authorized to perform.

---

## Maps & Location

Estia integrates **Leaflet.js** with **OpenStreetMap** to provide interactive maps.

Hosts can define precise GPS coordinates for their properties, while guests can explore accommodation locations directly through the map interface.

---

## Booking & Reservation States

Bookings follow a controlled state-management workflow.

A typical reservation lifecycle is:

```text
Pending
   │
   ├── Approved ──> Active Stay ──> Completed
   │
   └── Rejected
```

Only successfully completed stays allow guests to submit reviews.

---

## Reviews

The review system allows guests to rate and comment on accommodations after successfully completing a stay.

This prevents users from reviewing properties they have not actually stayed at.

---

## Image Management

Hosts can manage multiple images for their listings, including:

- Multiple property photos
- Cover image
- Uploaded listing images
- Storage-managed files

Laravel's storage system is used to handle uploaded property images.
