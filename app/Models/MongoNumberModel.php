<?php

namespace App\Models;

use MongoDB\Client;
use MongoDB\Collection;

class MongoNumberModel
{
    protected Client $client;
    protected Collection $collection;

    public function __construct()
    {
        // Підключення до MongoDB
        $this->client = new Client('mongodb://127.0.0.1:27017');
        $this->collection = $this->client->codeigniter->numbers;
    }

    /**
     * Додати число
     */
    public function insert(array $data): bool
    {
        try {
            $result = $this->collection->insertOne([
                'value' => (int)$data['value'],
                'created_at' => new \MongoDB\BSON\UTCDateTime()
            ]);

            return $result->getInsertedCount() > 0;
        } catch (\Exception $e) {
            log_message('error', 'MongoDB insert error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Підрахунок парних чисел
     */
    public function countEvenNumbers(): int
    {
        try {
            return $this->collection->countDocuments([
                '$expr' => [
                    '$eq' => [['$mod' => ['$value', 2]], 0]
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'MongoDB count error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Отримати всі числа
     */
    public function getAllNumbers(): array
    {
        try {
            $cursor = $this->collection->find(
                [],
                ['sort' => ['_id' => -1]]
            );

            $numbers = [];
            foreach ($cursor as $document) {
                $numbers[] = [
                    'id' => (string)$document['_id'],
                    'value' => $document['value'],
                    'created_at' => $document['created_at']->toDateTime()->format('Y-m-d H:i:s')
                ];
            }

            return $numbers;
        } catch (\Exception $e) {
            log_message('error', 'MongoDB find error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Загальна кількість чисел
     */
    public function countAllResults(): int
    {
        try {
            return $this->collection->countDocuments([]);
        } catch (\Exception $e) {
            log_message('error', 'MongoDB count error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Очистити колекцію
     */
    public function clearAll(): bool
    {
        try {
            $result = $this->collection->deleteMany([]);
            return true;
        } catch (\Exception $e) {
            log_message('error', 'MongoDB delete error: ' . $e->getMessage());
            return false;
        }
    }
}
