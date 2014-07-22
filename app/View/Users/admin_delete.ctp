<?php
    $breadcrumb = array(
        array('text' => $controllerTitle),
        array('text' => $actionTitle)
    );
    $this->set('breadcrumb', $breadcrumb);
?>
<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'delete', 'admin' => true, $user['User']['id']), 'type' => 'delete')); ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="javascript:;"> 管理员信息</a></li>
                                </ul>
                                <div class="tab-content show-line">
                                    <div class="tab-pane active">

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box box-solid box-danger">
                                                    <div class="box-header">
                                                        <h3 id="area01" class="box-title">删除信息确认</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-danger btn-sm" data-widget="collapse" data-toggle="tooltip" data-original-title="关闭" data-placement="left"><i class="fa fa-minus fa-lg"></i></button>
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
                                                            <label>创建日期</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static"><?php echo $this->Admin->showDateTime($user['User']['created'], 'Y年m月d日 H时i分s秒');?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button type="submit" class="btn btn-danger btn-flat" onclick="return confirm('确认删除数据？');"><i class="fa fa-trash-o"></i> 确认删除</button>
                                                <?php 
                                                    echo $this->Html->link(
                                                        '<i class="fa fa-backward"></i> 返回',
                                                        array('controller' => 'users', 'action' => 'index', 'admin' => true),
                                                        array('escape' => false, 'class' => 'btn btn-default btn-flat')
                                                    ); ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php echo $this->Form->end(); ?>