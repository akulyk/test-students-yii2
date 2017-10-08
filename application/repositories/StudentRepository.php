<?php

namespace application\repositories;

use application\entities\Student\Student;
use application\forms\student\UpdateForm;

class StudentRepository
{

    public function get($id): Student
    {
        return $this->getBy(['id' => $id]);
    }/**/

    public function getByUserID($id):Student
    {
        return $this->getBy(['user_id' => $id]);
    }


    public function save(Student $student): bool
    {
        if (!$student->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return true;
    }/**/



    public function remove(Student $student): void
    {
        if (!$student->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }/**/

    private function getBy(array $condition): Student
    {
        if (!$student = Student::find()->andWhere($condition)->limit(1)->one()) {
            throw new \NotFoundException('Student not found.');
        }
        return $student;
    }/**/
}/* end of Service */