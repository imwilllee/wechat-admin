                                                                            <div class="col-md-4 col-xs-4">
                                                                                <div class="box box-warning">
                                                                                    <div class="box-header">
                                                                                        <h3 class="box-title"><?php echo h($menu['name']); ?></h3>
                                                                                    </div>
                                                                                    <div class="box-body">
                                                                                        <div class="item-margin">
        <?php foreach ($menu['has_actions'] as $action): ?>
                                                                                            <label>
                                                                                            <?php
                                                                                                echo $this->Form->checkbox(
                                                                                                    'GroupAccess.' . $action['id'] . '.menu_action_id',
                                                                                                    array(
                                                                                                        'value' => $action['id'],
                                                                                                        'id' => false,
                                                                                                        'hiddenField' => false,
                                                                                                        'disabled' => isset($disabled) ? true : false,
                                                                                                        'default' => isset($checked) ? true : false,
                                                                                                        'class' => 'access'
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