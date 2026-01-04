# Netourism

A Laravel-based tourism management application.

- Project location: `C:\xampp\htdocs\laravelProjects\netourism`
- Status: Initial README
- Author: (add your name)

Short setup:
1. Copy `.env.example` → `.env`
2. Run `composer install`
3. Run `php artisan key:generate`
4. Run `php artisan migrate --seed`
5. Start server: `php artisan serve`

# Git Repo

echo "# netourism" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M master
git remote add origin https://github.com/digifoxlabs/netourism.git
git push -u origin master


git remote add origin https://github.com/digifoxlabs/netourism.git
git branch -M master
git push -u origin master


### Installation Procedure

1. laravel new netourism -- to create the laravel Project
2. npm install tailwindcss @tailwindcss/vite  -- to install Tailwind CSS

    # Terminal 1 to run Laravel
    php artisan serve

    # Terminal 2 to run Tailwind
    npm run dev


    # For deployment
    npm run build

3. Custom script to run both commands Concurrently
First Install
npm install concurrently --save-dev

"scripts": {
  "dev": "vite",
  "serve": "php artisan serve",
  "hot": "concurrently \"php artisan serve\" \"npm run dev\""
}

4. Command to run both script: npm run hot 

5. Admin Controller and Migrations

    php artisam make:controller Admin/AuthController
    php artisan make:model Role -m   
    php artisan make:model Permission -m
    php artisan make:migration create_role_user_table --create=role_user
    php artisan make:migration create_permission_role_table


6. Create Form Builder

php artisan make:migration create_forms_table
php artisan make:migration create_form_fields_table
php artisan make:model Form
php artisan make:model FormField

php artisan make:controller Admin/FormBuilderController --resource


