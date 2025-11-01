<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Підрахунок парних елементів</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card.even {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-card.total {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-card h3 {
            font-size: 0.9rem;
            margin-bottom: 10px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card .number {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .form-container {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        input[type="number"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input[type="number"]:focus {
            outline: none;
            border-color: #667eea;
        }

        .button-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        button {
            flex: 1;
            min-width: 150px;
            padding: 15px 25px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-clear {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .btn-clear:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
        }

        .numbers-list {
            max-height: 300px;
            overflow-y: auto;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 20px;
        }

        .numbers-list h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .number-item {
            display: inline-block;
            margin: 5px;
            padding: 10px 15px;
            background: #f8f9fa;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .number-item.even {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .number-item.odd {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .message.show {
            display: block;
        }

        /* Адаптивність */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.5rem;
            }

            .stat-card .number {
                font-size: 2rem;
            }

            .button-group {
                flex-direction: column;
            }

            button {
                width: 100%;
            }
        }

        /* Анімація завантаження */
        .loading {
            pointer-events: none;
            opacity: 0.6;
        }

        /* Скролбар */
        .numbers-list::-webkit-scrollbar {
            width: 8px;
        }

        .numbers-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .numbers-list::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }

        .numbers-list::-webkit-scrollbar-thumb:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Підрахунок парних елементів</h1>
            <p>Додавайте числа та переглядайте статистику в реальному часі</p>
        </div>

        <div class="content">
            <div id="message" class="message"></div>

            <div class="stats-container">
                <div class="stat-card even">
                    <h3>Парні числа</h3>
                    <div class="number" id="evenCount"><?= $evenCount ?></div>
                </div>
                <div class="stat-card total">
                    <h3>Всього чисел</h3>
                    <div class="number" id="totalCount"><?= $totalCount ?></div>
                </div>
            </div>

            <div class="form-container">
                <h3 style="margin-bottom: 20px; color: #333;">Додати одне число</h3>
                <form id="numberForm">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="numberInput">Введіть число:</label>
                        <input type="number" id="numberInput" name="value" placeholder="Наприклад: 42" required>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="btn-add">Додати число</button>
                        <button type="button" class="btn-clear" id="clearBtn">Очистити БД</button>
                    </div>
                </form>
            </div>

            <div class="form-container">
                <h3 style="margin-bottom: 20px; color: #333;">Генерувати випадкові числа</h3>
                <form id="randomForm">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="minValue">Мінімальне значення:</label>
                        <input type="number" id="minValue" name="min" placeholder="Наприклад: 1" value="1" required>
                    </div>
                    <div class="form-group">
                        <label for="maxValue">Максимальне значення:</label>
                        <input type="number" id="maxValue" name="max" placeholder="Наприклад: 100" value="100" required>
                    </div>
                    <div class="form-group">
                        <label for="countValue">Кількість чисел (1-1000):</label>
                        <input type="number" id="countValue" name="count" placeholder="Наприклад: 10" value="10" min="1" max="1000" required>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="btn-add">Згенерувати</button>
                    </div>
                </form>

                <!-- Блок попереднього перегляду -->
                <div id="generatedPreview" style="display: none; margin-top: 25px; padding: 20px; background: #fff3cd; border-radius: 10px; border: 2px solid #ffc107;">
                    <h4 style="color: #856404; margin-bottom: 15px;">Згенеровані числа (попередній перегляд)</h4>
                    <div id="previewNumbers" style="max-height: 200px; overflow-y: auto; margin-bottom: 15px;"></div>
                    <div class="button-group">
                        <button type="button" id="saveGeneratedBtn" class="btn-add" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            💾 Зберегти в БД
                        </button>
                        <button type="button" id="cancelGeneratedBtn" class="btn-clear">
                            ❌ Скасувати
                        </button>
                    </div>
                </div>
            </div>

            <div class="numbers-list">
                <h3>Список чисел:</h3>
                <div id="numbersList">
                    <?php if (empty($numbers)): ?>
                        <p style="color: #999;">Поки що немає чисел. Додайте перше число!</p>
                    <?php else: ?>
                        <?php foreach ($numbers as $number): ?>
                            <?php $isEven = $number['value'] % 2 === 0; ?>
                            <span class="number-item <?= $isEven ? 'even' : 'odd' ?>">
                                <?= esc($number['value']) ?>
                            </span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('numberForm');
        const clearBtn = document.getElementById('clearBtn');
        const numberInput = document.getElementById('numberInput');
        const evenCountEl = document.getElementById('evenCount');
        const totalCountEl = document.getElementById('totalCount');
        const numbersListEl = document.getElementById('numbersList');
        const messageEl = document.getElementById('message');

        // Показати повідомлення
        function showMessage(text, type) {
            messageEl.textContent = text;
            messageEl.className = `message ${type} show`;
            setTimeout(() => {
                messageEl.classList.remove('show');
            }, 3000);
        }

        // Оновити список чисел
        function updateNumbersList(numbers) {
            if (numbers.length === 0) {
                numbersListEl.innerHTML = '<p style="color: #999;">Поки що немає чисел. Додайте перше число!</p>';
                return;
            }

            numbersListEl.innerHTML = numbers.map(number => {
                const isEven = number.value % 2 === 0;
                return `<span class="number-item ${isEven ? 'even' : 'odd'}">${number.value}</span>`;
            }).join('');
        }

        // Додавання числа
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            try {
                form.classList.add('loading');
                const response = await fetch('<?= base_url('numbers/add') ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    evenCountEl.textContent = data.evenCount;
                    totalCountEl.textContent = data.totalCount;
                    updateNumbersList(data.numbers);
                    numberInput.value = '';
                    showMessage('Число успішно додано!', 'success');
                } else {
                    showMessage(data.message || 'Помилка при додаванні', 'error');
                }
            } catch (error) {
                showMessage('Помилка з\'єднання з сервером', 'error');
            } finally {
                form.classList.remove('loading');
            }
        });

        // Очищення БД
        clearBtn.addEventListener('click', async () => {
            if (!confirm('Ви впевнені, що хочете очистити всю базу даних?')) {
                return;
            }

            try {
                clearBtn.classList.add('loading');
                const csrfToken = document.querySelector('input[name="<?= csrf_token() ?>"]').value;
                const formData = new FormData();
                formData.append('<?= csrf_token() ?>', csrfToken);

                const response = await fetch('<?= base_url('numbers/clear') ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    evenCountEl.textContent = '0';
                    totalCountEl.textContent = '0';
                    numbersListEl.innerHTML = '<p style="color: #999;">Поки що немає чисел. Додайте перше число!</p>';
                    showMessage('База даних успішно очищена!', 'success');
                } else {
                    showMessage(data.message || 'Помилка при очищенні', 'error');
                }
            } catch (error) {
                showMessage('Помилка з\'єднання з сервером', 'error');
            } finally {
                clearBtn.classList.remove('loading');
            }
        });

        // Генерація випадкових чисел
        const randomForm = document.getElementById('randomForm');
        const generatedPreview = document.getElementById('generatedPreview');
        const previewNumbers = document.getElementById('previewNumbers');
        const saveGeneratedBtn = document.getElementById('saveGeneratedBtn');
        const cancelGeneratedBtn = document.getElementById('cancelGeneratedBtn');
        let currentGeneratedNumbers = [];

        randomForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(randomForm);

            try {
                randomForm.classList.add('loading');
                const response = await fetch('<?= base_url('numbers/generate') ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success && data.generated) {
                    currentGeneratedNumbers = data.generated;

                    // Показати попередній перегляд
                    previewNumbers.innerHTML = data.generated.map(num => {
                        const isEven = num % 2 === 0;
                        return `<span class="number-item ${isEven ? 'even' : 'odd'}">${num}</span>`;
                    }).join('');

                    generatedPreview.style.display = 'block';
                    showMessage(data.message, 'success');
                } else {
                    showMessage(data.message || 'Помилка при генерації', 'error');
                }
            } catch (error) {
                showMessage('Помилка з\'єднання з сервером', 'error');
            } finally {
                randomForm.classList.remove('loading');
            }
        });

        // Збереження згенерованих чисел
        saveGeneratedBtn.addEventListener('click', async () => {
            if (currentGeneratedNumbers.length === 0) {
                showMessage('Немає чисел для збереження', 'error');
                return;
            }

            try {
                saveGeneratedBtn.classList.add('loading');
                const csrfToken = document.querySelector('input[name="<?= csrf_token() ?>"]').value;
                const formData = new FormData();
                formData.append('<?= csrf_token() ?>', csrfToken);
                formData.append('numbers', JSON.stringify(currentGeneratedNumbers));

                const response = await fetch('<?= base_url('numbers/save') ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    evenCountEl.textContent = data.evenCount;
                    totalCountEl.textContent = data.totalCount;
                    updateNumbersList(data.numbers);
                    showMessage(data.message, 'success');

                    // Приховати попередній перегляд
                    generatedPreview.style.display = 'none';
                    currentGeneratedNumbers = [];
                    previewNumbers.innerHTML = '';
                } else {
                    showMessage(data.message || 'Помилка при збереженні', 'error');
                }
            } catch (error) {
                showMessage('Помилка з\'єднання з сервером', 'error');
            } finally {
                saveGeneratedBtn.classList.remove('loading');
            }
        });

        // Скасування генерації
        cancelGeneratedBtn.addEventListener('click', () => {
            generatedPreview.style.display = 'none';
            currentGeneratedNumbers = [];
            previewNumbers.innerHTML = '';
            showMessage('Генерацію скасовано', 'success');
        });
    </script>
</body>
</html>
