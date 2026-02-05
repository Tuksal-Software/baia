# Changelog

Tüm değişiklikler bu dosyada loglanır. En yeni değişiklik en üstte.

---

## [YYYY-MM-DD] - TASK-XXX: [Task Title]

### Added
- [Yeni eklenen özellik/dosya]
- [Yeni eklenen özellik/dosya]

### Changed
- [Değiştirilen dosya/davranış]

### Fixed
- [Düzeltilen bug]

### Removed
- [Silinen dosya/özellik]

### Files Modified
| File | Change Type | Description |
|------|-------------|-------------|
| app/Models/User.php | Modified | Avatar field eklendi |
| app/Http/Controllers/AvatarController.php | Created | Yeni controller |
| database/migrations/xxx_add_avatar_to_users.php | Created | Migration |
| tests/Feature/AvatarTest.php | Created | Feature testleri |

### Database Changes
- `users` tablosuna `avatar_path` kolonu eklendi

### New Routes
| Method | URI | Name |
|--------|-----|------|
| POST | /api/user/avatar | user.avatar.update |
| DELETE | /api/user/avatar | user.avatar.delete |

### Dependencies Added
- intervention/image: ^3.0

### QA Status
- [x] Unit tests passed
- [x] Feature tests passed
- [x] UI tests passed
- [ ] Manual QA passed

### Notes
[Varsa ekstra notlar]

---

## [YYYY-MM-DD] - TASK-XXX: [Previous Task]

...

---

## Legend

### Change Types
- **Created**: Yeni dosya oluşturuldu
- **Modified**: Mevcut dosya değiştirildi
- **Deleted**: Dosya silindi
- **Renamed**: Dosya yeniden adlandırıldı

### Status Icons
- [x] Tamamlandı
- [ ] Beklemede
- [!] Dikkat gerekli
