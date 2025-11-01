<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNumbersTable extends Migration
{
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

    public function down()
    {
        $this->forge->dropTable('numbers');
    }
}
