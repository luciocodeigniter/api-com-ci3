<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_printers extends CI_Migration
{
    public function up()
    {

        $this->dbforge->add_field(
            [
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true
                ],

                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ],

                'brand' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ],

                'model' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ],

                'location' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ],

                'active' => [
                    'type' => 'TINYINT',
                    'constraint' => '1',
                    'default'    => 1
                ],

                'created_at' => [
                    'type' => 'DATETIME',
                ],

                'updated_at' => [
                    'type' => 'DATETIME',
                ],
            ]
        );

        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('printers');
    }

    public function down()
    {
        $this->dbforge->drop_table('printers');
    }
}
