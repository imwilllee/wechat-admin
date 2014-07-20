<div class="row">
    <div class="col-xs-12">
        <ul class="pagination pull-right">
        <li class="prev disabled">
            <a href="javascript:;">
                <?php
                echo $this->Paginator->counter(array(
                    'format' => '<small>共{:pages}页{:count}条记录</small>'
                ));
                ?>
            </a>
        </li>
        <?php
        echo $this->Paginator->prev('上一页', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'prev disabled', 'disabledTag' => 'a'));
        echo $this->Paginator->numbers(array('tag' => 'li', 'currentClass' => 'active', 'separator' => false, 'currentTag' => 'a'));
        echo $this->Paginator->next('下一页', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'prev disabled', 'disabledTag' => 'a'));
        ?>
        </ul>
    </div>
</div>