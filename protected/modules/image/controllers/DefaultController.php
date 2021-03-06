<?php

class DefaultController extends YBackController
{
    /**
     * Отображает изображение по указанному идентификатору
     * @param integer $id Идинтификатор изображение для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель изображения.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new Image;

        if (isset($_POST['Good']))
        {
            $model->attributes = $_POST['Image'];

            if ($model->save())
            {
                $model->saveWithImage('file', $this->module->getUploadPath());

                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('image', 'Изображение добавлено!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Редактирование изображения.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Image']))
        {
            $file = $model->file;
            $model->attributes = $_POST['Image'];

            if ($model->save())
            {
                $model->saveWithImage('file', $this->module->getUploadPath(), $file);

                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('user', 'Изображение обновлено!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Удаяет модель изображения из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор изображения, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $model = $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('user', 'Изображение удалено!')
            );

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('image', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
    }

    /**
     * Управление изображениями.
     */
    public function actionIndex()
    {
        $model = new Image('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Image']))
            $model->attributes = $_GET['Image'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer идентификатор нужной модели
     */
    public function loadModel($id)
    {
        $model = Image::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('image', 'Запрошенная страница не найдена!'));
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     * @param CModel модель, которую необходимо валидировать
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'image-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}