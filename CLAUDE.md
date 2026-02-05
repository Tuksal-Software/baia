# Multi-Agent Development System

## PHASE 0: PROJECT INITIALIZATION (İLK ÇALIŞTIRMADA ZORUNLU)

**Eğer `.claude/knowledge/project-structure.md` YOKSA veya BOŞ ise:**

Bu projeye ilk kez giriyorsun. Kod yazmadan önce MUTLAKA projeyi tanı:

### 0.1 Project Discovery
```
1. Tüm dizin yapısını tara
2. composer.json, package.json analiz et
3. .env.example'dan config'leri öğren
4. routes/ klasörünü tara - tüm endpoint'leri listele
5. app/Models/ - tüm modelleri ve ilişkileri çıkar
6. database/migrations/ - tablo yapılarını öğren
7. app/Http/Controllers/ - controller yapısını anla
8. app/Services/, app/Actions/ - business logic'i öğren
9. tests/ - mevcut test yapısını anla
10. resources/views/ veya frontend yapısını tara
```

### 0.2 Knowledge Files Oluştur
Tarama sonrası `.claude/knowledge/` içine şu dosyaları YARAT:

| Dosya | İçerik |
|-------|--------|
| `project-structure.md` | Dizin yapısı, teknolojiler, genel mimari |
| `models.md` | Tüm modeller, ilişkiler, önemli scope'lar |
| `routes.md` | Tüm route'lar, middleware'ler, controller eşleşmeleri |
| `database.md` | Tablolar, kolonlar, indexler, foreign key'ler |
| `services.md` | Service'ler, Action'lar, business logic özeti |
| `frontend.md` | View yapısı, component'ler, JS/CSS |
| `changelog.md` | Yapılan değişikliklerin logu |

### 0.3 Knowledge Güncelleme
**HER GELİŞTİRME SONRASI** ilgili knowledge dosyalarını GÜNCELLE!

---

## CRITICAL INSTRUCTION - AUTO WORKFLOW

**Her kullanıcı isteğinde bu pipeline'ı OTOMATIK olarak uygula:**

### ADIM 1: KNOWLEDGE CHECK
```
1. .claude/knowledge/ dosyalarını oku
2. İlgili modelleri, route'ları, servisleri HATIRLA
3. Mevcut yapıyı anla
```

### ADIM 2: PRODUCT MANAGER PHASE
Kullanıcının isteğini al ve `.claude/product-manager.md` dosyasındaki kurallara göre:
1. **Knowledge'dan** mevcut yapıyı kontrol et
2. İsteği analiz et
3. Eksik bilgi varsa kullanıcıya sor
4. Profesyonel Task JSON oluştur (acceptance criteria, technical notes dahil)
5. Task JSON'ı kullanıcıya göster ve onay al

**Output:** Task JSON dosyası

---

### ADIM 3: DEVELOPER PHASE
Product Manager'ın onaylanan Task JSON'ını al ve `.claude/laravel-developer.md` dosyasındaki kurallara göre:
1. **Knowledge'dan** ilgili kodları oku
2. Mevcut pattern'leri takip et
3. Laravel best practices ile kodu yaz
4. Unit ve Feature testlerini yaz
5. Implementation raporu oluştur
6. **Knowledge dosyalarını GÜNCELLE**

**Output:** Kod + Implementation Report JSON + Updated Knowledge

---

### ADIM 4: QA PHASE
Developer'ın implementation'ını al ve `.claude/qa-agent.md` dosyasındaki kurallara göre:
1. **Knowledge'dan** test edilecek alanları belirle
2. Acceptance criteria'ları test et
3. UI testlerini yaz (Dusk/Playwright)
4. Edge case'leri test et
5. Bug varsa raporla
6. Final QA raporu oluştur

**Output:** QA Report JSON + Test dosyaları

---

## WORKFLOW RULES

```
┌──────────────┐
│  KNOWLEDGE   │◀─────────────────────────────────────┐
│    BASE      │                                      │
└──────┬───────┘                                      │
       │ reads                                   updates
       ▼                                              │
┌─────────────┐    Task JSON    ┌─────────────┐    Impl Report    ┌─────────────┐
│   PRODUCT   │ ──────────────▶ │  DEVELOPER  │ ────────────────▶ │     QA      │
│   MANAGER   │                 │   (Senior)  │                   │    AGENT    │
└─────────────┘                 └──────┬──────┘                   └─────────────┘
       │                               │                                  │
       ▼                               ▼                                  ▼
  Task JSON                    Code + Tests                      QA Report
  (with ACs)                  + Impl Report                    + Bug Reports
                              + Knowledge Update
```

### Mandatory Flow:
1. **ASLA** knowledge okumadan başlama - önce projeyi tanı
2. **ASLA** doğrudan kod yazma - önce Product Manager phase'i tamamla
3. **ASLA** test yazmadan geçme - Developer phase testleri içermeli
4. **ASLA** QA phase'i atlama - her implementation test edilmeli
5. **ASLA** knowledge güncellemeden bitirme - her değişiklik loglanmalı

### Knowledge Update Rules:
- Yeni model → `models.md` güncelle
- Yeni route → `routes.md` güncelle
- Yeni migration → `database.md` güncelle
- Yeni service/action → `services.md` güncelle
- Her değişiklik → `changelog.md`'ye ekle

---

## AGENT DOSYALARI

| Agent | Dosya | Rol |
|-------|-------|-----|
| Product Manager | `.claude/product-manager.md` | Task oluşturma, AC tanımlama |
| Senior Laravel Dev | `.claude/laravel-developer.md` | Implementation, kod yazma |
| QA Engineer | `.claude/qa-agent.md` | Test, validation, bug reporting |

## CODING STANDARDS

| Framework | Dosya | Açıklama |
|-----------|-------|----------|
| Laravel | `.claude/coding-standards/laravel.md` | 46 maddelik Laravel coding standards |

**Not:** İleride Symfony, Next.js gibi framework'ler eklendiğinde bu klasöre yeni standart dosyaları eklenir.

## KNOWLEDGE DOSYALARI

| Dosya | İçerik | Güncelleyen |
|-------|--------|-------------|
| `.claude/knowledge/project-structure.md` | Genel mimari | INIT, Major changes |
| `.claude/knowledge/models.md` | Model ve ilişkiler | Developer |
| `.claude/knowledge/routes.md` | API/Web routes | Developer |
| `.claude/knowledge/database.md` | DB şeması | Developer |
| `.claude/knowledge/services.md` | Business logic | Developer |
| `.claude/knowledge/frontend.md` | UI yapısı | Developer |
| `.claude/knowledge/changelog.md` | Değişiklik logu | All agents |

---

## ÖRNEK İLK ÇALIŞTIRMA

**Kullanıcı:** "Merhaba"

**Claude:**
```
🔍 PROJECT INITIALIZATION
=========================
Bu projeye ilk kez giriyorum. Projeyi tanıyorum...

[Dizin taraması yapar]
[Knowledge dosyalarını oluşturur]

✅ Proje analizi tamamlandı!

📊 Proje Özeti:
- Framework: Laravel 11.x
- Models: 15 adet (User, Post, Comment...)
- Routes: 45 endpoint
- Database: 20 tablo

Artık isteklerinizi alabilirim.
```

---

## ÖRNEK NORMAL AKIŞ

**Kullanıcı:** "Şifre sıfırlama özelliği ekle"

**Claude (Knowledge Check):**
```
📚 Knowledge Loading...
- User model: email, password, remember_token
- Auth routes: /login, /register, /logout
- Mevcut auth sistemi: Laravel Breeze
```

**Claude (PM Mode):**
```
📋 PRODUCT MANAGER PHASE
========================
Mevcut auth yapısını inceledim...

[Task JSON oluşturur]

Bu task doğru mu?
```

...devam eder...

---

## CONFIG

### Laravel Project Requirements
```json
{
  "require": {
    "php": "^8.2",
    "laravel/framework": "^11.0"
  },
  "require-dev": {
    "laravel/dusk": "^8.0",
    "phpunit/phpunit": "^11.0"
  }
}
```
