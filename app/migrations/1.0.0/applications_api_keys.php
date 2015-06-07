<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class ApplicationsApiKeysMigration_100 extends Migration
{

    public function up() {
        $this->morphTable('
            applications_api_keys', [
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
                new Column('api_key', [
                    'type' => Column::TYPE_VARCHAR,
                    'notNull' => true,
                    'size' => 255,
                    'after' => 'games_id'
                ]),
                new Column('private_key', [
                    'type' => Column::TYPE_VARCHAR,
                    'notNull' => true,
                    'size' => 255,
                    'after' => 'api_key'
                ]),
                new Column('status', [
                    'type' => Column::TYPE_CHAR,
                    'notNull' => true,
                    'size' => 1,
                    'after' => 'private_key'
                ]),
                new Column('description', [
                    'type' => Column::TYPE_VARCHAR,
                    'notNull' => true,
                    'size' => 255,
                    'after' => 'status'
                ]),
                new Column('created', [
                    'type' => Column::TYPE_DATETIME,
                    'notNull' => true,
                    'size' => 1,
                    'after' => 'description'
                ])
            ],
            'indexes' => [
                new Index('PRIMARY', ['id']),
                new Index('applications_id', ['applications_id']),
                new Index('api_key', ['api_key']),
                new Index('status', ['status'])
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
