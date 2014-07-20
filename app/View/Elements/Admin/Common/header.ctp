        <header class="header">
            <?php echo $this->Html->link(Configure::read('WeChat.name'), ['controller' => 'dashboard', 'action' => 'index', 'admin' => true], ['class' => 'logo']); ?>

            <nav class="navbar navbar-static-top" role="navigation">
                <a href="javascript:;" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <?php
                                        $showName = $this->Session->read('Auth.Admin.alias_name');
                                        if (is_null($showName) || $showName == '') {
                                            $showName = $this->Session->read('Auth.Admin.username');
                                        }
                                ?>
                                <span><?php echo h($showName); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header bg-light-blue">
                                    <?php echo $this->Admin->showUserAvatar($this->Session->read('Auth.Admin.avatar'), array('class' => 'img-circle', 'alt' => $showName)); ?>
                                    <p>
                                        <?php echo h($this->Session->read('Auth.Admin.alias_name')); ?> - <?php echo h($this->Session->read('Auth.Admin.Group.name')); ?>
                                        <small>用户名：<?php echo $this->Session->read('Auth.Admin.username'); ?></small>
                                        <small>邮箱：<?php echo $this->Session->read('Auth.Admin.email'); ?></small>
                                    </p>
                                </li>

                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?php echo $this->Html->link('个人信息', array('controller' => 'users', 'action' => 'view', 'admin' => true), array('class' => 'btn btn-default btn-flat')); ?>
                                    </div>
                                    <div class="pull-right">
                                        <?php echo $this->Html->link('退出登录', array('controller' => 'users', 'action' => 'logout', 'admin' => true), array('class' => 'btn btn-default btn-flat', 'id' => 'btn-logout')); ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
