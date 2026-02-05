# Database Schema

## Tables

### users
**Migration:** `2024_01_01_000000_create_users_table.php`

| Column | Type | Nullable | Default | Index | Notes |
|--------|------|----------|---------|-------|-------|
| id | bigint | NO | AI | PK | |
| name | varchar(255) | NO | | | |
| email | varchar(255) | NO | | UNIQUE | |
| email_verified_at | timestamp | YES | NULL | | |
| password | varchar(255) | NO | | | |
| remember_token | varchar(100) | YES | NULL | | |
| created_at | timestamp | YES | NULL | | |
| updated_at | timestamp | YES | NULL | | |

**Indexes:**
- PRIMARY: id
- UNIQUE: email

**Foreign Keys:**
- None

---

### posts
**Migration:** `2024_01_02_000000_create_posts_table.php`

| Column | Type | Nullable | Default | Index | Notes |
|--------|------|----------|---------|-------|-------|
| id | bigint | NO | AI | PK | |
| user_id | bigint | NO | | FK, INDEX | |
| title | varchar(255) | NO | | | |
| slug | varchar(255) | NO | | UNIQUE | |
| content | text | NO | | | |
| status | enum | NO | 'draft' | INDEX | draft,published |
| published_at | timestamp | YES | NULL | | |
| deleted_at | timestamp | YES | NULL | | Soft delete |
| created_at | timestamp | YES | NULL | | |
| updated_at | timestamp | YES | NULL | | |

**Indexes:**
- PRIMARY: id
- UNIQUE: slug
- INDEX: user_id
- INDEX: status

**Foreign Keys:**
- user_id → users(id) ON DELETE CASCADE

---

### [table_name]
**Migration:** `[migration_file]`

| Column | Type | Nullable | Default | Index | Notes |
|--------|------|----------|---------|-------|-------|
| ... | ... | ... | ... | ... | ... |

---

## Pivot Tables

### role_user
| Column | Type | Foreign Key |
|--------|------|-------------|
| user_id | bigint | users(id) |
| role_id | bigint | roles(id) |

---

## Database Diagram (Text)
```
┌─────────┐       ┌─────────┐
│  users  │       │  roles  │
├─────────┤       ├─────────┤
│ id (PK) │◀──┐   │ id (PK) │
│ name    │   │   │ name    │
│ email   │   │   └────┬────┘
└────┬────┘   │        │
     │        │   ┌────┴────┐
     │        └───┤role_user│
     │            └─────────┘
     │
     ▼
┌─────────┐
│  posts  │
├─────────┤
│ id (PK) │
│ user_id │ (FK)
│ title   │
└─────────┘
```

## Statistics
- Total Tables: [sayı]
- Total Migrations: [sayı]
- Tables with Soft Delete: [sayı]
- Pivot Tables: [sayı]
