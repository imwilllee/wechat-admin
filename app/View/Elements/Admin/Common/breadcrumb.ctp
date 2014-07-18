                <section class="content-header">
                    <h1>
                        <?php echo h($controllerTitle); ?>
                        <?php if (!is_null($actionTitle)): ?>
                        <small><?php echo h($actionTitle); ?></small>
                        <?php endif;?>
                    </h1>
<?php if (isset($breadcrumb)): ?>
                    <ol class="breadcrumb">
                        <li><a href="javascript:;"><i class="fa fa-home fa-lg"></i>LeeAdmin</a></li>
<?php foreach ($breadcrumb as $item): ?>
    <?php if (isset($item['active'])): ?>
                        <li class="active"><?php echo $item['text']; ?></li>
    <?php else: ?>
                        <li><?php echo $this->Html->link($item['text'], $this->Admin->parseStringUrl($item['url']), ['escape' => false]); ?></li>

    <?php endif; ?>

<?php endforeach; ?>
                    </ol>
<?php endif; ?>
                </section>