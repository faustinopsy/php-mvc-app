# PHP MVC Application

This is a simple PHP MVC application designed for managing user data with a focus on object-oriented programming principles. The application implements a CRUD (Create, Read, Update, Delete) functionality for user management, utilizing SQLite as the database.

## Project Structure

```
php-mvc-app
├── app
│   ├── Controllers
│   │   └── UserController.php
│   ├── Models
│   │   └── UserModel.php
│   ├── Views
│   │   ├── templates
│   │   │   ├── partials
│   │   │   │   ├── header.php
│   │   │   │   └── footer.php
│   │   │   └── home.php
│   │   └── errors
│   │       └── 404.php
│   └── core
│       ├── Router.php
│       ├── View.php
│       ├── Flash.php
│       └── Redirect.php
├── config
│   └── database.php
├── public
│   ├── index.php
│   └── assets
│       ├── css
│       ├── js
│       └── images
├── .env
├── composer.json
└── README.md
```

## Features

- **User Management**: Create, read, update, and delete user records.
- **API Support**: Respond to API requests with JSON data.
- **Routing**: Simple routing system to manage URL requests.
- **View Management**: Dynamic view rendering with support for partials (header and footer).
- **Flash Messages**: User notifications for actions performed.
- **Session Management**: Persistent user sessions for managing state.

## Installation

1. Clone the repository:
   ```
   git clone <repository-url>
   ```

2. Navigate to the project directory:
   ```
   cd php-mvc-app
   ```

3. Install dependencies using Composer:
   ```
   composer install
   ```

4. Configure the database connection in `config/database.php` and set up your SQLite database.

5. Create a `.env` file in the root directory to define environment variables as needed.

## Usage

- Start the application by accessing `public/index.php` in your web browser.
- Use the provided routes to manage users and interact with the application.

## Contributing

Feel free to submit issues or pull requests for improvements and bug fixes.

## License

This project is open-source and available under the MIT License.