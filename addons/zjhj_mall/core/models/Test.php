<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/17 0017
 * Time: 11:19
 */
namespace app\models;

use Yii;


class Test extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%topic}}';
    }

    public function rules()
    {
        return [
            [['store_id'], 'required'],
            [['store_id', 'type', 'read_count', 'virtual_read_count', 'layout', 'sort', 'agree_count', 'virtual_agree_count', 'virtual_favorite_count', 'addtime', 'is_chosen', 'is_delete'], 'integer'],
            [['cover_pic', 'content', 'qrcode_pic'], 'string'],
            [['title', 'sub_title'], 'string', 'max' => 255],
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'user_id' => 'User ID',
            'topic_id' => 'Topic ID',
            'addtime' => 'Addtime',
            'is_delete' => 'Is Delete',
        ];
    }

}