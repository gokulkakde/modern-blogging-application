# College Blog Application (PHP & MySQL)

A modern, full-featured College Blog web application built with PHP and MySQL, featuring user authentication, role-based admin dashboard, category filtering, search functionality, and responsive UI.

---

## 🌟 Features
- **Public Blog**: Browse latest articles, featured posts, filter by category, and full-text search.
- **Role-Based Access Control**:
  - **Admin**: Manage all posts, add/edit/delete categories, and manage users/roles.
  - **Author**: Create, edit, and delete personal blog posts with image uploads.
- **Security & Integrity**: Passwords hashed with Bcrypt, SQL sanitization, XSS escaping, safe avatar/thumbnail management.
- **Cloud-Ready**: Zero-config environment variable support for cloud deployment (Docker, Render, Railway, TiDB, Aiven, etc.).

---

## 🔑 Default Admin Account
Upon running `database.sql` or launching with Docker, the default administrator credentials are:
- **Username**: `admin`
- **Password**: `password123`
- **Email**: `admin@collegeblog.com`

---

## 🚀 How to Run Locally

### Method 1: Using Docker & Docker Compose (Recommended)
Make sure you have Docker installed and running, then execute:

```bash
cd blog
docker compose up --build
```
- The blog will be available at: **`http://localhost:8080`**
- The MySQL database and seed data are initialized automatically!

---

### Method 2: Using XAMPP / WAMP / Local PHP
1. Copy the `blog` folder to your web server root (e.g. `C:/xampp/htdocs/blog`).
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin`, create a database named `blog`, and import `database.sql`.
4. Open your browser and navigate to: **`http://localhost/blog/`**.

---

## 🌐 How to Deploy Live (100% Free Live Link)

### Option A: 1-Click / Fast Deployment on Railway (All-in-One)
1. Push this repository to your **GitHub** account.
2. Go to [railway.app](https://railway.app/) and sign in with GitHub.
3. Click **New Project** → **Provision MySQL**.
4. In the MySQL service on Railway:
   - Go to the **Data** or **Connect** tab.
   - Run or paste the contents of `database.sql` into the SQL query console.
5. In the same Railway project, click **New** → **GitHub Repo** → Select your repository (root directory set to `/college-blog-main/blog` or repo root).
6. Under **Variables** for your web service, Railway automatically links `MYSQL_URL` / `DATABASE_URL`!
7. Under **Settings** → **Networking** → Click **Generate Domain**.
8. Your blog is live at your public `https://...up.railway.app` URL!

---

### Option B: Deploy on Render + TiDB Cloud / Aiven (Free Tier)

#### Step 1: Set up Free Cloud MySQL Database
1. Go to [TiDB Cloud Free Serverless](https://tidbcloud.com/) or [Aiven Free MySQL](https://aiven.io/).
2. Create a free MySQL cluster.
3. Connect using their web SQL editor or MySQL workbench, and execute the queries in `database.sql`.
4. Note your database connection details: Host, Port, User, Password, Database Name.

#### Step 2: Deploy Web App on Render
1. Go to [render.com](https://render.com/) and click **New +** → **Web Service**.
2. Connect your GitHub repository.
3. Set the following settings:
   - **Environment**: `Docker`
   - **Docker Context**: `college-blog-main/blog` (or `.` if repo is at root)
   - **Docker Command**: Leave default
4. Add the following **Environment Variables** in Render:
   - `DB_HOST`: `<Your Cloud DB Host>`
   - `DB_USER`: `<Your Cloud DB User>`
   - `DB_PASS`: `<Your Cloud DB Password>`
   - `DB_NAME`: `<Your Cloud DB Name>`
   - `DB_PORT`: `<Your Cloud DB Port (e.g. 4000 or 3306)>`
5. Click **Create Web Service**.
6. Once built, Render will provide a live link: `https://your-app-name.onrender.com`.

---

## 🛠️ Environment Variables Reference

| Variable | Description | Default |
| :--- | :--- | :--- |
| `DB_HOST` | MySQL database host | `localhost` |
| `DB_USER` | MySQL database user | `root` |
| `DB_PASS` | MySQL database password | `""` |
| `DB_NAME` | MySQL database name | `blog` |
| `DB_PORT` | MySQL database port | `3306` |
| `DATABASE_URL` | Complete MySQL connection URI (`mysql://user:pass@host:port/db`) | _Optional_ |
| `ROOT_URL` | Public URL prefix with trailing slash | _Auto-detected_ |

---

## 📁 Project Structure
```text
blog/
├── admin/                     # Admin & Author management dashboard
│   ├── add-category.php
│   ├── add-post.php
│   ├── add-user.php
│   ├── edit-category.php
│   ├── edit-post.php
│   ├── edit-user.php
│   ├── manage-categories.php
│   ├── manage-users.php
│   └── index.php
├── config/
│   ├── constants.php          # Dynamic environment & URL configuration
│   └── database.php           # MySQLi database connection handler
├── css/
│   └── style.css              # Custom responsive stylesheet
├── images/                    # Uploaded post thumbnails and user avatars
├── js/
│   └── main.js                # Frontend navigation and sidebar script
├── partials/
│   ├── header.php             # Global navigation and head
│   └── footer.php             # Global footer
├── database.sql               # Complete MySQL schema & initial seed data
├── Dockerfile                 # Production Docker image with Apache + PHP 8.2
├── docker-compose.yml         # Local orchestration with MySQL 8.0
├── index.php                  # Home page with featured & latest posts
├── blog.php                   # All blog posts list
├── post.php                   # Single blog post view
├── category-posts.php         # Posts filtered by category
├── search.php                 # Search results page
├── signin.php                 # User login page
└── signup.php                 # User registration page
```
