<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Got you, Jinrox! 🚀 A **README.md** is the heart of your project on GitHub — it should introduce, explain, and guide users/developers.

Here’s a **ready-to-use README** for your **Guide Touristique Local Planificateur de Voyages** project 👇

---

# 🌍 Local Tourism Guide & Travel Planner

## 📌 Description

**Local Tourism Guide & Travel Planner** is a web application that helps users discover local destinations, explore events, check weather forecasts, and organize their trips. Users can create and save itineraries, mark destinations as favorites, and share their travel plans. Admins manage destinations, events, and user-generated content to keep the platform updated and reliable.

---

## 🛠️ Tech Stack

* **Backend:** Laravel (PHP Framework)
* **Frontend:** Blade (Laravel Templating), TailwindCSS, JavaScript
* **Database:** MySQL / PostgreSQL with Eloquent ORM
* **Authentication:** Laravel Breeze / Jetstream / Sanctum
* **APIs:**

  * Google Maps API (location & maps)
  * OpenWeatherMap API (weather forecasts)
* **Tools:** Git, GitHub, JIRA, Composer, Artisan CLI
* **Optional:** Docker for deployment

---

## 📂 Features

✅ Browse destinations & view details
✅ Search & filter by category or location
✅ Explore local events linked to destinations
✅ Check weather forecasts before planning trips
✅ Create, save & share itineraries
✅ Mark destinations as favorites
✅ Leave reviews & ratings
✅ Admin dashboard for content management

---

## 🏗️ Database Design

* **Users** (with roles: Admin, User)
* **Roles** (managing user roles separately)
* **Profiles** (user additional info)
* **Destinations** (tourist attractions, hotels, restaurants, etc.)
* **Events** (linked to destinations)
* **Reviews** (user ratings & comments)
* **Favorites** (saved destinations)
* **Itineraries** (user travel plans, with many-to-many relation to destinations)

---

## 🚀 Installation & Setup

1. **Clone the repo**

```bash
git clone https://github.com/your-username/local-tourism-guide.git
cd local-tourism-guide
```

2. **Install dependencies**

```bash
composer install
npm install && npm run dev
```

3. **Configure .env**
   Update your database and API keys in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=travel_planner
DB_USERNAME=root
DB_PASSWORD=

GOOGLE_MAPS_API_KEY=your_key
OPENWEATHER_API_KEY=your_key
```

4. **Run migrations & seeders**

```bash
php artisan migrate --seed
```

5. **Start local server**

```bash
php artisan serve
```

---

## 👨‍💻 Usage

* Visit `http://127.0.0.1:8000/` in your browser.
* Register/Login as a user to access trip planning and favorites.
* Use the admin account to manage destinations and events.

---
