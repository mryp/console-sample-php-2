<?php
namespace Fuel\Migrations;

class Sitesetting
{
    function up()
    {
		//全般設定テーブル
        \DBUtil::create_table('sitesetting', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true),
            'servicename' => array('type' => 'text'),
            'footer' => array('type' => 'text'),
            'created_at' => array('type' => 'datetime'),
            'updated_at' => array('type' => 'datetime'),
        ), array('id'), false, 'InnoDB');
    }

    function down()
    {
        \DBUtil::drop_table('sitesetting');
    }
}