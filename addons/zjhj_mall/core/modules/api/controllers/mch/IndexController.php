<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2018/2/28
 * Time: 10:53
 */

namespace app\modules\api\controllers\mch;

use app\hejiang\BaseApiResponse;
use app\modules\api\behaviors\LoginBehavior;
use app\modules\api\behaviors\VisitBehavior;
use app\modules\api\controllers\Controller;
use app\modules\api\models\mch\ApplyForm;
use app\modules\api\models\mch\ApplySubmitForm;
use app\modules\api\models\mch\ShopCatForm;
use app\modules\api\models\mch\ShopListForm;
use app\modules\api\models\mch\ShopDataForm;
use app\models\Order;

class IndexController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'login' => [
                'class' => LoginBehavior::className(),
            ],
            'visit' => [
                'class' => VisitBehavior::className(),
            ],
        ]);
    }

    public function actionApply()
    {
        $form = new ApplyForm();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $res=$form->search();



        return new BaseApiResponse($res);
    }

    public function actionApplySubmit()
    {
        $form = new ApplySubmitForm();
        $form->attributes = \Yii::$app->request->post();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $res=$form->save();
        if($res){
            $Order =new  Order();
            $is_shop=$Order->find()->where(['user_id'=>\Yii::$app->user->id,'is_apply_order'=>1])->count('id');
            if(!$is_shop){
                //还不是
                $model =new  Order();
                $model->store_id =$this->store->id;
                $model->user_id=\Yii::$app->user->id;
                $model->order_no=date('YmdHis') . mt_rand(100000, 999999);
                $model->total_price= '0.01';
                $model->pay_price= '0.01';
                $model->second_price= '30';
                $model->third_price= '30';
                $model->first_price= '30';
                $model->addtime= time() ;
                $model->is_apply_order= 1 ;
                $model->pay_type= 1 ;
                $model->is_pay= 0 ;
                $model->insert();

                $form = new OrderDetail();
                $form->order_id=$model->primaryKey;
                $form->goods_id=111111111;
                $form->total_price=0.02;
                $form->addtime=time() ;
                $form->is_delete=0;
                $form->attr='111';
                $form->is_level=0;
                $form->integral='1';
                $form->attr='1';
                $form->pic='1';
                $form->insert();
            }
        }

        return new BaseApiResponse($res);
    }

    public function actionShop()
    {
        $form = new ShopDataForm();
        $form->store_id = $this->store->id;
        $form->attributes = \Yii::$app->request->get();
        return new BaseApiResponse($form->search());
    }

    public function actionShopList()
    {
        $form = new ShopListForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        return new BaseApiResponse($form->search());
    }

    public function actionShopCat()
    {
        $form = new ShopCatForm();
        $form->attributes = \Yii::$app->request->get();
        return new BaseApiResponse($form->search());
    }
}
