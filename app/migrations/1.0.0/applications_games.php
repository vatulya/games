<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class ApplicationsGamesMigration_100 extends Migration
{

    public function up() {
        $this->morphTable(
            'applications_games', [
            'columns' => [
                new Column('id', [
                    'type' => Column::TYPE_INTEGER,
                    'notNull' => true,
                    'autoIncrement' => true,
                    'size' => 11,
                    'first' => true
                ]),
                new Column('applications_id', [
                    'type' => Column::TYPE_INTEGER,
                    'notNull' => true,
                    'size' => 11,
                    'after' => 'id'
                ]),
                new Column('hash', [
                    'type' => Column::TYPE_VARCHAR,
                    'notNull' => true,
                    'size' => 50,
                    'after' => 'applications_id'
                ]),
                new Column('created', [
                    'type' => Column::TYPE_DATETIME,
                    'notNull' => true,
                    'size' => 1,
                    'after' => 'applications_id'
                ])
            ],
            'indexes' => [
                new Index('PRIMARY', ['id']),
                new Index('applications_id', ['applications_id']),
            ],
            'options' => [
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '1',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'utf8_unicode_ci'
            ]
        ]);
    }
}
