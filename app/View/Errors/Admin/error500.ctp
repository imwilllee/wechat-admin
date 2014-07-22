<div class="row">
    <div class="error-page">
        <?php if ($code >= 500): ?>
        <h2 class="headline"> <?php echo $code; ?></h2>
        <?php else: ?>
        <h2 class="headline text-info"> <?php echo $code; ?></h2>
        <?php endif; ?>
        <div class="error-content">
            <div class="col-xs-12">
                <h3><i class="fa fa-warning text-yellow"></i> 服务器发生错误</h3>
                <p><?php echo $message; ?></p>
            </div>
            <div class="col-xs-12">
                <?php
                    $referer = env('HTTP_REFERER');
                    if (!empty($referer)) {
                        echo $this->Html->link(
                            '返回上一页',
                            $referer,
                            array('class' => 'btn btn-default btn-flat')
                        );
                    }
                    unset($referer);
                ?>
                <?php
                    if ($this->Session->check('Auth.Admin')) {
                        echo $this->Html->link(
                            '控制面板',
                            array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
                            array('class' => 'btn btn-info btn-flat')
                        );
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php if (Configure::read('debug') > 0): ?>
<div class="row">
    <div class="col-xs-12">
        <pre>
<?php echo $this->element('exception_stack_trace');?>
        </pre>
    </div>
</div>
<?php endif; ?>
