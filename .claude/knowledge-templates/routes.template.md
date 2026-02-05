# Routes

## Web Routes (`routes/web.php`)

### Public Routes
| Method | URI | Name | Controller@Action | Middleware |
|--------|-----|------|-------------------|------------|
| GET | / | home | HomeController@index | web |
| GET | /login | login | AuthController@showLogin | guest |
| POST | /login | login.submit | AuthController@login | guest |

### Authenticated Routes
| Method | URI | Name | Controller@Action | Middleware |
|--------|-----|------|-------------------|------------|
| GET | /dashboard | dashboard | DashboardController@index | auth |
| GET | /profile | profile.show | ProfileController@show | auth |
| PUT | /profile | profile.update | ProfileController@update | auth |

### Admin Routes (Prefix: /admin)
| Method | URI | Name | Controller@Action | Middleware |
|--------|-----|------|-------------------|------------|
| GET | /admin/users | admin.users.index | Admin\UserController@index | auth, admin |

---

## API Routes (`routes/api.php`)

### v1 (Prefix: /api/v1)

#### Auth Endpoints
| Method | URI | Name | Controller@Action | Auth |
|--------|-----|------|-------------------|------|
| POST | /api/v1/login | api.login | Api\AuthController@login | No |
| POST | /api/v1/register | api.register | Api\AuthController@register | No |
| POST | /api/v1/logout | api.logout | Api\AuthController@logout | Sanctum |

#### Resource Endpoints
| Method | URI | Name | Controller@Action | Auth |
|--------|-----|------|-------------------|------|
| GET | /api/v1/posts | api.posts.index | Api\PostController@index | Sanctum |
| POST | /api/v1/posts | api.posts.store | Api\PostController@store | Sanctum |
| GET | /api/v1/posts/{id} | api.posts.show | Api\PostController@show | Sanctum |
| PUT | /api/v1/posts/{id} | api.posts.update | Api\PostController@update | Sanctum |
| DELETE | /api/v1/posts/{id} | api.posts.destroy | Api\PostController@destroy | Sanctum |

---

## Route Groups

### Middleware Groups
- `web`: cookie, session, csrf, etc.
- `api`: throttle:api, sanctum
- `auth`: Authenticated users
- `guest`: Non-authenticated users
- `admin`: Admin role required
- `verified`: Email verified required

### Rate Limiting
- API: 60 requests/minute
- Auth: 5 attempts/minute

---

## Statistics
- Total Web Routes: [sayı]
- Total API Routes: [sayı]
- Resource Controllers: [sayı]
- Single Action Controllers: [sayı]
