        <header class="header">
            <?php echo $this->Html->link('LeeAdmin', ['controller' => 'Dashboard', 'action' => 'index', 'admin' => true], ['class' => 'logo']); ?>

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
                                        $loginUser = $this->Session->read('Auth.Admin');
                                        $showName = $loginUser['alias_name'];
                                        if (is_null($showName) || $showName == '') {
                                            $showName = $loginUser['username'];
                                        }
                                ?>
                                <span><?php echo h($showName); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header bg-light-blue">
                                    <?php echo $this->Admin->showUserAvatar($loginUser['avatar'], ['class' => 'img-circle', 'alt' => $loginUser['alias_name']]); ?>
                                    <p>
                                        <?php echo h($loginUser['alias_name']); ?> - 系统管理员
                                        <small>用户名：<?php echo $loginUser['username']; ?></small>
                                        <small>邮箱：<?php echo $loginUser['email']; ?></small>
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
