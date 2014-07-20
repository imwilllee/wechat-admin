            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <ul class="sidebar-menu">
<?php foreach ($sideBarMenus as $menuCode => $menu): ?>
    <?php if (!empty($menu['link']) && empty($menu['has_menus'])): ?>
                        <li><?php echo $this->Admin->markMenuLink($menu); ?></li>
    <?php elseif (!empty($menu['has_menus'])): ?>
                        <li class="treeview">
                            <?php echo $this->Admin->markMenuLink($menu, true); ?>
                            <ul class="treeview-menu">
            <?php if (!empty($menu['link'])): ?>
                                <li><?php echo $this->Admin->markMenuChildrenLink($menu); ?></li>
            <?php endif;?>
            <?php foreach ($menu['has_menus'] as $children): ?>
                                <li><?php echo $this->Admin->markMenuChildrenLink($children); ?></li>
            <?php endforeach;?>
                            </ul>
                        </li>
    <?php endif; ?>
<?php endforeach; ?>
                    </ul>
                </section>
            </aside>