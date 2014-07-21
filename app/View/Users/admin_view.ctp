<?php
    $breadcrumb = array(
        array('text' => $controllerTitle),
        array('text' => $actionTitle)
    );
    $this->set('breadcrumb', $breadcrumb);
?>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="javascript:;"> 管理员信息</a></li>
                                    <li>
                                        <div class="btn-group">
                                            <a class="btn btn-default" href="#area01"> 基本信息</a>
                                            <a class="btn btn-default" href="#area02"> 详细信息</a>
                                            <a class="btn btn-default" href="#area03"> 头像预览</a>
                                        </div>
                                    </li>

                                </ul>
                                <div class="tab-content show-line">
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
                                                            <div class="input-group col-xs-12">
                                                            <p class="form-control-static"><?php echo $user['User']['username']; ?></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>邮箱</label>
                                                            <div class="input-group col-xs-12">
                                                            <p class="form-control-static"><?php echo $user['User']['email']; ?></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>所属用户组</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static"><?php echo h($user['Group']['name']);?></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>登陆限制</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static item-margin">
                                                                <?php
                                                                    echo $this->Form->radio('is_active', Configure::read('User.active'), array('legend' => false, 'default' => $user['User']['is_active'], 'disabled' => true));
                                                                ?>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>最后登陆日期</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static"><?php echo h($user['User']['last_logined']);?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>最后登陆IP</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static"><?php echo h($user['User']['last_login_ip']);?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>最后登陆UA</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static"><?php echo h($user['User']['last_user_agent']);?></p>
                                                            </div>
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
                                                        <div class="form-group">
                                                            <label>用户昵称</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static"><?php echo h($user['User']['alias_name']);?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>手机号码</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static"><?php echo $user['User']['mobile'];?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>出生年月</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static"><?php echo $this->Admin->showDateTime($user['User']['birth'], 'Y年m月d日');?></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>性别</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static"><?php echo Configure::read('User.sex.' . $user['User']['sex']);?></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>备注说明</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static"><?php echo nl2br(h($user['User']['explain'])); ?></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box box-solid box-primary">
                                                    <div class="box-header">
                                                        <h3 id="area03" class="box-title">头像预览</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" data-original-title="关闭" data-placement="left"><i class="fa fa-minus fa-lg"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">

                                                        <div class="form-group">
                                                            <div class="input-group col-xs-12">
                                                                <?php echo $this->Admin->showUserAvatar($user['User']['avatar'], array('class' => 'img-thumbnail')); ?>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="btn-group">
                                                    <?php 
                                                    echo $this->Admin->showNavEditLink(
                                                        array(
                                                            'controller' => 'users',
                                                            'action' => 'edit',
                                                            'admin' => true,
                                                            $user['User']['id']
                                                        )
                                                    );
                                                    echo $this->Admin->showNavDeleteLink(
                                                        array(
                                                            'controller' => 'users',
                                                            'action' => 'delete',
                                                            'admin' => true,
                                                            $user['User']['id']
                                                        )
                                                    );
                                                    echo $this->Admin->showNavBackwardLink(
                                                        array(
                                                            'controller' => 'users',
                                                            'action' => 'index',
                                                            'admin' => true
                                                        )
                                                    );
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
