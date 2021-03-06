<?php
namespace app\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UserForm;
use app\models\signupform;
use app\models\NewSignin;
use app\models\VerToken;
use app\models\Forgot;
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
     return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
       return [
            'error' => [
            'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page. 
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
         return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
     /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
       return $this->render('about');
    }      

public function actionUser()
{
   $model =new UserForm;
   if($model->load(Yii::$app->request->post()) && $model->validate())
{
//later
}
else
{
   return $this->render('userForm',['model' => $model]);
}
}

public function actionsignup()

{
    $model= new signupform();
	if($model -> load(yii:$app->request -> post())) {
	  if(user=$model->signup())
		{
			if(yii::$app -> getUser()->login($user)) 
			{
				return $this ->goHome();
			}
		}
	}
}
public function actionSignin()
    {
        if (!Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }
 
        $model = new NewSignin();
        if ($model->load(Yii::$app->request->post()) && $model->signin()) {
        return $this->goBack();
    }
        return $this->render('signin', [
            'model' => $model,
        ]);
    }
    public function actionVerToken($token)
        {
            $model=$this->getToken($token);
            if(isset($_POST['Ganti']))
            {
                if($model->token==$_POST['Ganti']['tokenhid']){
                    $model->password=md5($_POST['Ganti']['password']);
                    $model->token="null";
                    $model->save();
                    Yii::app()->user->setFlash('ganti','<b>Password has been successfully changed! please login</b>');
                    $this->redirect('?r=site/login');
                    $this->refresh();
                }
            }
            $this->render('verifikasi',array(
            'model'=>$model,
        ));
        }
        public function actionForgot()
    {
            $getEmail=$_POST['Lupa']['email'];
            $getModel= Users::model()->findByAttributes(array('email'=>$getEmail));
            if(isset($_POST['Lupa']))
            {
                $getToken=rand(0, 99999);
                $getTime=date("H:i:s");
                $getModel->token=md5($getToken.$getTime);
                $namaPengirim="Owner Jsource Indonesia";
                $emailadmin="sanj.k@gmail.com";
                $subjek="Reset Password";
                $setpesan="you have successfully reset your password<br/>
                    <a href='http://yourdomain.com/index.php?r=site/vertoken/view&token=".$getModel->token."'>Click Here to Reset Password</a>";
                if($getModel->validate())
            {
                $name='=?UTF-8?B?'.base64_encode($namaPengirim).'?=';
                $subject='=?UTF-8?B?'.base64_encode($subjek).'?=';
                $headers="From: $name <{$emailadmin}>\r\n".
                    "Reply-To: {$emailadmin}\r\n".
                    "MIME-Version: 1.0\r\n".
                    "Content-type: text/html; charset=UTF-8";
                $getModel->save();
                                Yii::app()->user->setFlash('forgot','link to reset your password has been sent to your email');
                mail($getEmail,$subject,$setpesan,$headers);
                $this->refresh();
            }
 
            }
        $this->render('forgot');
    }
 
}
