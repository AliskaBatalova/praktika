<?php

namespace app\controllers;

use app\models\Category;
use app\models\Comment;
use app\models\Napravlenia;
use app\models\Post;
use app\models\Prepod;
use app\models\Section;
use app\models\Signupform;
use app\models\Theme;
use app\models\Zaivki;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
        public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
        $themes=Theme::find()->all();
        $cat=Category::find()->all();
        return $this->render('index',['cat'=>$cat,'themes'=>$themes]);
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->isAdmin()){
                return $this->redirect(['/admin']);
            }
            return $this->redirect(['/site/index']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
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
        $themes=Theme::find()->all();
        return $this->render('about',['themes'=>$themes]);
    }


    public function actionSignup()
    {

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    public function actionPost(){
        //Найдем тему по id:
        $comment = new Comment();
        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            return $this->refresh();
        }

        $id= \Yii::$app->request->get('id');
        $theme= Theme::findOne($id);
        $comments=Comment::find()->where(['post_id'=>$id])->all();
        //Втащим все статьи данной темы/категории:
        $posts= Post::find()->where(['theme_id'=>$id])->all();
        $query = Post::find();
        $count = clone $query ;
        $pagination = new Pagination(['totalCount' => $count->count(),'pageSize'=>2]);
        $posts = $query->offset($pagination->offset)
            ->where(['theme_id'=>$id])
            ->limit($pagination->limit)
            ->all();


        return $this->render('post',['posts'=>$posts,'theme'=>$theme,
            'pagination'=>$pagination,'comments'=>$comments,'comment'=>$comment]);
    }
    public function actionKrug()
    {

        $id= \Yii::$app->request->get('id');
        $category= Category::findOne($id);
        //Втащим все статьи данной темы/категории:
        $section= Section::find()->where(['category_id'=>$id])->all();


        $prep= Prepod::find()->where(['id'=>$id])->all();

        return $this->render('krug',['category'=>$category,'section'=>$section,'prep'=>$prep]);
    }


        public function actionZaivki()
    {
        $model= new Zaivki();
        if ($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->goHome();

        }
        return $this->render('zaivki',['model'=>$model]);
    }
    public function actionKabinet()
    {
        $user= \app\models\User::findOne(Yii::$app->user->id);
        $zaivks=$user->zaivki;
        return $this->render('kabinet',['zaivks'=>$zaivks]);
    }
    public function actionOtziv()
    {
        $themes=Theme::find()->asArray()->orderBy('name')->all();

        return $this->render('otziv',['themes'=>$themes]);

    }
public function actionPodot()
{
    //Найдем тему по id:
    $id= \Yii::$app->request->get('id');
    $post=Post::findOne($id);
    //Втащим все статьи данной темы/категории:
    $comments= Comment::find()->where(['post_id'=>$id])->all();



    return $this->render('podot',['post'=>$post,'comments'=>$comments]);
}

}
