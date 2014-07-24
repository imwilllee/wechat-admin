<?php
    $breadcrumb = array(
        array('text' => $controllerTitle),
        array('text' => $actionTitle)
    );
    $this->set('breadcrumb', $breadcrumb);
?>
<?php echo $this->Form->create('Group', array('url' => array('controller' => 'groups', 'action' => 'add', 'admin' => true), 'novalidate' => true, 'shortcut' => 'on')); ?>
<?php $this->Form->unlockField('GroupAccess'); ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="javascript:;"> 用户组信息</a></li>
                                    <li>
                                        <div class="btn-group">
                                            <a class="btn btn-default" href="#area01"> 基本信息</a>
                                            <a class="btn btn-default" href="#area02"> 访问权限</a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active">

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box box-solid box-primary">
                                                    <div class="box-header">
                                                        <h3 id="area01" class="box-title">基本信息</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" data-original-title="关闭" data-placement="left"><i class="fa fa-minus fa-lg"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="form-group required<?php echo $this->Admin->errorClass('name'); ?>">
                                                            <label>名称</label>
                                                            <div class="input-group col-xs-12 col-md-5">
                                                            <?php echo $this->Form->text('name', array('placeholder' => '名称', 'class' => 'form-control')); ?>
                                                            </div>

                                                            <?php echo $this->Admin->error('name'); ?>
                                                        </div>

                                                        <div class="form-group required<?php echo $this->Admin->errorClass('is_active'); ?>">
                                                            <label>登陆限制</label>
                                                            <div class="input-group col-xs-12 col-md-12 item-margin">
                                                                <?php
                                                                    echo $this->Form->radio('is_active', Configure::read('Default.active'), array('legend' => false, 'default' => 0));
                                                                ?>
                                                            </div>
                                                            <?php echo $this->Admin->error('is_active'); ?>
                                                        </div>

                                                        <div class="form-group<?php echo $this->Admin->errorClass('explain'); ?>">
                                                            <label>备注说明</label>
                                                            <div class="input-group col-xs-12 col-md-6">
                                                            <?php echo $this->Form->textarea('explain', array('placeholder' => '备注说明', 'class' => 'form-control', 'rows' => 5)); ?>
                                                            </div>
                                                            <?php echo $this->Admin->error('explain'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box box-solid box-primary">
                                                    <div class="box-header">
                                                        <h3 id="area02" class="box-title">访问权限</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" data-original-title="关闭" data-placement="left"><i class="fa fa-minus fa-lg"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="row">
<?php foreach ($menus as $code => $root): ?>
                                                            <div class="col-md-12 col-xs-12">
                                                                <div class="box box-primary">
                                                                    <div class="box-header">
                                                                        <h3 class="box-title"><?php echo h($root['name']); ?></h3>
                                                                        <div class="box-tools pull-right">
                                                                            <button type="button" class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" data-original-title="关闭" data-placement="left"><i class="fa fa-minus fa-lg"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="box-body">
                                                                        <div class="row">
    <?php if (!empty($root['has_actions'])): ?>
        <?php echo $this->element('Admin/Groups/menu_actions', array('menu' => $root)); ?>
    <?php endif; ?>

    <?php foreach ($root['has_menus'] as $menu): ?>
        <?php echo $this->element('Admin/Groups/menu_actions', array('menu' => $menu)); ?>
    <?php endforeach; ?>
                                                                        </div>
    
                                                                    </div>
                                                                </div>
                                                            </div>
<?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


<?php echo $this->element('Admin/Common/submit', array('return_url' => 'admin/users/index')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php echo $this->Form->end(); ?>
