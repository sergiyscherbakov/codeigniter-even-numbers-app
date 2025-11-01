# Проєкт: Підрахунок парних елементів

## Опис проєкту
Веб-додаток на CodeIgniter 4 для підрахунку кількості парних елементів з SQLite базою даних.

## Дата створення
25 жовтня 2025 року

## Технології
- **Framework**: CodeIgniter 4.6.3
- **PHP**: 8.2.12
- **База даних**: SQLite3
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Стиль**: Адаптивний дизайн з градієнтами

---

## Структура проєкту

### 1. База даних
**Файл**: `writable/database.db`
**Конфігурація**: `app/Config/Database.php` (рядок 27-42)

**Таблиця `numbers`:**
```sql
CREATE TABLE numbers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    value INTEGER NOT NULL,
    created_at DATETIME
);
```

### 2. Міграції
**Файл**: `app/Database/Migrations/2025-10-25-104131_CreateNumbersTable.php`

```php
public function up()
{
    $this->forge->addField([
        'id' => [
            'type'           => 'INTEGER',
            'auto_increment' => true,
        ],
        'value' => [
            'type'       => 'INTEGER',
            'null'       => false,
        ],
        'created_at' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->createTable('numbers');
}
```

### 3. Модель
**Файл**: `app/Models/NumberModel.php`

**Основні методи:**
- `countEvenNumbers(): int` - підрахунок парних чисел (рядок 52-55)
- `getAllNumbers(): array` - отримання всіх чисел (рядок 60-63)
- `clearAll(): bool` - очищення БД (рядок 68-71)

**Валідація:**
```php
protected $validationRules = [
    'value' => 'required|integer'
];
```

### 4. Контролер
**Файл**: `app/Controllers/NumberController.php`

**Маршрути та методи:**

| Метод | URL | Тип | Опис |
|-------|-----|-----|------|
| `index()` | `/` | GET | Головна сторінка (рядок 21-29) |
| `add()` | `/numbers/add` | POST (AJAX) | Додавання числа (рядок 35-62) |
| `clear()` | `/numbers/clear` | POST (AJAX) | Очищення БД (рядок 67-81) |
| `getStats()` | `/numbers/stats` | GET (AJAX) | Отримання статистики (рядок 86-98) |

### 5. Маршрути
**Файл**: `app/Config/Routes.php`

```php
$routes->get('/', 'NumberController::index');
$routes->post('numbers/add', 'NumberController::add');
$routes->post('numbers/clear', 'NumberController::clear');
$routes->get('numbers/stats', 'NumberController::getStats');
```

### 6. View (Інтерфейс)
**Файл**: `app/Views/numbers/index.php`

**Особливості дизайну:**
- Gradient background: `linear-gradient(135deg, #667eea 0%, #764ba2 100%)`
- Адаптивна верстка (mobile-first)
- Анімації при hover
- AJAX запити без перезавантаження сторінки
- Автоматичне оновлення статистики
- Розрізнення парних/непарних чисел кольором

**Компоненти:**
1. **Статистика** - 2 картки з кількістю парних та всіх чисел
2. **Форма вводу** - поле для введення числа з CSRF захистом
3. **Кнопки** - "Додати число" та "Очистити БД"
4. **Список чисел** - відображення всіх доданих чисел

---

## Налаштування

### PHP розширення
У файлі `C:\xampp\php\php.ini` активовано:
```ini
extension=sqlite3    # рядок 959
extension=pdo_sqlite # рядок 948
```

### База даних
**Файл конфігурації**: `app/Config/Database.php`
```php
public array $default = [
    'database'    => WRITEPATH . 'database.db',
    'DBDriver'    => 'SQLite3',
    'DBPrefix'    => '',
    'DBDebug'     => true,
    'foreignKeys' => true,
    'busyTimeout' => 1000,
];
```

### CSRF захист
CSRF токени автоматично додаються до форм через `<?= csrf_field() ?>`

---

## Запуск проєкту

### 1. Запуск сервера
```bash
cd even-numbers-app
php spark serve --host=0.0.0.0 --port=8080
```

### 2. Доступ до додатку
**URL**: http://localhost:8080

### 3. Зупинка сервера
Натисніть `Ctrl+C` в терміналі

### 4. Запуск міграцій (якщо потрібно)
```bash
cd even-numbers-app
php spark migrate
```

### 5. Відкат міграцій
```bash
php spark migrate:rollback
```

---

## Функціональність

### 1. Додавання числа
- Введіть число в поле форми
- Натисніть "Додати число"
- Число зберігається в БД
- Автоматично оновлюється:
  - Кількість парних чисел
  - Загальна кількість чисел
  - Список всіх чисел

### 2. Візуалізація
- **Парні числа**: синій градієнт `linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)`
- **Непарні числа**: рожевий градієнт `linear-gradient(135deg, #f093fb 0%, #f5576c 100%)`

### 3. Очищення БД
- Натисніть кнопку "Очистити БД"
- Підтвердіть дію
- Всі записи видаляються
- Статистика скидається до нуля

### 4. Підтримка множинних з'єднань
Сервер підтримує багато одночасних з'єднань завдяки:
- Вбудованому PHP Development Server
- SQLite з `busyTimeout = 1000ms`
- AJAX запитам без блокування

---

## API Endpoints

### POST /numbers/add
**Параметри:**
```json
{
  "value": 42,
  "csrf_token": "token_value"
}
```

**Відповідь (success):**
```json
{
  "success": true,
  "evenCount": 5,
  "totalCount": 10,
  "numbers": [
    {"id": 1, "value": 42, "created_at": "2025-10-25 14:00:00"},
    ...
  ]
}
```

**Відповідь (error):**
```json
{
  "success": false,
  "message": "Введіть число"
}
```

### POST /numbers/clear
**Відповідь:**
```json
{
  "success": true,
  "message": "База даних очищена"
}
```

### GET /numbers/stats
**Відповідь:**
```json
{
  "success": true,
  "evenCount": 5,
  "totalCount": 10,
  "numbers": [...]
}
```

---

## Особливості реалізації

### 1. Підрахунок парних чисел
```php
// NumberModel.php (рядок 52-55)
public function countEvenNumbers(): int
{
    return $this->where('value % 2', 0)->countAllResults();
}
```

### 2. AJAX запити
```javascript
// index.php (рядок 353-385)
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(form);

    const response = await fetch('/numbers/add', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    });

    const data = await response.json();
    // Оновлення UI
});
```

### 3. Безпека
- CSRF токени для всіх POST запитів
- Валідація даних на рівні моделі
- Перевірка AJAX запитів у контролері
- Екранування виводу через `esc()`

---

## Адаптивність

### Брейкпоінти
```css
@media (max-width: 768px) {
    /* Мобільні пристрої */
    .header h1 { font-size: 1.5rem; }
    .stat-card .number { font-size: 2rem; }
    .button-group { flex-direction: column; }
}
```

### Grid система
```css
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}
```

---

## Структура файлів

```
even-numbers-app/
├── app/
│   ├── Config/
│   │   ├── Database.php          # Конфігурація БД
│   │   ├── Routes.php            # Маршрути
│   │   └── Security.php          # CSRF налаштування
│   ├── Controllers/
│   │   └── NumberController.php  # Контролер чисел
│   ├── Database/
│   │   └── Migrations/
│   │       └── 2025-10-25-104131_CreateNumbersTable.php
│   ├── Models/
│   │   └── NumberModel.php       # Модель чисел
│   └── Views/
│       └── numbers/
│           └── index.php         # Головний view
├── public/
│   └── index.php                 # Entry point
├── writable/
│   └── database.db               # SQLite БД
├── vendor/                       # Composer залежності
└── composer.json                 # Залежності проєкту
```

---

## Вимоги

### Мінімальні:
- PHP >= 8.1
- SQLite3 extension
- PDO SQLite extension
- Composer

### Поточні:
- PHP 8.2.12
- SQLite 3.x (вбудована в MongoDB 8.0.13)
- XAMPP

---

## Тестування

### Перевірка підрахунку парних чисел:
1. Додайте числа: 2, 3, 4, 5, 6
2. Парні числа: 2, 4, 6 = **3 парних**
3. Всього чисел: **5**

### Перевірка множинних з'єднань:
1. Відкрийте додаток в 3-х різних вкладках браузера
2. Додавайте числа одночасно з різних вкладок
3. Всі вкладки повинні оновлюватись коректно

---

## Можливі покращення

1. **Пагінація** - для великої кількості чисел
2. **WebSocket** - для real-time оновлення між користувачами
3. **Статистика** - графіки розподілу парних/непарних
4. **Експорт** - вивантаження даних в CSV/JSON
5. **Фільтри** - показувати тільки парні або непарні
6. **Історія** - логування всіх операцій
7. **Автентифікація** - багатокористувацька система
8. **API документація** - Swagger/OpenAPI
9. **Unit тести** - PHPUnit тести
10. **Docker** - контейнеризація проєкту

---

## Troubleshooting

### Проблема: SQLite3 extension не завантажена
**Рішення:**
```ini
# У файлі C:\xampp\php\php.ini
extension=sqlite3
```
Перезапустіть сервер після змін.

### Проблема: CSRF token mismatch
**Рішення:**
Переконайтеся, що форма містить `<?= csrf_field() ?>`

### Проблема: Помилка доступу до БД
**Рішення:**
Переконайтеся, що папка `writable/` має права на запис.

### Проблема: Порт 8080 зайнятий
**Рішення:**
```bash
php spark serve --port=8081
```

---

## Контакти та підтримка

**Розробник**: Claude Code
**Дата**: 25 жовтня 2025
**Версія проєкту**: 1.0.0
**CodeIgniter**: 4.6.3

---

## Ліцензія

Проєкт створено для навчальних цілей в рамках аспірантури ЗНТУ 124.

---

## Команди для роботи з проєктом

```bash
# Встановлення залежностей
composer install

# Запуск міграцій
php spark migrate

# Запуск сервера
php spark serve --host=0.0.0.0 --port=8080

# Перегляд маршрутів
php spark routes

# Очищення кешу
php spark cache:clear

# Створення нового контролера
php spark make:controller ControllerName

# Створення нової моделі
php spark make:model ModelName

# Створення нової міграції
php spark make:migration MigrationName
```

---

## Логи та Debugging

### Логи сервера:
```bash
# Переглянути логи у терміналі де запущено сервер
```

### Логи додатку:
```
writable/logs/log-YYYY-MM-DD.log
```

### Debug режим:
У файлі `.env`:
```
CI_ENVIRONMENT = development
```

---

## Висновок

Проєкт успішно реалізує всі вимоги:
- ✅ Підключення CodeIgniter до бази даних без пароля
- ✅ Можливість вручну вводити числа через форму
- ✅ Збереження в БД
- ✅ Очищення БД
- ✅ Підрахунок кількості парних елементів
- ✅ Підтримка множинних з'єднань
- ✅ Красивий адаптивний дизайн з web-інтерфейсом
- ✅ Сервер запущено і працює

**Доступ до додатку**: http://localhost:8080
