<?php

use yii\db\Migration;
use yii\db\Schema;

class m160812_091730_blog extends Migration
{
    public function up()
    {

        $this->createTable($this->db->tablePrefix.'blog_category', [
            'id' => 'pk',
            'title' => Schema::TYPE_STRING . '(65) NOT NULL',
            'parent_id' => Schema::TYPE_INTEGER,
            'description' => Schema::TYPE_TEXT.' NOT NULL',
            'image' => Schema::TYPE_STRING.'',
            'status' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT TRUE',
            'isdel' => Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 0',
        ]);
        $this->createIndex($this->db->tablePrefix.'blog_category_title'.'_key', $this->db->tablePrefix.'blog_category', 'title', true);
        $this->addForeignKey( $this->db->tablePrefix.'blog_category_parent_id', $this->db->tablePrefix.'blog_category', 'parent_id', $this->db->tablePrefix.'blog_category', 'id', 'SET NULL', null );


        $this->createTable($this->db->tablePrefix.'blog_post', [
            'id' => 'pk',
            'title' => Schema::TYPE_STRING . '(65) NOT NULL',
            'description' => Schema::TYPE_STRING . '(155) NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'tags' => Schema::TYPE_STRING . '',
            'image' => Schema::TYPE_TEXT . '',
            'author_id' => Schema::TYPE_INTEGER,
            'isfeatured' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT TRUE',
            'status' => Schema::TYPE_SMALLINT. ' NOT NULL DEFAULT 1',
            'time' => Schema::TYPE_TIMESTAMP. ' NOT NULL DEFAULT NOW()',
            'isdel' => Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 0',
        ]);
        $this->addForeignKey( $this->db->tablePrefix.'blog_post_author_id', $this->db->tablePrefix.'blog_post', 'author_id', $this->db->tablePrefix.'user', 'id', 'SET NULL', null );


        $this->createTable($this->db->tablePrefix.'blog_cat_pos', [
            'category_id' => Schema::TYPE_INTEGER. ' NOT NULL',
            'post_id' => Schema::TYPE_INTEGER. ' NOT NULL',
            'isdel' => Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 0',
        ]);
        $this->addForeignKey( $this->db->tablePrefix.'blog_cat_pos_category_id', $this->db->tablePrefix.'blog_cat_pos', 'category_id', $this->db->tablePrefix.'blog_category', 'id', 'CASCADE', null );
        $this->addForeignKey( $this->db->tablePrefix.'blog_cat_pos_post_id', $this->db->tablePrefix.'blog_cat_pos', 'post_id', $this->db->tablePrefix.'blog_post', 'id', 'CASCADE', null );
    }

    public function down()
    {
        echo "m160812_091730_blog cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
