# Project Structure

## Overview
- **Project Name:** [Proje adı]
- **Framework:** Laravel [version]
- **PHP Version:** [version]
- **Database:** [MySQL/PostgreSQL/SQLite]
- **Frontend:** [Blade/Vue/React/Livewire/Inertia]
- **Auth System:** [Breeze/Jetstream/Fortify/Custom]

## Directory Structure
```
├── app/
│   ├── Actions/         [Var/Yok] - [Açıklama]
│   ├── Console/         [Var/Yok] - [Komut sayısı]
│   ├── Events/          [Var/Yok] - [Event sayısı]
│   ├── Exceptions/      [Var/Yok]
│   ├── Http/
│   │   ├── Controllers/ [Controller sayısı]
│   │   ├── Middleware/  [Middleware sayısı]
│   │   └── Requests/    [Request sayısı]
│   ├── Jobs/            [Var/Yok] - [Job sayısı]
│   ├── Listeners/       [Var/Yok] - [Listener sayısı]
│   ├── Mail/            [Var/Yok] - [Mail sayısı]
│   ├── Models/          [Model sayısı]
│   ├── Notifications/   [Var/Yok]
│   ├── Observers/       [Var/Yok]
│   ├── Policies/        [Var/Yok]
│   ├── Providers/       [Provider sayısı]
│   └── Services/        [Var/Yok]
├── config/              [Config dosyaları]
├── database/
│   ├── factories/       [Factory sayısı]
│   ├── migrations/      [Migration sayısı]
│   └── seeders/         [Seeder sayısı]
├── resources/
│   ├── views/           [View yapısı]
│   ├── js/              [JS framework]
│   └── css/             [CSS framework]
├── routes/
│   ├── web.php          [Route sayısı]
│   ├── api.php          [Route sayısı]
│   └── ...
└── tests/
    ├── Unit/            [Test sayısı]
    └── Feature/         [Test sayısı]
```

## Key Packages
| Package | Version | Purpose |
|---------|---------|---------|
| [package] | [version] | [ne için] |

## Architecture Patterns
- [ ] Repository Pattern
- [ ] Service Pattern
- [ ] Action Classes
- [ ] DTOs
- [ ] Events/Listeners
- [ ] Observers
- [ ] Policies

## External Services
- [ ] Queue Driver: [sync/redis/database]
- [ ] Cache Driver: [file/redis/memcached]
- [ ] Mail Driver: [smtp/mailgun/ses]
- [ ] Storage: [local/s3]
- [ ] Search: [scout/algolia/meilisearch]

## Notes
[Önemli notlar, dikkat edilmesi gerekenler]
