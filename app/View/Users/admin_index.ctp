<?php
    $breadcrumb = array(
        array('text' => $controllerTitle),
        array('text' => $actionTitle)
    );
    $this->set('breadcrumb', $breadcrumb);
?>
<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'index', 'admin' => true), 'novalidate' => true)); ?>
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">数据筛选</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" data-original-title="关闭" data-placement="left"><i class="fa fa-minus fa-lg"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="row">
                                            <div class="form-group col-xs-12 col-md-4">
                                                <label>用户名</label>
                                                <?php echo $this->Form->text('username', array('placeholder' => '用户名', 'class' => 'form-control')); ?>
                                            </div>

                                            <div class="form-group col-xs-12 col-md-4">
                                                <label>邮箱</label>
                                                <?php echo $this->Form->text('email', array('placeholder' => '邮箱', 'class' => 'form-control')); ?>
                                            </div>

                                            <div class="form-group col-xs-12 col-md-4">
                                                <label>手机号码</label>
                                                <?php echo $this->Form->text('mobile', array('placeholder' => '手机号码', 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="row">
                                            <div class="form-group col-xs-12 col-md-4">
                                                <label>所属用户组</label>
                                                <?php
                                                    echo $this->Form->select('group_id', $groups, array('empty' => '选择用户组','class' => 'form-control'));
                                                 ?>
                                            </div>
                                            <div class="form-group col-xs-12 col-md-4">
                                                <label>登陆限制</label>
                                                <div class="input-group item-margin">
                                                    <?php
                                                        echo $this->Form->input(
                                                            'is_active',
                                                            array(
                                                                'label' => false,
                                                                'type' => 'select',
                                                                'multiple' => 'checkbox',
                                                                'options' =>Configure::read('Default.active'),
                                                                'class' => 'pull-left',
                                                                'div' => false
                                                            )
                                                        );
                                                    ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <button type="submit" class="btn btn-primary btn-flat">筛选数据</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
<?php echo $this->Form->end(); ?>


                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">数据一览</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" data-original-title="关闭" data-placement="left"><i class="fa fa-minus fa-lg"></i></button>
                                    </div>
                                </div>
                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
                                                <th>用户名</th>
                                                <th><?php echo $this->Paginator->sort('group_id', '用户组'); ?></th>
                                                <th>昵称</th>
                                                <th>邮箱</th>
                                                <th>登陆限制</th>
                                                <th><?php echo $this->Paginator->sort('last_logined', '最后登陆'); ?></th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
<?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?php echo $user['User']['id']; ?></td>
                                                <td>
                                                <?php echo $this->Html->link($user['User']['username'], array('controller' => 'users', 'action' => 'view', 'admin' => true, $user['User']['id'])); ?>
                                                <?php if ($user['User']['id'] == $this->Session->read('Auth.Admin.id')): ?>
                                                    <br><span class="label label-info">当前登陆</span>
                                                <?php endif;?>
                                                </td>
                                                <td><?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', 'admin' => true, $user['Group']['id'])); ?></td>
                                                <td><?php echo h($user['User']['alias_name']); ?></td>
                                                <td><?php echo $user['User']['email']; ?></td>
                                                <td>
                                                <?php if ($user['User']['is_active']): ?>
                                                    <span class="label label-success"><?php echo Configure::read('Default.active.1'); ?></span>
                                                <?php else: ?>
                                                    <span class="label label-danger"><?php echo Configure::read('Default.active.0'); ?></span>
                                                <?php endif;?>
                                                </td>
                                                <td><?php echo $user['User']['last_logined']; ?></td>
                                                <td>
                                                <?php
                                                    echo $this->Admin->showViewIconLink(array('controller' => 'users', 'action' => 'view', 'admin' => true, $user['User']['id']));
                                                    echo $this->Admin->showEditIconLink(array('controller' => 'users', 'action' => 'edit', 'admin' => true, $user['User']['id']));
                                                    echo $this->Admin->showDeleteIconLink(array('controller' => 'users', 'action' => 'delete', 'admin' => true, $user['User']['id']));
                                                ?>
                                                </td>
                                            </tr>
<?php endforeach; ?>
                                        </tbody>

                                    </table>
                                </div>
                                <div class="box-footer">

                                    <?php echo $this->element('Admin/Common/paginator'); ?>

                                </div>

                            </div>
                        </div>
                    </div>
