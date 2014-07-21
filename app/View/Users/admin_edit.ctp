<?php
    $breadcrumb = array(
        array('text' => $controllerTitle),
        array('text' => $actionTitle)
    );
    $this->set('breadcrumb', $breadcrumb);
?>
<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'edit', 'admin' => true), 'novalidate' => true, 'shortcut' => 'on')); ?>
<?php echo $this->Form->hidden('id'); ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="javascript:;"> 管理员信息</a></li>
                                    <li>
                                        <div class="btn-group">
                                            <a class="btn btn-default" href="#area01"> 基本信息</a>
                                            <a class="btn btn-default" href="#area02"> 详细信息</a>
                                            <a class="btn btn-default" href="#area03"> 头像设置</a>
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
                                                        <div class="form-group">
                                                            <label>用户名</label>
                                                            <div class="input-group col-xs-12 col-md-6">
                                                            <?php echo $this->Form->text('username', array('placeholder' => '用户名', 'class' => 'form-control', 'disabled' => true)); ?>
                                                            <span class="text-light-blue">用户名不可编辑。</span>
                                                            </div>
                                                        </div>

                                                        <div class="form-group required<?php echo $this->Admin->errorClass('email'); ?>">
                                                            <label>邮箱</label>
                                                            <div class="input-group col-xs-12 col-md-6">
                                                            <?php echo $this->Form->text('email', array('placeholder' => '邮箱', 'class' => 'form-control')); ?>
                                                            </div>
                                                            <?php echo $this->Admin->error('email'); ?>
                                                        </div>

                                                        <div class="form-group<?php echo $this->Admin->errorClass('password'); ?>">
                                                            <label>密码</label>
                                                            <div class="input-group col-xs-12 col-md-6">
                                                            <?php echo $this->Form->password('password', array('placeholder' => '密码', 'class' => 'form-control')); ?>
                                                            <span class="text-light-blue">如果填写该项目，则会修改密码为填写值。</span>
                                                            </div>
                                                            <?php echo $this->Admin->error('password'); ?>
                                                        </div>

                                                        <div class="form-group required<?php echo $this->Admin->errorClass('group_id'); ?>">
                                                            <label>所属用户组</label>
                                                            <div class="input-group col-xs-12 col-md-4">
                                                                <?php
                                                                    echo $this->Form->select('group_id', $groups, array('empty' => '选择用户组','class' => 'form-control'));
                                                                ?>
                                                            </div>
                                                            <?php echo $this->Admin->error('group_id'); ?>
                                                        </div>

                                                        <div class="form-group required<?php echo $this->Admin->errorClass('is_active'); ?>">
                                                            <label>登陆限制</label>
                                                            <div class="input-group col-xs-12 col-md-12 item-margin">
                                                                <?php
                                                                    echo $this->Form->radio('is_active', Configure::read('User.active'), array('legend' => false, 'default' => 0));
                                                                ?>
                                                            </div>
                                                            <?php echo $this->Admin->error('is_active'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box box-solid box-primary">
                                                    <div class="box-header">
                                                        <h3 id="area02" class="box-title">详细信息</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" data-original-title="关闭" data-placement="left"><i class="fa fa-minus fa-lg"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="form-group<?php echo $this->Admin->errorClass('alias_name'); ?>">
                                                            <label>用户昵称</label>
                                                            <div class="input-group col-xs-12 col-md-6">
                                                            <?php echo $this->Form->text('alias_name', array('placeholder' => '用户昵称', 'class' => 'form-control')); ?>
                                                            </div>
                                                            <?php echo $this->Admin->error('alias_name'); ?>
                                                        </div>

                                                        <div class="form-group<?php echo $this->Admin->errorClass('mobile'); ?>">
                                                            <label>手机号码</label>
                                                            <div class="input-group col-xs-12 col-md-6">
                                                            <?php echo $this->Form->text('mobile', array('placeholder' => '手机号码', 'class' => 'form-control')); ?>
                                                            </div>
                                                            <?php echo $this->Admin->error('mobile'); ?>
                                                        </div>

                                                        <div class="form-group<?php echo $this->Admin->errorClass('birth'); ?>">
                                                            <label>出生年月</label>
                                                            <div class="input-group datepicker col-xs-12 col-md-2" id="datepicker-birth">
                                                            <?php echo $this->Form->text('birth', array('placeholder' => 'YYYY-MM-DD', 'class' => 'form-control')); ?>
                                                                <div class="input-group-addon pointer">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                            <?php echo $this->Admin->error('birth'); ?>
                                                        </div>

                                                        <div class="form-group<?php echo $this->Admin->errorClass('sex'); ?>">
                                                            <label>性别</label>
                                                            <div class="input-group col-xs-12 col-md-12 item-margin">
                                                                <?php
                                                                    echo $this->Form->radio('sex', Configure::read('User.sex'), array('legend' => false, 'default' => 0));
                                                                ?>
                                                            </div>
                                                            <?php echo $this->Admin->error('sex'); ?>
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
                                                        <h3 id="area03" class="box-title">头像设置</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" data-original-title="关闭" data-placement="left"><i class="fa fa-minus fa-lg"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">

                                                        <div class="form-group<?php echo $this->Admin->errorClass('avatar'); ?>">
                                                            <label>头像路径</label>
                                                            <div class="input-group col-xs-12 col-md-6">
                                                            <?php echo $this->Form->text('avatar', array('placeholder' => '头像路径', 'class' => 'form-control')); ?>
                                                                <div class="input-group-btn">
                                                                    <button class="btn btn-default btn-flat" type="button"><i class="fa fa-search"></i> 选择头像</button>
                                                                </div>

                                                            </div>
                                                            <?php echo $this->Admin->error('avatar'); ?>
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
<?php echo $this->element('Admin/Common/datetimepicker'); ?>
