<?php

use yii\db\Migration;

class m171007_211107_add_student_foreign_key_user extends Migration
{

    public function up()
    {
        // add foreign key for table `student`
        $this->addForeignKey(
            'fk-student-user_id',
            '{{%student}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops index for column `user_id`
        $this->dropIndex(
            'idx-student-user_id',
            '{{%student}}'
        );
    }

}
