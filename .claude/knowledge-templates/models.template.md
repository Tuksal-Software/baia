# Models

## Model List

### User
**File:** `app/Models/User.php`
**Table:** `users`

**Fillable:**
- name, email, password, ...

**Hidden:**
- password, remember_token

**Casts:**
- email_verified_at → datetime
- password → hashed

**Relationships:**
| Method | Type | Related Model | Foreign Key |
|--------|------|---------------|-------------|
| posts() | hasMany | Post | user_id |
| profile() | hasOne | Profile | user_id |
| roles() | belongsToMany | Role | role_user |

**Scopes:**
- `scopeActive($query)` - Aktif kullanıcılar
- `scopeVerified($query)` - Email onaylı

**Accessors/Mutators:**
- `getFullNameAttribute()` - Ad soyad birleşimi

**Observers:**
- UserObserver: created, updated, deleted

---

### [Model Name]
**File:** `app/Models/[Name].php`
**Table:** `[table_name]`

**Fillable:**
- field1, field2, ...

**Relationships:**
| Method | Type | Related Model | Foreign Key |
|--------|------|---------------|-------------|
| ... | ... | ... | ... |

**Scopes:**
- ...

---

## Entity Relationship Diagram (Text)
```
User 1──────M Post
  │           │
  │           M
  1           │
  │         Comment
  M           │
  │           M
Role        Like
```

## Model Statistics
- Total Models: [sayı]
- With Soft Deletes: [sayı]
- With Factories: [sayı]
- With Observers: [sayı]
