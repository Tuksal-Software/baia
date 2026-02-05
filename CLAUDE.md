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

---

## 🚀 TAMAMEN OTOMATİK WORKFLOW

**KULLANICI BİR İSTEK VERDİĞİNDE TÜM ADIMLAR OTOMATİK ÇALIŞIR - KULLANICIDAN ONAY BEKLEME!**

```
┌─────────────────────────────────────────────────────────────────────┐
│                    KULLANICI İSTEĞİ                                 │
└───────────────────────────┬─────────────────────────────────────────┘
                            │
                            ▼ (OTOMATİK)
┌─────────────────────────────────────────────────────────────────────┐
│  📋 PRODUCT MANAGER: Task analizi ve planlama                       │
└───────────────────────────┬─────────────────────────────────────────┘
                            │
                            ▼ (OTOMATİK - BEKLEME YOK)
┌─────────────────────────────────────────────────────────────────────┐
│  💻 DEVELOPER: Kod yazma + Knowledge güncelleme                     │
└───────────────────────────┬─────────────────────────────────────────┘
                            │
                            ▼ (OTOMATİK - BEKLEME YOK)
┌─────────────────────────────────────────────────────────────────────┐
│  🧪 QA AGENT: Test etme + Bug raporlama                             │
└───────────────────────────┬─────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────────┐
│  ✅ SONUÇ: Kullanıcıya özet rapor                                   │
└─────────────────────────────────────────────────────────────────────┘
```

---

## ADIM 1: KNOWLEDGE CHECK (Sessiz)

```
1. .claude/knowledge/ dosyalarını oku
2. İlgili modelleri, route'ları, servisleri HATIRLA
3. Mevcut yapıyı anla
```

---

## ADIM 2: PRODUCT MANAGER PHASE (Otomatik)

`.claude/product-manager.md` kurallarına göre:
1. **Knowledge'dan** mevcut yapıyı kontrol et
2. İsteği analiz et
3. Task planı oluştur (acceptance criteria dahil)
4. **KULLANICIDAN ONAY BEKLEME** - direkt Developer phase'e geç

---

## ADIM 3: DEVELOPER PHASE (Otomatik)

`.claude/laravel-developer.md` kurallarına göre:
1. **Knowledge'dan** ilgili kodları oku
2. Mevcut pattern'leri takip et
3. Laravel best practices ile kodu yaz
4. **Knowledge dosyalarını GÜNCELLE**
5. **KULLANICIDAN ONAY BEKLEME** - direkt QA phase'e geç

---

## ADIM 4: QA PHASE (Otomatik)

**⚠️ BU ADIM HER ZAMAN ÇALIŞIR - ATLAMA!**

`.claude/qa-agent.md` kurallarına göre:
1. Yapılan değişiklikleri test et
2. Siteyi browser'da test et (mümkünse)
3. Edge case'leri kontrol et
4. Bug varsa raporla ve düzelt
5. Final rapor oluştur

### QA Kontrol Listesi:
- [ ] Sayfa yükleniyor mu?
- [ ] Görseller görünüyor mu?
- [ ] Linkler çalışıyor mu?
- [ ] Mobile responsive mi?
- [ ] Console'da hata var mı?
- [ ] PHP/Laravel hataları var mı?

---

## WORKFLOW KURALLARI

### ❌ YAPMA:
- Kullanıcıdan onay bekleme
- "Devam edeyim mi?" diye sorma
- QA phase'i atlama
- Knowledge güncellemeyi unutma

### ✅ YAP:
- Tüm adımları otomatik çalıştır
- Her adımı sessizce tamamla
- Sadece sonuçları raporla
- Hata varsa düzelt ve devam et

---

## AGENT DOSYALARI

| Agent | Dosya | Rol |
|-------|-------|-----|
| Product Manager | `.claude/product-manager.md` | Task analizi, planlama |
| Senior Laravel Dev | `.claude/laravel-developer.md` | Kod yazma |
| QA Engineer | `.claude/qa-agent.md` | Test, validation |

## CODING STANDARDS

| Framework | Dosya |
|-----------|-------|
| Laravel | `.claude/coding-standards/laravel.md` |

## KNOWLEDGE DOSYALARI

| Dosya | İçerik |
|-------|--------|
| `project-structure.md` | Genel mimari |
| `models.md` | Model ve ilişkiler |
| `routes.md` | API/Web routes |
| `database.md` | DB şeması |
| `services.md` | Business logic |
| `frontend.md` | UI yapısı |
| `changelog.md` | Değişiklik logu |

---

## ÖRNEK AKIŞ

**Kullanıcı:** "Navbar'a arama özelliği ekle"

**Claude (Otomatik - Sessiz):**
```
📋 PM: Arama özelliği planlanıyor...
💻 DEV: SearchController oluşturuluyor...
💻 DEV: search.blade.php oluşturuluyor...
💻 DEV: Route ekleniyor...
📝 Knowledge güncelleniyor...
🧪 QA: Test ediliyor...
```

**Claude (Kullanıcıya Rapor):**
```
✅ Arama özelliği eklendi!

Yapılanlar:
- SearchController oluşturuldu
- /ara route'u eklendi
- Navbar'a arama ikonu eklendi

QA Sonucu:
- ✅ Sayfa yükleniyor
- ✅ Arama çalışıyor
- ✅ Sonuçlar gösteriliyor

Dosyalar:
- app/Http/Controllers/SearchController.php
- resources/views/search/index.blade.php
- routes/web.php (güncellendi)
```

---

## CONFIG

### Laravel Project Requirements
```json
{
  "require": {
    "php": "^8.2",
    "laravel/framework": "^12.0"
  }
}
```
