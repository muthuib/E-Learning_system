<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                ///implements RBAC
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['create', 'update', 'manage', 'assign-role', 'delete'],
                            'allow' => true,
                            'roles' => ['admin'], // Only admin can create/update and manage
                        ],
                        [
                            'actions' => ['index', 'view', 'manage'],
                            'allow' => true,
                            'roles' => ['@'], // Allow authenticated users
                        ],
                        [
                            'allow' => false, // Deny all other actions
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'ID' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    ///function to manage users n RBAC
   public function actionManage($role = null)
{
    $query = User::find(); // Assuming you're using the User model to get users
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);

    // Count total users
    $totalUsersCount = $query->count();

    return $this->render('manage', [
        'dataProvider' => $dataProvider,
        'totalUsersCount' => $totalUsersCount,
        'role' => $role,
    ]);
}

    /**
     * Displays a single User model.
     * @param int $ID ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
   
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            // Hash the password before saving
            $model->PASSWORD = Yii::$app->security->generatePasswordHash($model->PASSWORD);

            if ($model->save()) {
                // Assign the selected role
                $roleName = Yii::$app->request->post('User')['USER_ROLE'];
                Yii::$app->authManager->assign(Yii::$app->authManager->getRole($roleName), $model->ID);
                return $this->redirect(['view', 'id' => $model->ID]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $ID ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Fetch the current role of the user
        $currentRoles = Yii::$app->authManager->getRolesByUser($model->ID);
        $currentRoleName = array_key_first($currentRoles); // Assuming the user has one role

        if ($model->load(Yii::$app->request->post())) {
            // Hash the password before saving, only if it's provided
            if (!empty($model->PASSWORD)) {
                $model->PASSWORD = Yii::$app->security->generatePasswordHash($model->PASSWORD);
            }

            if ($model->save()) {
                // Remove the previous role
                if ($currentRoleName) {
                    Yii::$app->authManager->revoke(Yii::$app->authManager->getRole($currentRoleName), $model->ID);
                }

                // Assign the selected new role
                $newRoleName = Yii::$app->request->post('User')['USER_ROLE'];
                Yii::$app->authManager->assign(Yii::$app->authManager->getRole($newRoleName), $model->ID);

                return $this->redirect(['view', 'id' => $model->ID]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $ID ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['manage']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ID ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID)
    {
        if (($model = User::findOne(['ID' => $ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    ///function to assign role in RBAC
    public function actionAssignRole()
    {
        $auth = Yii::$app->authManager;
        $roleName = Yii::$app->request->post('roleName');
        $userId = Yii::$app->request->post('userId');

        // Check if role is selected
        if (empty($roleName)) {
            Yii::$app->session->setFlash('error', 'Please select a role.');
            return $this->redirect(['user/manage']);
        }

        $role = $auth->getRole($roleName);

        // Check if role exists
        if ($role === null) {
            Yii::$app->session->setFlash('error', 'Invalid role selected.');
            return $this->redirect(['user/manage']);
        }

        // Check if the user already has the selected role
        $existingRole = $auth->getAssignment($roleName, $userId);
        if ($existingRole) {
            Yii::$app->session->setFlash('error', 'User already has this role.');
            return $this->redirect(['user/manage']);
        }

        // Remove all existing roles for the user
        $auth->revokeAll($userId);

        // Assign the new role
        $auth->assign($role, $userId);
        Yii::$app->session->setFlash('success', 'New role assigned and previous roles removed successfully.');

        return $this->redirect(['user/manage']);
    }


}