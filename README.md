# Horizen 🎥

**Horizen** is a full-stack video-sharing platform built with Laravel. It allows users to upload, view, like, and comment on videos. Admins and creators can manage content, while viewers can enjoy a rich media experience. JWT-based authentication, role management, and a structured database make it robust and extensible.

---

## 🚀 Features

* Video uploading, categorization, and tagging
* User authentication via JWT
* Comments and nested replies
* Likes and watch history tracking
* User profiles with extended info
* Playlists and video collections
* Admin and creator roles
* FFmpeg support for video processing

---

## 🛠 Tech Stack

* **Backend:** Laravel (PHP)
* **Frontend:** Blade, Tailwind CSS, JavaScript
* **Database:** PostgreSQL
* **Auth:** JWT (custom implementation)
* **Dev Tools:** Docker, Xdebug, FFmpeg, Aspell

---

## ⚙️ Setup Instructions

### 🔁 Option 1: Docker-Based Setup (Recommended)

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/horizen.git
   cd horizen
   ```

2. Build and start Docker containers:

   ```bash
   docker-compose up -d --build
   ```

3. Install PHP and JS dependencies:

   ```bash
   docker exec app composer install
   docker exec app npm install && npm run dev
   ```

4. Set up environment:

   ```bash
   cp .env.example .env
   docker exec app php artisan key:generate
   docker exec app php artisan migrate --seed
   ```

5. Done! Access the app at `http://localhost`.

### 💻 Option 2: Manual Local Setup (Without Docker)

1. Make sure you have the following installed:

   * PHP >= 8.1
   * Composer
   * aspell
   * PostgreSQL
   * Node.js & npm
   * FFmpeg

2. Clone the repo:

   ```bash
   git clone https://github.com/your-username/horizen.git
   cd horizen
   ```

3. Install dependencies:

   ```bash
   composer install
   npm install && npm run dev
   ```

4. Create `.env` file:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure your `.env` database section:

   ```dotenv
    DB_CONNECTION=pgsql
    DB_HOST=localhost
    DB_PORT=5432
    DB_DATABASE=horizen
    DB_USERNAME=postgres
    DB_PASSWORD=postgres
   ```

6. Run migrations:

   ```bash
   php artisan migrate
   ```

7. Launch local server:

   ```bash
   php artisan serve
   ```

---

## 🔐 Authentication

Horizen uses JWT-based authentication. Tokens are handled manually using custom middleware and `JWT::decode()` logic. The app supports bearer tokens and verifies roles (admin, creator, user) for permissioned routes.

---

## 📁 Project Structure

* `app/Models/` — Eloquent models (User, Video, Comment, etc.)
* `app/Http/Controllers/` — API & Web controllers
* `resources/views/` — Blade templates
* `routes/` — API and web route files
* `database/migrations/` — Schema definitions

---

## 🧪 Testing & Debugging

* Enable **Xdebug** in your local or Docker environment.
* Run test suites with:

  ```bash
  composer test
  ```

---

## 📽 FFmpeg Usage

FFmpeg is used for video validation, conversion, and preview generation. Ensure `ffmpeg` is installed and available in your system path.

---

## 🤝 Contributing

1. Fork the repo
2. Create your feature branch (`git checkout -b feature/my-feature`)
3. Commit your changes (`git commit -m 'Add some feature'`)
4. Push to the branch (`git push origin feature/my-feature`)
5. Open a pull request
