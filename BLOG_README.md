# Simple Blog Application

A minimal blog system built with Laravel featuring posts, comments, authentication, and slug-based URLs.

## ✅ Features Implemented

- ✅ **Admin creates posts** - Authenticated users can create, edit, and delete posts
- ✅ **Users view posts** - Public blog listing and individual post pages
- ✅ **Comment functionality** - Both authenticated users and guests can comment
- ✅ **Authentication** - Laravel Breeze authentication system
- ✅ **Slug-based URLs** - Posts use SEO-friendly slugs instead of IDs

## 📁 Project Structure

### Models & Relationships
- **User** (hasMany: posts, comments)
- **Post** (belongsTo: user | hasMany: comments)
- **Comment** (belongsTo: post, user)

### Controllers
- `PostController` - CRUD operations for posts
- `CommentController` - Create and delete comments
- `AdminController` - Admin dashboard

### Views
- `posts/index.blade.php` - Blog listing page
- `posts/show.blade.php` - Individual post with comments
- `posts/create.blade.php` - Create new post form
- `posts/edit.blade.php` - Edit post form
- `admin/index.blade.php` - Admin dashboard

## 🚀 Getting Started

### 1. Database Setup
The database is already configured to use MySQL (`blogs` database on port 3308).
Migrations have been run successfully.

### 2. Create an Admin User
```bash
php artisan tinker
```
Then:
```php
$user = App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
]);
```

### 3. Start the Server
```bash
php artisan serve
```

### 4. Access the Application
- **Blog Home**: http://localhost:8000
- **Login**: http://localhost:8000/login
- **Register**: http://localhost:8000/register
- **Admin Dashboard**: http://localhost:8000/admin (requires login)

## 📝 Usage

### Creating Posts
1. Login or register
2. Click "New Post" in navigation
3. Fill in title and content
4. Submit - slug is automatically generated from title

### Viewing Posts
- All posts are visible on the home page
- Click any post to view full content and comments
- Posts use slug-based URLs (e.g., `/posts/my-first-post`)

### Commenting
- **Authenticated users**: Just enter comment text
- **Guests**: Must provide name and email

### Admin Features
- View all posts in admin dashboard
- Edit/delete any post (if you're the author)
- Delete comments (if you're the commenter or post author)

## 🔑 Key Concepts Demonstrated

### One-to-Many Relationships
- User → Posts (one user has many posts)
- User → Comments (one user has many comments)
- Post → Comments (one post has many comments)

### Blade Layouts
- Main layout: `resources/views/layouts/app.blade.php`
- Navigation: `resources/views/layouts/navigation.blade.php`
- All views extend the main layout

### Controllers
- Resource controller for posts (CRUD operations)
- Standard controllers for comments and admin

### Slug-based URLs
- Posts use `slug` instead of `id` in URLs
- Implemented via `getRouteKeyName()` in Post model
- Route model binding: `Route::get('/posts/{post:slug}')`

## 🎨 Styling
Uses Tailwind CSS via Laravel Breeze with a clean, modern design.

## 📊 Database Schema

### posts
- id
- user_id (foreign key)
- title
- slug (unique)
- content
- timestamps

### comments
- id
- post_id (foreign key)
- user_id (nullable foreign key)
- author_name (nullable, for guests)
- author_email (nullable, for guests)
- content
- timestamps

## 🔒 Security Features
- Authentication required for creating/editing posts
- Users can only edit/delete their own posts
- Comment deletion restricted to commenter or post author
- CSRF protection on all forms
- Input validation on all forms

## 📚 Next Steps (Optional Enhancements)
- Add categories/tags to posts
- Implement post search functionality
- Add image uploads for posts
- Email notifications for new comments
- Rich text editor for post content
- Post status (draft/published)

