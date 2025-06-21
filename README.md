# Atzicay Backend

A Laravel-based backend API for the Atzicay project, providing authentication, user management, and educational game endpoints. This project is designed for extensibility and modern web development, using JWT authentication, Auth0 integration, and a modular service structure.

## Folder Structure

- `app/` - Main application code
  - `Helpers/` - Utility classes
  - `Http/`
    - `Controllers/` - API controllers (Auth, User, Game, Programming, Country)
    - `Responses/` - Custom API response classes
  - `Models/` - Eloquent models (User, Game, etc.)
  - `Providers/` - Laravel service providers
  - `Services/` - Business logic (GameService, UserService, etc.)
- `bootstrap/` - Application bootstrap files
- `config/` - Configuration files (app, auth, jwt, l5-swagger, etc.)
- `database/` - Migrations, seeders, factories, SQLite DB
- `public/` - Entry point and static files
- `resources/`
  - `css/`, `js/` - Frontend assets
  - `views/` - Blade templates
- `routes/` - Route definitions (`api.php`, `web.php`, `console.php`)
- `storage/` - Logs, cache, API docs
- `tests/` - Unit and feature tests

## Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite (default) or MariaDB (if configured)

## Installation

1. **Clone the repository:**
   ```sh
   git clone <repo-url>
   cd atzicay
   ```
2. **Install PHP dependencies:**
   ```sh
   composer install
   ```
3. **Install Node dependencies:**
   ```sh
   npm install
   ```
4. **Copy environment file and set keys:**
   ```sh
   cp .env.example .env
   php artisan key:generate
   php artisan jwt:secret
   ```
5. **Set up database:**
   - By default, uses SQLite (`database/database.sqlite`).
   - For MariaDB, update `.env` accordingly and run:
     ```sh
     php artisan migrate --seed
     ```
6. **Build frontend assets:**
   ```sh
   npm run build
   ```

## Development Commands

- Start local server (with queue, logs, Vite):
  ```sh
  composer run dev
  ```
- Run tests:
  ```sh
  composer run test
  ```
- Lint PHP code:
  ```sh
  ./vendor/bin/pint
  ```
- Build frontend:
  ```sh
  npm run build
  ```

## API Endpoints (Main Examples)

All API endpoints are prefixed with `/v1/atzicay`.

### Authentication
- `POST /auth/generate-token` — Exchange Auth0 ID token for JWT
- `POST /auth/refresh-token` — Refresh JWT

### Games
- `GET /game/settings/{gameInstanceId}` — Get game settings
- `GET /game/filter` — Filter/search games
- `GET /game/amount-by-type/{userId}` — Game stats by type
- `GET /my-games/{userId}` — User's games
- `PUT /my-game/update-status/{gameInstanceId}` — Update game status
- `PUT /my-game/update/{gameInstanceId}` — Update game instance
- `POST /my-game/create/{userId}` — Create new game
- `GET /game/report/{gameInstanceId}` — Game report

### Programming Games
- `GET /my-programming-games/{userId}` — List programming games
- `PUT /disable-programming-game/{gameInstanceId}` — Disable programming game
- `POST /programming-game/create/{gameInstanceId}/{userId}` — Create programming game

### Users
- `GET /user/profile/{userId}` — Get user profile
- `PUT /user/update/{userId}` — Update user profile

### Countries
- `GET /country/all` — List all countries

> **Note:** Most endpoints require JWT authentication (`auth.jwt` middleware).

## Security Considerations

- **Authentication:** Uses Auth0 for identity and issues JWTs for API access.
- **Authorization:** Protected routes require valid JWT.
- **CORS:** Configurable via Laravel's CORS middleware.
- **Sensitive Data:** Store secrets in `.env` and never commit them.

## Technologies Used

- **Backend:** Laravel 12, PHP 8.2
- **Frontend tooling:** Vite, Tailwind CSS
- **API Auth:** Auth0, tymon/jwt-auth
- **API Docs:** L5 Swagger (OpenAPI annotations in controllers)
- **Testing:** PHPUnit, Laravel test utilities

## License

MIT License. See `composer.json` for details.

## Author / Contact

- Project skeleton by Laravel
- Main contributors: See `composer.json` or contact repository owner.

---
For more details, see the source code and API documentation at `/api/documentation` when running locally.
