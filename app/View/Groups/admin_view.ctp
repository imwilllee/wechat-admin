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
                                    <li class="active"><a href="javascript:;"> 用户组信息</a></li>
                                    <li>
                                        <div class="btn-group">
                                            <a class="btn btn-default" href="#area01"> 基本信息</a>
                                            <a class="btn btn-default" href="#area02"> 访问权限</a>
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
                                                            <label>ID</label>
                                                            <div class="input-group col-xs-12">
                                                            <p class="form-control-static"><?php echo $group['Group']['id']; ?></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>名称</label>
                                                            <div class="input-group col-xs-12">
                                                            <p class="form-control-static"><?php echo h($group['Group']['name']); ?></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>登陆限制</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static item-margin">
                                                                <?php
                                                                    echo $this->Form->radio('is_active', Configure::read('Default.active'), array('legend' => false, 'default' => $group['Group']['is_active'], 'disabled' => true));
                                                                ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>创建日期</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static"><?php echo $group['Group']['created'];?></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>备注说明</label>
                                                            <div class="input-group col-xs-12">
                                                                <p class="form-control-static"><?php echo nl2br(h($group['Group']['explain'])); ?></p>
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
                                                        <h3 id="area02" class="box-title">访问权限</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" data-original-title="关闭" data-placement="left"><i class="fa fa-minus fa-lg"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
<div class="row">
                                                    <?php foreach ($menus as $menu): ?>
<div class="col-md-4 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo h($menu['Menu']['name']); ?></h3>
                                </div>
                                <div class="box-body">
                                    <div class="item-margin">
                                <?php foreach ($menu['MenuAction'] as $action): ?>
                                    <label>
                                    <?php
                                        echo $this->Form->checkbox(
                                            'menu_action_id',
                                            array(
                                                'value' => $action['id'],
                                                'id' => false,
                                                'name' => false,
                                                'checked' => in_array($action['id'], $accesses) || $checked == true ? true : false,
                                                'disabled' => true
                                            )
                                        );
                                    ?>
                                    <?php echo h($action['name']); ?>
                                    </label>
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

                                        <div class="row">
                                            <div class="col-xs-12">
                                                    <?php
                                                        echo $this->Admin->showNavEditLink(
                                                            array(
                                                                'controller' => 'groups',
                                                                'action' => 'edit',
                                                                'admin' => true,
                                                                $group['Group']['id']
                                                            )
                                                        );
                                                    ?>
                                                    <?php
                                                        if ($group['Group']['id'] != Configure::read('Group.supper_id')) {
                                                            echo $this->Admin->showNavDeleteLink(
                                                                array(
                                                                    'controller' => 'groups',
                                                                    'action' => 'delete',
                                                                    'admin' => true,
                                                                    $group['Group']['id']
                                                                )
                                                            );
                                                        }
                                                    ?>
                                                    <?php
                                                        echo $this->Admin->showNavBackwardLink(
                                                            array(
                                                                'controller' => 'groups',
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
