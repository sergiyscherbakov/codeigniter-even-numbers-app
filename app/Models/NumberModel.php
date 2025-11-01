<?php

namespace App\Models;

use CodeIgniter\Model;

class NumberModel extends Model
{
    protected $table            = 'numbers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['value', 'created_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'value' => 'required|integer'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Підрахунок кількості парних елементів
     */
    public function countEvenNumbers(): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE value % 2 = 0";
        $result = $this->db->query($sql)->getRow();
        return (int)$result->count;
    }

    /**
     * Отримати всі числа
     */
    public function getAllNumbers(): array
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }

    /**
     * Очистити базу даних
     */
    public function clearAll(): bool
    {
        return $this->db->table($this->table)->truncate();
    }
}
