# Services & Business Logic

## Actions (app/Actions/)

### User Actions

#### CreateUserAction
**File:** `app/Actions/User/CreateUserAction.php`
**Purpose:** Yeni kullanıcı oluşturma

```php
public function execute(array $data): User
```

**Parameters:**
- `name` (string, required)
- `email` (string, required)
- `password` (string, required)

**Returns:** User model

**Side Effects:**
- Sends welcome email
- Fires UserCreated event

**Used By:**
- RegisterController
- Admin\UserController

---

### [Action Name]
**File:** `app/Actions/[Domain]/[Name].php`
**Purpose:** [Ne yapar]

```php
public function execute(...): [ReturnType]
```

---

## Services (app/Services/)

### PaymentService
**File:** `app/Services/PaymentService.php`
**Purpose:** Ödeme işlemleri yönetimi

**Methods:**
| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|
| charge() | User, amount | Payment | Ödeme al |
| refund() | Payment | bool | İade yap |
| subscribe() | User, Plan | Subscription | Abonelik başlat |

**Dependencies:**
- Stripe SDK
- PaymentRepository

---

### [Service Name]
**File:** `app/Services/[Name].php`
**Purpose:** [Ne yapar]

**Methods:**
| Method | Parameters | Returns | Description |
|--------|------------|---------|-------------|

---

## Repositories (app/Repositories/)

### UserRepository
**File:** `app/Repositories/UserRepository.php`
**Interface:** `UserRepositoryInterface`

**Methods:**
| Method | Description |
|--------|-------------|
| findByEmail($email) | Email ile kullanıcı bul |
| getActiveUsers() | Aktif kullanıcıları getir |
| searchUsers($query) | Kullanıcı ara |

---

## Events & Listeners

### Events
| Event | Fired When | Payload |
|-------|------------|---------|
| UserCreated | Yeni kullanıcı | User $user |
| OrderPlaced | Sipariş verildi | Order $order |
| PaymentFailed | Ödeme başarısız | Payment $payment, string $reason |

### Listeners
| Event | Listener | Action |
|-------|----------|--------|
| UserCreated | SendWelcomeEmail | Hoşgeldin maili gönder |
| UserCreated | CreateDefaultProfile | Profil oluştur |
| OrderPlaced | NotifyAdmin | Admin'e bildirim |
| OrderPlaced | UpdateInventory | Stok güncelle |

---

## Jobs (Queued)

| Job | Queue | Description | Retry |
|-----|-------|-------------|-------|
| ProcessPayment | payments | Ödeme işle | 3 |
| SendNewsletter | emails | Toplu mail | 1 |
| GenerateReport | reports | Rapor oluştur | 0 |

---

## Scheduled Tasks

| Command | Schedule | Description |
|---------|----------|-------------|
| backup:run | daily 02:00 | Veritabanı yedekle |
| telescope:prune | daily | Telescope logları temizle |
| subscriptions:renew | hourly | Abonelikleri yenile |

---

## Business Rules

### User Registration
1. Email benzersiz olmalı
2. Şifre min 8 karakter
3. Email doğrulama zorunlu
4. Hoşgeldin maili gönderilir

### Order Processing
1. Stok kontrolü yapılır
2. Ödeme alınır
3. Stok düşürülür
4. Onay maili gönderilir
5. Admin bilgilendirilir

---

## Statistics
- Total Actions: [sayı]
- Total Services: [sayı]
- Total Events: [sayı]
- Total Listeners: [sayı]
- Total Jobs: [sayı]
