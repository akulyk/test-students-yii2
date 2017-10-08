<?php

use yii\db\Migration;

class m171007_202258_add_students_table extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%student}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(50)->notNull(),
            'lastname' => $this->string(50)->notNull(),
            'birthdate' => $this->integer()->notNull(),
            'gender' => $this->string(1)->notNull(),
            'group_number' => $this->string(5),
            'residence' => "ENUM('local', 'foreign')",
            'rates' =>  $this->smallInteger(3),
            'user_id' =>  $this->integer()->notNull(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-student-user_id',
            '{{%student}}',
            'user_id'
        );



    }

    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-student-user_id',
            '{{%user}}'
        );





        $this->dropTable('{{%student}}');
    }

}
