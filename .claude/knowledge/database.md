# BAIA Database Schema

## Tables Overview (24 Migrations)

| Table | Purpose | Key Columns |
|-------|---------|-------------|
| users | Authentication | name, email, password, is_admin |
| categories | Product categories | name, slug, parent_id, is_active |
| products | Main products | name, slug, price, sale_price, stock, is_active, is_featured |
| product_images | Product gallery | product_id, image_path, is_primary, sort_order |
| product_specifications | Tech specs | product_id, key, value |
| product_features | Product features | product_id, title, description, icon |
| product_variants | Product variants | product_id, name, type, value, price_modifier, stock |
| reviews | Product reviews | product_id, user_id, rating, comment, is_approved |
| carts | Shopping carts | user_id, session_id |
| cart_items | Cart contents | cart_id, product_id, quantity, variant_id |
| orders | Customer orders | order_number, status, total, address fields |
| order_items | Order lines | order_id, product_id, quantity, price |
| discount_codes | Promo codes | code, type, value, min_order_amount, expires_at |
| site_settings | Global settings | key, value, type, group |
| sliders | Homepage slider | title, image, link, sort_order, is_active |
| banners | Promo banners | title, image, link, position, is_active |
| home_sections | Dynamic sections | type, title, config, sort_order |
| features | Site features | title, description, icon |
| menus | Navigation menus | name, location |
| menu_items | Menu links | menu_id, parent_id, title, url, sort_order |
| newsletter_subscribers | Email list | email, is_active, subscribed_at |
| personal_access_tokens | API tokens | Sanctum tokens |
| cache | Cache storage | Laravel cache |
| jobs | Queue jobs | Laravel queue |

---

## Detailed Table Schemas

### users
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
name                VARCHAR(255)
email               VARCHAR(255) UNIQUE
email_verified_at   TIMESTAMP NULL
password            VARCHAR(255)
is_admin            BOOLEAN DEFAULT false
remember_token      VARCHAR(100) NULL
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### categories
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
name                VARCHAR(255)
slug                VARCHAR(255) UNIQUE
description         TEXT NULL
parent_id           BIGINT UNSIGNED NULL (FK -> categories.id)
is_active           BOOLEAN DEFAULT true
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: parent_id
```

### products
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
category_id         BIGINT UNSIGNED (FK -> categories.id)
name                VARCHAR(255)
slug                VARCHAR(255) UNIQUE
description         TEXT NULL
price               DECIMAL(10,2)
sale_price          DECIMAL(10,2) NULL
stock               INTEGER DEFAULT 0
is_active           BOOLEAN DEFAULT true
is_featured         BOOLEAN DEFAULT false
is_new              BOOLEAN DEFAULT false
rating              DECIMAL(3,2) DEFAULT 0.00
reviews_count       INTEGER DEFAULT 0
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: category_id, is_active, is_featured, is_new
```

### product_images
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
product_id          BIGINT UNSIGNED (FK -> products.id CASCADE)
image_path          VARCHAR(255)
is_primary          BOOLEAN DEFAULT false
sort_order          INTEGER DEFAULT 0
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: product_id
```

### product_specifications
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
product_id          BIGINT UNSIGNED (FK -> products.id CASCADE)
key                 VARCHAR(255)
value               VARCHAR(255)
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: product_id
```

### product_features
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
product_id          BIGINT UNSIGNED (FK -> products.id CASCADE)
title               VARCHAR(255)
description         TEXT NULL
icon                VARCHAR(100) NULL
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: product_id
```

### product_variants
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
product_id          BIGINT UNSIGNED (FK -> products.id CASCADE)
name                VARCHAR(255)
type                VARCHAR(50)  -- color, size, material
value               VARCHAR(255)
price_modifier      DECIMAL(10,2) DEFAULT 0.00
stock               INTEGER DEFAULT 0
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: product_id, type
```

### reviews
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
product_id          BIGINT UNSIGNED (FK -> products.id CASCADE)
user_id             BIGINT UNSIGNED NULL (FK -> users.id SET NULL)
name                VARCHAR(255)
email               VARCHAR(255)
rating              TINYINT UNSIGNED (1-5)
comment             TEXT
is_approved         BOOLEAN DEFAULT false
is_verified         BOOLEAN DEFAULT false
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: product_id, user_id, is_approved
```

### carts
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
user_id             BIGINT UNSIGNED NULL (FK -> users.id CASCADE)
session_id          VARCHAR(255) NULL
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: user_id, session_id
```

### cart_items
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
cart_id             BIGINT UNSIGNED (FK -> carts.id CASCADE)
product_id          BIGINT UNSIGNED (FK -> products.id CASCADE)
quantity            INTEGER DEFAULT 1
variant_id          BIGINT UNSIGNED NULL (FK -> product_variants.id SET NULL)
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: cart_id, product_id
```

### orders
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
order_number        VARCHAR(50) UNIQUE
user_id             BIGINT UNSIGNED NULL (FK -> users.id SET NULL)
status              VARCHAR(50) DEFAULT 'pending'
                    -- pending, confirmed, processing, shipped, delivered, cancelled
subtotal            DECIMAL(10,2)
discount            DECIMAL(10,2) DEFAULT 0.00
shipping_fee        DECIMAL(10,2) DEFAULT 0.00
total               DECIMAL(10,2)
discount_code_id    BIGINT UNSIGNED NULL (FK -> discount_codes.id)
name                VARCHAR(255)
email               VARCHAR(255)
phone               VARCHAR(50)
address             TEXT
city                VARCHAR(100)
district            VARCHAR(100)
postal_code         VARCHAR(20)
notes               TEXT NULL
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: order_number, user_id, status
```

### order_items
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
order_id            BIGINT UNSIGNED (FK -> orders.id CASCADE)
product_id          BIGINT UNSIGNED (FK -> products.id CASCADE)
quantity            INTEGER
price               DECIMAL(10,2)
variant_info        JSON NULL
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: order_id, product_id
```

### discount_codes
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
code                VARCHAR(50) UNIQUE
type                VARCHAR(20)  -- percentage, fixed
value               DECIMAL(10,2)
min_order_amount    DECIMAL(10,2) NULL
max_uses            INTEGER NULL
used_count          INTEGER DEFAULT 0
starts_at           TIMESTAMP NULL
expires_at          TIMESTAMP NULL
is_active           BOOLEAN DEFAULT true
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: code, is_active
```

### site_settings
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
key                 VARCHAR(255) UNIQUE
value               TEXT NULL
type                VARCHAR(50) DEFAULT 'text'
                    -- text, textarea, image, boolean, json
group               VARCHAR(100) DEFAULT 'general'
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: key, group
```

### sliders
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
title               VARCHAR(255)
subtitle            VARCHAR(255) NULL
image               VARCHAR(255)
link                VARCHAR(255) NULL
button_text         VARCHAR(100) NULL
sort_order          INTEGER DEFAULT 0
is_active           BOOLEAN DEFAULT true
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: is_active, sort_order
```

### banners
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
title               VARCHAR(255)
image               VARCHAR(255)
link                VARCHAR(255) NULL
position            VARCHAR(50)  -- home_top, home_middle, sidebar
sort_order          INTEGER DEFAULT 0
is_active           BOOLEAN DEFAULT true
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: position, is_active
```

### home_sections
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
type                VARCHAR(50)  -- featured_products, new_products, categories, banner
title               VARCHAR(255)
subtitle            VARCHAR(255) NULL
config              JSON NULL    -- section-specific configuration
sort_order          INTEGER DEFAULT 0
is_active           BOOLEAN DEFAULT true
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: is_active, sort_order
```

### menus
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
name                VARCHAR(255)
location            VARCHAR(100) UNIQUE  -- header, footer, sidebar
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### menu_items
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
menu_id             BIGINT UNSIGNED (FK -> menus.id CASCADE)
parent_id           BIGINT UNSIGNED NULL (FK -> menu_items.id CASCADE)
title               VARCHAR(255)
url                 VARCHAR(255)
target              VARCHAR(20) DEFAULT '_self'
sort_order          INTEGER DEFAULT 0
is_active           BOOLEAN DEFAULT true
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: menu_id, parent_id, sort_order
```

### newsletter_subscribers
```sql
id                  BIGINT UNSIGNED PRIMARY KEY
email               VARCHAR(255) UNIQUE
is_active           BOOLEAN DEFAULT true
subscribed_at       TIMESTAMP
created_at          TIMESTAMP
updated_at          TIMESTAMP

INDEX: email, is_active
```

---

## Key Relationships

```
users 1──M carts
users 1──M orders
users 1──M reviews

categories 1──M products
categories 1──M categories (self: parent/children)

products 1──M product_images
products 1──M product_specifications
products 1──M product_features
products 1──M product_variants
products 1──M reviews
products 1──M cart_items
products 1──M order_items

carts 1──M cart_items

orders 1──M order_items
orders M──1 discount_codes

menus 1──M menu_items
menu_items 1──M menu_items (self: parent/children)
```
