<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "group".
 *
 * @property int $id
 * @property string $name
 * @property int|null $teacher_id
 * @property int|null $course_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Course $course
 * @property GroupPupilList[] $groupPupilLists
 * @property Member $teacher
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group';
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'teacher_id',
                'updatedByAttribute' => false,
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['teacher_id', 'course_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::class, 'targetAttribute' => ['teacher_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Guruh nomi',
            'teacher_id' => 'O\'qituvchi',
            'course_id' => 'Kurs reklamasi',
            'status' => 'Holati',
            'created_at' => 'Yaratilgan vaqti',
            'updated_at' => 'Oxirgi o\'zgarish',
        ];
    }

    /**
     * Gets query for   [[Course]].
     *
     * @return \yii\db\ActiveQuery|\common\models\search\CourseQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::class, ['id' => 'course_id']);
    }

    /**
     * Gets query for [[GroupPupilLists]].
     *
     * @return \yii\db\ActiveQuery|\common\models\search\GroupPupilListQuery
     */
    public function getGroupPupilLists()
    {
        return $this->hasMany(GroupPupilList::class, ['group_id' => 'id']);
    }

    /**
     * Gets query for [[Teacher]].
     *
     * @return \yii\db\ActiveQuery|\common\models\search\MemberQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Member::class, ['id' => 'teacher_id']);
    }

    public function getCourseList()
    {
        return Course::findAll(['status' => Course::STATUS_ACTIVE, 'user_id' => Yii::$app->user->id]);
    }
}
