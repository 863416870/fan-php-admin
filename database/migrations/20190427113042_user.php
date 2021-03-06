<?php

use think\migration\Migrator;

//php think migrate:run
class User extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('lin_user', array('engine' => 'InnoDB'));
        $table->addColumn('nickname', 'string', array('limit' => 24,'default'=>'','comment'=>'昵称'))
            ->addColumn('password', 'string', array('limit' => 100,'default'=>''))
            ->addColumn('email', 'string', array('limit' => 100,'default'=>''))
            ->addColumn('admin', 'integer', array('limit' => 6, 'default' => 1, 'comment' => '是否为超级管理员 ; 1 -> 普通用户 | 2 -> 超级管理员'))
            ->addColumn('active', 'integer', array('limit' => 6, 'default' => 1))
            ->addColumn('group_id', 'integer', array('limit' => 11, 'null' => 'null'))
            ->addColumn('create_time', 'integer',array('limit' => 10, 'default' => 0))
            ->addColumn('update_time', 'integer',array('limit' => 10, 'default' => 0))
            ->addSoftDelete()
            ->addIndex(array('nickname'), [
                'unique' => true,
                'name' => 'idx_users_nickname'])
            ->addIndex(array('email'), [
                'unique' => true,
                'name' => 'idx_users_email'])
            ->addIndex(array('admin'))
            ->create();
    }
}
