# Better Stack PHP Assignment

A user management application built with a custom PHP mini-framework, Tailwind CSS, and MySQL. Supports listing, searching, and creating users.

**Production:** https://betterstack.sulkowski.dev

---

## Local development

**Requirements:** Docker/MySQL, PHP 8.3+, Node.js

**1. Start the database**
```bash
docker compose up -d
```

**2. Configure the database connection**

Copy the template:
```bash
cp config/database config/database.php
```

Set `config/database.php` to:

```php
$database = array(
    'address'  => '127.0.0.1',
    'username' => 'app',
    'password' => 'secret',
    'database' => 'php_test',
);
```

**3. Watch CSS changes**
```bash
npm install && npm run dev:css
```

**5. Start the server**
```bash
php -S localhost:8000 -t public
```

The app is available at http://localhost:8000.
