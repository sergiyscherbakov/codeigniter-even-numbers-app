# Підрахунок парних елементів - CodeIgniter 4

![PHP](https://img.shields.io/badge/PHP-8.1-777BB4?style=for-the-badge&logo=php&logoColor=white) ![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white) ![MongoDB](https://img.shields.io/badge/MongoDB-2.1-47A248?style=for-the-badge&logo=mongodb&logoColor=white) ![Composer](https://img.shields.io/badge/Composer-2.0-885630?style=for-the-badge&logo=composer&logoColor=white)

## Автор

**Розробник:** Сергій Щербаков
**Email:** sergiyscherbakov@ukr.net
**Telegram:** @s_help_2010

### 💰 Підтримати розробку
Задонатити на каву USDT (BINANCE SMART CHAIN):
**`0xDFD0A23d2FEd7c1ab8A0F9A4a1F8386832B6f95A`**

---

Веб-додаток для підрахунку кількості парних чисел з красивим адаптивним дизайном та MongoDB для зберігання даних.

## Швидкий старт

### 0. Вимоги
- PHP 8.2+
- MongoDB Server (має бути запущений на `localhost:27017`)

### 1. Запуск сервера
```bash
cd even-numbers-app
php spark serve --host=0.0.0.0 --port=8080
```

### 2. Відкрити в браузері
```
http://localhost:8080
```

### 3. Використання
- Введіть число в поле форми
- Натисніть "Додати число"
- Переглядайте статистику парних чисел в реальному часі
- Натисніть "Очистити БД" для видалення всіх даних

---

## Технології
- **CodeIgniter 4.6.3**
- **PHP 8.2.12**
- **MongoDB 2.1** (mongodb/mongodb)
- **Адаптивний дизайн**
- **AJAX без перезавантаження сторінки**

---

## Основні файли

| Файл | Опис |
|------|------|
| `app/Controllers/NumberController.php` | API для роботи з числами |
| `app/Models/MongoNumberModel.php` | Логіка підрахунку парних чисел (MongoDB) |
| `app/Views/numbers/index.php` | Інтерфейс користувача |
| `app/Config/Routes.php` | Маршрути додатку |
| `PROJECT_INFO.md` | Повна документація |

---

## Функції

✅ Додавання чисел
✅ Автоматичний підрахунок парних елементів
✅ Візуальне розрізнення парних/непарних (кольори)
✅ Очищення бази даних
✅ Адаптивний дизайн для мобільних
✅ AJAX без перезавантаження
✅ Підтримка множинних з'єднань

---

## Команди

```bash
# Запуск сервера
php spark serve --port=8080

# Міграції
php spark migrate

# Очистити кеш
php spark cache:clear

# Переглянути маршрути
php spark routes
```

---

## MongoDB команди

### Підключення до MongoDB
```bash
# Запуск MongoDB shell
mongosh

# Або підключення до конкретної бази
mongosh mongodb://127.0.0.1:27017/codeigniter
```

### Перевірка даних
```javascript
// Переключитися на базу даних
use codeigniter

// Переглянути всі числа
db.numbers.find()

// Переглянути всі числа (форматовано)
db.numbers.find().pretty()

// Підрахувати всі записи
db.numbers.countDocuments()

// Підрахувати парні числа
db.numbers.countDocuments({ $expr: { $eq: [{ $mod: ["$value", 2] }, 0] } })

// Переглянути лише парні числа
db.numbers.find({ $expr: { $eq: [{ $mod: ["$value", 2] }, 0] } })

// Переглянути лише непарні числа
db.numbers.find({ $expr: { $ne: [{ $mod: ["$value", 2] }, 0] } })

// Переглянути останні 10 записів
db.numbers.find().sort({ _id: -1 }).limit(10)
```

### Очищення даних
```javascript
// Видалити всі записи з колекції
db.numbers.deleteMany({})

// Видалити колекцію повністю
db.numbers.drop()

// Переглянути всі колекції в базі
show collections
```

### Статистика
```javascript
// Отримати статистику колекції
db.numbers.stats()

// Агрегація: кількість парних і непарних
db.numbers.aggregate([
  {
    $group: {
      _id: { $mod: ["$value", 2] },
      count: { $sum: 1 }
    }
  },
  {
    $project: {
      type: { $cond: [{ $eq: ["$_id", 0] }, "парні", "непарні"] },
      count: 1,
      _id: 0
    }
  }
])
```

### Експорт/Імпорт даних
```bash
# Експорт колекції в JSON
mongoexport --db=codeigniter --collection=numbers --out=numbers.json

# Імпорт колекції з JSON
mongoimport --db=codeigniter --collection=numbers --file=numbers.json
```

---

## Структура БД (MongoDB)

**База даних:** `codeigniter`
**Колекція:** `numbers`

**Структура документа:**
```json
{
  "_id": ObjectId("..."),
  "value": 42,
  "created_at": ISODate("2025-10-25T16:30:00.000Z")
}
```

---

## Підтримка

Детальна документація: `PROJECT_INFO.md`

**Версія**: 1.0.0
**Дата**: 25 жовтня 2025
