<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MongoNumberModel;
use CodeIgniter\HTTP\ResponseInterface;

class NumberController extends BaseController
{
    protected $numberModel;

    public function __construct()
    {
        $this->numberModel = new MongoNumberModel();
    }

    /**
     * Головна сторінка з формою
     */
    public function index()
    {
        $data = [
            'numbers' => $this->numberModel->getAllNumbers(),
            'evenCount' => $this->numberModel->countEvenNumbers(),
            'totalCount' => $this->numberModel->countAllResults()
        ];

        return view('numbers/index', $data);
    }

    /**
     * Додавання нового числа (AJAX)
     */
    public function add()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Тільки AJAX запити']);
        }

        $value = $this->request->getPost('value');

        if ($value === null || $value === '') {
            return $this->response->setJSON(['success' => false, 'message' => 'Введіть число']);
        }

        $data = [
            'value' => (int)$value,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->numberModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'evenCount' => $this->numberModel->countEvenNumbers(),
                'totalCount' => $this->numberModel->countAllResults(),
                'numbers' => $this->numberModel->getAllNumbers()
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Помилка при додаванні']);
    }

    /**
     * Очищення бази даних (AJAX)
     */
    public function clear()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Тільки AJAX запити']);
        }

        if ($this->numberModel->clearAll()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'База даних очищена'
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Помилка при очищенні']);
    }

    /**
     * Отримання статистики (AJAX)
     */
    public function getStats()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Тільки AJAX запити']);
        }

        return $this->response->setJSON([
            'success' => true,
            'evenCount' => $this->numberModel->countEvenNumbers(),
            'totalCount' => $this->numberModel->countAllResults(),
            'numbers' => $this->numberModel->getAllNumbers()
        ]);
    }

    /**
     * Генерація випадкових чисел (тільки показати, не зберігати)
     */
    public function generateRandom()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Тільки AJAX запити']);
        }

        $min = $this->request->getPost('min');
        $max = $this->request->getPost('max');
        $count = $this->request->getPost('count');

        // Валідація
        if ($min === null || $max === null || $count === null) {
            return $this->response->setJSON(['success' => false, 'message' => 'Заповніть всі поля']);
        }

        $min = (int)$min;
        $max = (int)$max;
        $count = (int)$count;

        if ($min >= $max) {
            return $this->response->setJSON(['success' => false, 'message' => 'Мінімум має бути менше максимуму']);
        }

        if ($count < 1 || $count > 1000) {
            return $this->response->setJSON(['success' => false, 'message' => 'Кількість має бути від 1 до 1000']);
        }

        // Тільки генерація (без збереження в БД)
        $generatedNumbers = [];
        for ($i = 0; $i < $count; $i++) {
            $generatedNumbers[] = rand($min, $max);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => "Згенеровано {$count} чисел. Перегляньте їх нижче і натисніть 'Зберегти в БД'",
            'generated' => $generatedNumbers
        ]);
    }

    /**
     * Збереження згенерованих чисел в БД (AJAX)
     */
    public function saveGenerated()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Тільки AJAX запити']);
        }

        $numbersJson = $this->request->getPost('numbers');

        if (empty($numbersJson)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Немає чисел для збереження']);
        }

        $numbers = json_decode($numbersJson, true);

        if (!is_array($numbers)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Невірний формат даних']);
        }

        // Збереження в БД
        $saved = 0;
        foreach ($numbers as $value) {
            $data = [
                'value' => (int)$value,
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->numberModel->insert($data)) {
                $saved++;
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => "Успішно збережено {$saved} чисел в базу даних!",
            'evenCount' => $this->numberModel->countEvenNumbers(),
            'totalCount' => $this->numberModel->countAllResults(false),
            'numbers' => $this->numberModel->getAllNumbers()
        ]);
    }
}
