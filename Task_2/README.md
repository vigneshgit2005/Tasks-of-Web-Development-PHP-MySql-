# Basic CRUD Blog (PHP + MySQL)

A minimal blog demonstrating **Create, Read, Update, Delete (CRUD)** with **user authentication**.
Uses PDO, prepared statements, `password_hash`, sessions, and a simple CSRF token.

---
## 1) Prerequisites
- PHP 8+
- MySQL 5.7+/MariaDB 10+ (or MySQL 8+)
- A local server stack like XAMPP/MAMP/WAMP **or** PHP's built-in server

## 2) Create the database & tables
Option A — via `schema.sql`:
1. Open your MySQL client or phpMyAdmin.
2. Run the contents of `schema.sql`.

Option B — via CLI:
```sql
SOURCE /absolute/path/to/schema.sql;
```

## 3) Configure the app
1. Copy `config.sample.php` to `config.php` and set your DB username/password.
2. If your app is in a subfolder, update `BASE_URL` accordingly.

## 4) Run
- With XAMPP/WAMP: copy the `public/` folder contents into your `htdocs` (or set your DocumentRoot to `public`).
- With PHP built-in server (from project root):
  ```bash
  php -S localhost:8000 -t public
  ```
  Then open http://localhost:8000

## 5) Test the features
1. Visit the site and click **Register**, create a user.
2. **Login** using that user.
3. Click **New Post** to **Create** a post.
4. On the home page, see your posts (**Read**).
5. Click **Edit** on your post, change the content (**Update**).
6. Click **Delete** to remove it (**Delete**).

## 6) Notes
- Only the owner of a post can edit/delete it.
- Basic CSRF protection is included.
- For production, consider HTTPS, stronger validation, rate limiting, and more robust CSRF/session settings.
