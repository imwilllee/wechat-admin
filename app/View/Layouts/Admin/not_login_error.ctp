<!DOCTYPE html>
<html>
<?php $this->append('append_head'); ?>
    <?php echo $this->element('Admin/Common/app_base_css'); ?>
<?php $this->end(); ?>

<?php echo $this->element('Admin/Common/head'); ?>

    <body>
        <section class="content">
<?php echo $this->element('Admin/Common/flash_render'); ?>
<?php echo $this->fetch('content'); ?>

        </section>
    </body>
</html>
