<?php
namespace application\forms\student;

use yii\base\Model;
use application\entities\User\User;
use application\forms\auth\StudentForm;

/**
 * Signup form
 */
class SearchForm extends Model
{

    public $query;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['query','string']

        ];
    }/**/




}/**/
