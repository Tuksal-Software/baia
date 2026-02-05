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

## 🚀 TASK-BASED WORKFLOW

**HER KULLANICI İSTEĞİ BİR TASK DOSYASI OLUŞTURUR!**

### Task Dosya Yapısı
```
.claude/tasks/
├── task-template.json           # Şablon
├── 2026-02-05_001_slug-fix.json # Örnek task
├── 2026-02-05_002_feature-x.json
└── ...
```

### Task ID Format
```
{YYYY-MM-DD}_{SEQ}_{short-description}.json
Örnek: 2026-02-05_001_slug-duplicate-fix.json
```

---

## WORKFLOW ADIMLARI

```
┌─────────────────────────────────────────────────────────────────────┐
│                    KULLANICI İSTEĞİ                                 │
└───────────────────────────┬─────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────────┐
│  📋 ADIM 1: PRODUCT MANAGER                                         │
│  ─────────────────────────────────────────────────────────────────  │
│  1. Task JSON dosyası oluştur (.claude/tasks/)                      │
│  2. user_prompt, analysis, affected_files, acceptance_criteria doldur│
│  3. Edge case'leri listele                                          │
│  4. Task dosyasını KAYDET                                           │
└───────────────────────────┬─────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────────┐
│  💻 ADIM 2: DEVELOPER                                               │
│  ─────────────────────────────────────────────────────────────────  │
│  1. Task JSON'dan acceptance_criteria oku                           │
│  2. affected_files'ı tara ve değiştir                               │
│  3. Task JSON'a developer.changes ekle                              │
│  4. Knowledge dosyalarını güncelle                                  │
└───────────────────────────┬─────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────────┐
│  🧪 ADIM 3: QA AGENT                                                │
│  ─────────────────────────────────────────────────────────────────  │
│  1. acceptance_criteria'yı kontrol et                               │
│  2. edge_cases'i test et (teorik)                                   │
│  3. Task JSON'a qa section ekle                                     │
│  4. Kullanıcının test etmesi gerekenleri listele                    │
└───────────────────────────┬─────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────────┐
│  ✅ ADIM 4: SONUÇ                                                   │
│  ─────────────────────────────────────────────────────────────────  │
│  1. Task JSON'a result section ekle                                 │
│  2. status: completed yap                                           │
│  3. Kullanıcıya özet rapor ver                                      │
│  4. Task dosya yolunu bildir                                        │
└─────────────────────────────────────────────────────────────────────┘
```

---

## TASK JSON YAPISI

```json
{
  "id": "2026-02-05_001",
  "timestamp": "2026-02-05T15:30:00Z",
  "status": "pending | in_progress | completed | failed",

  "user_prompt": "Kullanıcının yazdığı orijinal istek",

  "product_manager": {
    "analysis": "Ne yapılması gerekiyor?",
    "affected_files": ["dosya1.php", "dosya2.blade.php"],
    "acceptance_criteria": ["Kriter 1", "Kriter 2"],
    "edge_cases": ["Edge case 1", "Edge case 2"],
    "priority": "high | medium | low"
  },

  "developer": {
    "approach": "Teknik çözüm yaklaşımı",
    "changes": [
      {"file": "x.php", "action": "modify", "description": "Ne yapıldı"}
    ]
  },

  "qa": {
    "tests_performed": ["Test 1", "Test 2"],
    "issues_found": [],
    "user_should_test": ["Kullanıcı şunu test etmeli"]
  },

  "result": {
    "success": true,
    "summary": "Özet",
    "user_action_required": "Varsa kullanıcının yapması gereken"
  }
}
```

---

## ÇIKTI FORMATI

Her task tamamlandığında kullanıcıya şu formatta rapor ver:

```
📋 TASK: {task_id}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

📝 İSTEK:
{user_prompt}

🔍 ANALİZ:
{product_manager.analysis}

📁 ETKİLENEN DOSYALAR:
- {file1}
- {file2}

✅ ACCEPTANCE CRITERIA:
- [ ] {criteria1}
- [ ] {criteria2}

💻 YAPILAN DEĞİŞİKLİKLER:
- {change1}
- {change2}

🧪 QA - KULLANICININ TEST ETMESİ GEREKENLER:
- {test1}
- {test2}

📄 TASK DOSYASI: .claude/tasks/{task_id}.json
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

---

## ZORUNLU KURALLAR

### ❌ YAPMA:
- Task dosyası oluşturmadan kod yazma
- acceptance_criteria belirlemeden geliştirme yapma
- QA section'ı boş bırakma
- "Devam edeyim mi?" diye sorma

### ✅ YAP:
- HER istek için task JSON oluştur
- TÜM affected_files'ı tara
- Edge case'leri düşün ve listele
- Kullanıcının test etmesi gerekenleri belirt
- Task dosya yolunu kullanıcıya bildir

---

## AGENT DOSYALARI

| Agent | Dosya | Rol |
|-------|-------|-----|
| Product Manager | `.claude/product-manager.md` | Task analizi, planlama |
| Senior Laravel Dev | `.claude/laravel-developer.md` | Kod yazma |
| QA Engineer | `.claude/qa-agent.md` | Test, validation |

## KNOWLEDGE DOSYALARI

| Dosya | İçerik |
|-------|--------|
| `knowledge/project-structure.md` | Genel mimari |
| `knowledge/models.md` | Model ve ilişkiler |
| `knowledge/routes.md` | API/Web routes |
| `knowledge/database.md` | DB şeması |
| `knowledge/changelog.md` | Değişiklik logu |
| `MEMORY.md` | Öğrenilen dersler, hatalar |
| `tasks/*.json` | Task geçmişi |

---

## ÖRNEK

**Kullanıcı:** "Slug duplicate hatası var"

**Claude:**
1. `.claude/tasks/2026-02-05_001_slug-duplicate-fix.json` oluşturur
2. PM section doldurur (analysis, affected_files, criteria)
3. Developer section doldurur (approach, changes)
4. QA section doldurur (tests, user_should_test)
5. Kullanıcıya rapor verir + task dosya yolunu bildirir

Kullanıcı `.claude/tasks/` klasörüne bakarak tüm geçmişi görebilir.
