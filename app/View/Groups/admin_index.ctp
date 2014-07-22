<?php
    $breadcrumb = array(
        array('text' => $controllerTitle),
        array('text' => $actionTitle)
    );
    $this->set('breadcrumb', $breadcrumb);
?>

                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">数据一览</h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>名称</th>
                                                <th>登陆限制</th>
                                                <th>创建日期</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
<?php foreach ($groups as $group): ?>
                                            <tr>
                                                <td><?php echo $group['Group']['id']; ?></td>
                                                <td>
                                                <?php echo $this->Html->link($group['Group']['name'], array('controller' => 'groups', 'action' => 'view', 'admin' => true, $group['Group']['id'])); ?>
                                                </td>
                                                <td>
                                                <?php if ($group['Group']['is_active']): ?>
                                                    <span class="label label-success"><?php echo Configure::read('Default.active.1'); ?></span>
                                                <?php else: ?>
                                                    <span class="label label-danger"><?php echo Configure::read('Default.active.0'); ?></span>
                                                <?php endif;?>
                                                </td>
                                                <td><?php echo $group['Group']['created']; ?></td>
                                                <td>
                                                <?php
                                                    echo $this->Admin->showViewIconLink(array('controller' => 'groups', 'action' => 'view', 'admin' => true, $group['Group']['id']));
                                                    echo $this->Admin->showEditIconLink(array('controller' => 'groups', 'action' => 'edit', 'admin' => true, $group['Group']['id']));
                                                    if ($group['Group']['id'] != Configure::read('Group.supper_id')) {
                                                        echo $this->Admin->showDeleteIconLink(array('controller' => 'groups', 'action' => 'delete', 'admin' => true, $group['Group']['id']));
                                                    }
                                                ?>
                                                </td>
                                            </tr>
<?php endforeach; ?>
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
