<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('user')->getCategory() => array(),
        Yii::t('user', 'Пользователи') => array('/user/default/index'),
        $model->nick_name => array('/user/default/view', 'id' => $model->id),
        Yii::t('user', 'Изменение паролья'),
    );

    $this->pageTitle = Yii::t('user', 'Пользователи - изменение пароля');

    $this->menu = array(
        array('label' => Yii::t('user', 'Пользователи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
            array('label' => Yii::t('user', 'Пользователь') . ' «' . $model->nick_name . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('user', 'Редактирование пользователя'), 'url' => array(
                '/user/default/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('user', 'Просмотр пользователя'), 'url' => array(
                '/user/default/view',
                'id' => $model->id
            )),
            array('icon' => 'lock', 'label' => Yii::t('user', 'Изменить пароль пользователя'), 'url' => array(
                '/user/default/changepassword',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('user', 'Удалить пользователя'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/user/default/delete', 'id' => $model->id),
                'confirm' => Yii::t('user', 'Вы уверены, что хотите удалить пользователя?')),
            ),
        )),
        array('label' => Yii::t('user', 'Восстановления паролей'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('user', 'Восстановления паролей'), 'url' => array('/user/recoveryPassword/index')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('user', 'Изменение пароля'); ?><br />
        <small>&laquo;<?php echo $model->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'user-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', delay : 500 });
    });
");
?>
    <?php echo $form->errorSummary($changePasswordForm); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('password') ? 'error' : ''; ?>"> 
        <?php echo $form->passwordFieldRow($changePasswordForm, 'password'); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('cPassword') ? 'error' : ''; ?>"> 
        <?php echo $form->passwordFieldRow($changePasswordForm, 'cPassword'); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      =>  Yii::t('user', 'Изменить пароль'),
    )); ?>

<?php $this->endWidget(); ?>