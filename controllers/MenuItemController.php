<?php

class MenuItemController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('create'),
                'roles' => array('Create Menu Item'),
            ),
            array(
                'allow',
                'actions' => array('update', 'admin'),
                'roles' => array('Update Menu Item'),
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'roles' => array('Delete Menu Item'),
            ),
            array(
                'deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($menu = null)
    {
        $MIClass = $this->getMenuItemClassName();
        $model = new $MIClass;
        $model->menu_id = $menu;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST[$MIClass])) {
            $model->attributes = $_POST[$MIClass];
            if ($model->save()) {
                $this->redirect(array('/menu/update', 'id' => $model->menu_id));
            }
        }

        $this->layout = '//layouts/column1';
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $MIClass = $this->getMenuItemClassName();
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST[$MIClass])) {
            $model->attributes = $_POST[$MIClass];
            if ($model->save()) {
                $this->redirect(array('menu/update', 'id' => $model->menu_id));
            }
        }

        $this->layout = '//layouts/column1';
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        $menuId = $model->menu_id;
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(array('/menu/update', 'id' => $menuId));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $MIClass = $this->getMenuItemClassName();
        $dataProvider = new CActiveDataProvider($MIClass);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $MIClass = $this->getMenuItemClassName();
        $model = new $MIClass('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET[$MIClass])) {
            $model->attributes = $_GET[$MIClass];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MenuItem the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $MIClass = $this->getMenuItemClassName();
        $model = $MIClass::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MenuItem $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menu-item-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function getMenuItemClassName()
    {
        $className = 'MenuItem';
        try {
            $className = SnapUtil::config('general/models.MenuItem.class');
        } catch (CException $e) {
        }

        return $className;
    }
}
