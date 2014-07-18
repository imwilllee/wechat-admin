            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <ul class="sidebar-menu">
<?php foreach ($sideMenus as $menu): ?>
    <?php if (!empty($menu->link) && $menu->children->count() == 0): ?>
                        <li><?php echo $this->Admin->markMenuLink($menu); ?></li>
    <?php else: ?>
                        <li class="treeview">
                            <?php echo $this->Admin->markMenuLink($menu, true); ?>
                            <ul class="treeview-menu">
            <?php if (!empty($menu->link)): ?>
                                <li><?php echo $this->Admin->markMenuChildrenLink($menu); ?></li>
            <?php endif;?>
            <?php foreach ($menu->children as $children): ?>
                                <li><?php echo $this->Admin->markMenuChildrenLink($children); ?></li>
            <?php endforeach;?>
                            </ul>
                        </li>
    <?php endif; ?>
<?php endforeach; ?>
                    </ul>
                </section>
            </aside>