<?php
    $breadcrumb = array(
        array('text' => $controllerTitle),
        array('text' => $actionTitle)
    );
    $this->set('breadcrumb', $breadcrumb);
?>
<?php echo $this->Form->create('User', array('url' => array('controller' => 'groups', 'action' => 'delete', 'admin' => true, $group['Group']['id']), 'type' => 'delete')); ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="javascript:;"> 用户组信息</a></li>
                                </ul>
                                <div class="tab-content show-line">
                                    <div class="tab-pane active">

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box box-solid box-primary">
                                                    <div class="box-header">
                                                        <h3 id="area01" class="box-title">删除信息确认</h3>
                                                    </div>
                                                    <div class="box-body">
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
                                                <button type="submit" class="btn btn-danger btn-flat" onclick="return confirm('确认删除数据？');"><i class="fa fa-trash-o"></i> 确认删除</button>
                                                <?php 
                                                    echo $this->Html->link(
                                                        '<i class="fa fa-backward"></i> 返回',
                                                        array('controller' => 'groups', 'action' => 'index', 'admin' => true),
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