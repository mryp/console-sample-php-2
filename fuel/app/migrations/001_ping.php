<?php
namespace Fuel\Migrations;

class Ping
{
    function up()
    {
		//接続確認テーブル
        \DBUtil::create_table('ping', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true),
            'termid' => array('type' => 'int', 'constraint' => 11),
            'created_at' => array('type' => 'datetime'),
        ), array('id'), false, 'InnoDB');
        \DBUtil::create_index('ping', 'termid', 'ping_termid');
        \DBUtil::create_index('ping', 'created_at', 'ping_created_at');
    }

    function down()
    {
        \DBUtil::drop_table('ping');
    }
}