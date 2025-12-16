# Silver

A lightweight PHP MVC framework with modern development features.

## Overview

Silver is a minimalist PHP framework that follows the MVC (Model-View-Controller) architectural pattern. It provides essential features for building web applications with a clean and simple structure.

## Features

- **MVC Architecture**: Clean separation of concerns with Models, Views, and Controllers
- **Routing System**: Simple URL routing with support for RESTful APIs
- **Template Engine**: Twig template engine integration for powerful view rendering
- **Database Abstraction**: Medoo database library for easy database operations
- **Error Handling**: Whoops error handler for better debugging experience
- **Autoloading**: PSR-4 compliant autoloading with Composer
- **Logging**: Monolog integration for application logging
- **Email Support**: PHPMailer for sending emails
- **Caching**: Doctrine Cache for improved performance
- **Testing**: PHPUnit support for unit testing

## Requirements

- PHP >= 5.5.9
- Composer

## Installation

1. Clone the repository:
```bash
git clone https://github.com/bryht/silver.git
cd silver
```

2. Install dependencies:
```bash
composer install
```

3. Configure your web server to point to the project directory

4. Configure your database settings in the configuration file

## Project Structure

```
silver/
├── app/                    # Application directory
│   ├── api/               # API controllers
│   ├── control/           # Controllers
│   ├── model/             # Models
│   └── view/              # Views (Twig templates)
├── admin/                 # Admin interface
├── cache/                 # Cache files
├── core/                  # Framework core files
│   ├── Cache.php
│   ├── Conf.php
│   ├── Control.php
│   ├── Function.php
│   ├── Model.php
│   ├── Route.php
│   └── Silver.php
├── test/                  # Unit tests
├── vendor/                # Composer dependencies
├── composer.json          # Composer configuration
└── index.php             # Application entry point
```

## Routing

Silver uses a simple PATH_INFO based routing system:

### Standard Routes
- Pattern: `/Controller/action`
- Example: `/User/profile` → `UserControl::profile()`

### API Routes
- Pattern: `/api/Resource/action`
- Example: `/api/User/login` → `UserApi::login()`

### Default Route
Configure the default controller and action in your configuration file.

## Controllers

Controllers extend the base `Control` class and handle application logic:

```php
<?php
namespace app\control;
use core\Control;

class UserControl extends Control
{
    public function profile($params)
    {
        $this->assign('username', 'John Doe');
        $this->display('user-profile.html');
    }
}
```

### Controller Methods
- `assign($name, $value)` - Assign variables to views
- `display($file)` - Render a Twig template
- `display_normal($file)` - Render a plain PHP view
- `success($data)` - Return JSON success response
- `error($message)` - Return JSON error response

## Models

Models extend the base `Model` class (which extends Medoo):

```php
<?php
namespace app\model;
use core\Model;

class UserModel extends Model
{
    // Table name is automatically derived from class name
    // UserModel → 'user' table
    
    public function getUser($id)
    {
        return $this->get($this->table, '*', ['id' => $id]);
    }
}
```

### Model Methods
- `insertObj($data)` - Insert a record and return the ID
- `updateObj($data, $where)` - Update records
- All Medoo methods are available

## Views

Views use the Twig template engine:

```twig
{# app/view/user-profile.html #}
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>
    <h1>Welcome, {{ username }}</h1>
</body>
</html>
```

## Configuration

Configuration is managed through the `core\Conf` class. Create your configuration methods to return database settings and other options.

## Testing

Run tests using PHPUnit:

```bash
vendor/bin/phpunit test/
```

## Dependencies

- **filp/whoops** - Error handling
- **catfan/medoo** - Database abstraction
- **twig/twig** - Template engine
- **doctrine/cache** - Caching
- **monolog/monolog** - Logging
- **phpmailer/phpmailer** - Email sending

## Development

### Debug Mode
Set `DEBUG` to `true` in [index.php](index.php) to enable detailed error pages with Whoops.

### Code Standards
The project includes PHP_CodeSniffer for code quality:
```bash
vendor/bin/phpcs
vendor/bin/phpcbf
```

## License

MIT License

## Author

bryht
