# Frontend Structure

## Overview
- **Type:** [Blade/Vue SPA/React/Livewire/Inertia]
- **CSS Framework:** [Tailwind/Bootstrap/Custom]
- **JS Build:** [Vite/Webpack/Mix]
- **State Management:** [Vuex/Pinia/Redux/None]

---

## Blade Views (resources/views/)

### Layouts
| File | Purpose | Extends |
|------|---------|---------|
| layouts/app.blade.php | Ana layout | - |
| layouts/guest.blade.php | Auth sayfaları | - |
| layouts/admin.blade.php | Admin paneli | - |

### Components (resources/views/components/)
| Component | Purpose | Props |
|-----------|---------|-------|
| button.blade.php | Buton | type, color, size |
| modal.blade.php | Modal dialog | title, id |
| alert.blade.php | Bildirim | type, message |
| form/input.blade.php | Form input | name, label, type |

### Partials
| File | Included In | Purpose |
|------|-------------|---------|
| partials/header.blade.php | layouts/app | Üst menü |
| partials/footer.blade.php | layouts/app | Alt bilgi |
| partials/sidebar.blade.php | layouts/admin | Yan menü |

### Pages
```
views/
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   └── passwords/
├── dashboard.blade.php
├── profile/
│   ├── show.blade.php
│   └── edit.blade.php
├── posts/
│   ├── index.blade.php
│   ├── show.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── admin/
    ├── dashboard.blade.php
    └── users/
```

---

## Vue/React Components (resources/js/)

### Directory Structure
```
resources/js/
├── app.js                 # Entry point
├── bootstrap.js           # Axios, Echo setup
├── Components/
│   ├── UI/
│   │   ├── Button.vue
│   │   ├── Modal.vue
│   │   └── Dropdown.vue
│   ├── Forms/
│   │   ├── Input.vue
│   │   └── Select.vue
│   └── Layout/
│       ├── Navbar.vue
│       └── Sidebar.vue
├── Pages/
│   ├── Dashboard.vue
│   ├── Profile/
│   └── Posts/
├── Composables/           # Vue 3 composables
│   ├── useAuth.js
│   └── useApi.js
└── stores/                # Pinia stores
    ├── auth.js
    └── posts.js
```

### Key Components
| Component | Purpose | Props/Emits |
|-----------|---------|-------------|
| Button.vue | Reusable button | variant, size, loading |
| Modal.vue | Modal dialog | show, @close |
| DataTable.vue | Tablo | columns, data, @sort |
| Pagination.vue | Sayfalama | total, perPage, @page-change |

---

## Livewire Components (app/Livewire/)

| Component | Purpose | Events |
|-----------|---------|--------|
| UserTable | Kullanıcı listesi | userDeleted |
| PostForm | Post formu | postSaved |
| CommentSection | Yorumlar | commentAdded |

---

## CSS/Tailwind

### Custom Colors (tailwind.config.js)
```js
colors: {
  primary: '#3490dc',
  secondary: '#6c757d',
  success: '#38c172',
  danger: '#e3342f',
}
```

### Custom Components
- `.btn` - Buton stilleri
- `.card` - Kart componenti
- `.form-input` - Form input stilleri

---

## JavaScript Libraries
| Library | Version | Purpose |
|---------|---------|---------|
| axios | ^1.x | HTTP client |
| alpinejs | ^3.x | Lightweight reactivity |
| sweetalert2 | ^11.x | Alertler |
| chart.js | ^4.x | Grafikler |

---

## Forms & Validation

### Client-side Validation
- VeeValidate / Formik / Native
- Validation rules synced with backend

### Form Components
| Component | Validation | Features |
|-----------|------------|----------|
| LoginForm | email, password | Remember me |
| RegisterForm | name, email, password, confirm | Terms checkbox |
| ProfileForm | name, email, avatar | Image preview |

---

## UI Patterns

### Loading States
- Skeleton loaders for lists
- Spinner for buttons
- Progress bar for uploads

### Error Handling
- Toast notifications for errors
- Inline validation messages
- 404/500 error pages

### Modals
- Confirmation dialogs
- Form modals
- Image preview modals

---

## Statistics
- Total Blade Views: [sayı]
- Total Vue/React Components: [sayı]
- Total Livewire Components: [sayı]
- Custom CSS Classes: [sayı]
