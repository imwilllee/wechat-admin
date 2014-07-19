<!DOCTYPE html>
<html>
<?php $this->append('append_head'); ?>
    <?php echo $this->element('Admin/Common/app_base_css'); ?>
<?php $this->end(); ?>

<?php echo $this->element('Admin/Common/head'); ?>

    <body class="skin-blue">
<?php echo $this->element('Admin/Common/header'); ?>

        <div class="wrapper row-offcanvas row-offcanvas-left">
<?php echo $this->element('Admin/Common/left_side'); ?>

<?php echo $this->element('Admin/Common/right_side'); ?>

        </div>

<?php $this->append('append_footer'); ?>
<?php echo $this->element('Admin/Common/app_base_js'); ?>
<?php $this->end(); ?>
<?php echo $this->element('Admin/Common/footer'); ?>

    </body>
</html>