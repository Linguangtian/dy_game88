<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/9/27
 * Time: 9:50
 */

namespace app\modules\mch\controllers;

use app\models\Topic;
use app\modules\mch\models\TopicEditForm;
use yii\data\Pagination;
use app\models\Order;
use app\models\TopicType;
use app\modules\mch\models\TopicTypeEditForm;
use app\models\OrderDetail;
use app\models\mch;
use app\models\Option;
use app\models\goods;


class TopicTypeController extends Controller
{

    public function actionIndex()
    {
        $setting = Option::get('mch_setting', $this->store->id, 'mch', []);
        $bond_good_id = trim(isset($setting['bond_good_id']) ? $setting['bond_good_id'] : '1');
        $model =new  goods();
        $goods=$model->findOne(['id'=>$bond_good_id]);
        $goods['cover_pic']=!empty($goods['cover_pic'])?$goods['cover_pic']:'/1';

    exit;

        $setting = Option::get('mch_setting', $this->store->id, 'mch', []);
        $bond_open = trim(isset($setting['bond_open']) ? $setting['bond_open'] : '');

        var_dump($bond_open);exit;

        $model =new  Order();

echo $model->find()->where(['user_id'=>3,'is_apply_order'=>1])->count('id');
      exit;
        //-------------插入订单---------------------
        $model =new  Order();
        $model->store_id ='2';
        $model->user_id= '3';
        $model->order_no=date('YmdHis') . mt_rand(100000, 999999);
        $model->total_price= '30';
        $model->pay_price= '30';
        $model->second_price= '30';
        $model->third_price= '30';
        $model->first_price= '30';
        $model->addtime= time() ;
        $model->is_apply_order= 1 ;
        $model->pay_type= 1 ;
        $model->is_pay= 0 ;
        $model->insert();

        //-------------生成付款详情---------------------
        $form = new OrderDetail();
        $form->order_id=$model->primaryKey;
        $form->goods_id=111111111;
        $form->num=1;
        $form->total_price=0.02;
        $form->addtime=time() ;
        $form->is_delete=0;
        $form->attr='111';
        $form->is_level=0;
        $form->integral='1';
        $form->attr='1';
        $form->pic='1';

        $form->insert();

    /*    $sql='insert into hjmall_order_detail  (`order_id`,`goods_id`,`num`,`total_price`,`addtime`,`is_delete`,`is_level`,`integral`,`attr`,`pic`) value
  (\''.$model->primaryKey.'\',11,1,0.02,\''.time().'\',0,0,1,\'ccccc\',\'ccccc\')';

        \Yii::$app->db->createCommand($sql)->queryOne();*/

        echo 11;exit;




      echo 111;exit;
        $pagination = new Pagination([
            'totalCount' => $count,
        ]);
        $list = $query->limit($pagination->limit)->orderBy('sort ASC')->offset($pagination->offset)->all();
        return $this->render('index', [
            'list' => $list,
            'pagination' => $pagination,
        ]);
    }

    public function actionEdit($id = null)
    {

        $model = TopicType::findOne([
            'id' => $id,
            'store_id' => $this->store->id,
            'is_delete' => 0,
        ]);
        if (!$model) {
            $model = new TopicType();
        }
        if (\Yii::$app->request->isPost) {
            $form = new TopicTypeEditForm();
            $form->store_id = $this->store->id;
            $form->attributes = \Yii::$app->request->post();
            $form->model = $model;
            return $form->save();
        } else {
            foreach ($model as $index => $value) {
                $model[$index] = str_replace("\"", "&quot;", $value);
            }
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = TopicType::findOne([
            'id' => $id,
            'is_delete' => 0,
        ]);
        if ($model) {
            $model->is_delete = 1;
            $model->save();
        }
        return [
            'code' => 0,
            'msg' => '删除成功！',
        ];
    }
}
