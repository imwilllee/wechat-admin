<?php echo $this->element('Admin/Common/jquery_file_upload'); ?>
<?php $this->append('append_footer'); ?>
        <script type="text/javascript">
$(function () {
    $('#avatar-file').fileupload({
        dataType: 'json',
        url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'upload', 'admin' => true)); ?>',
        formData: false,
        add: function (e, data) {
            if (data.originalFiles.length > 1) {
                alert('只能选择一张图片！');
                return false;
            }
            var file = data.files[0];
            if (!(/^image\/(gif|jpe?g|png)$/).test(file.type)) {
                alert('上传文件类型错误！');
                return false;
            }
            if (file.size > <?php echo Configure::read('User.avatar.max_size') * 1024; ?>) {
                alert('上传文件大小超出限制！');
                return false;
            }
            data.submit().error(function (jqXHR, textStatus, errorThrown) {
                if (typeof(jqXHR.responseJSON.err_msg) != 'undefined') {
                    alert(jqXHR.responseJSON.err_msg);
                }
            });
        },
        done: function (e, data) {
            if (data.result.err != 0) {
                alert(data.result.err_msg);
            } else {
                $('#UserAvatar').val(data.result.url);
            }
        }
    });

});
        </script>
<?php $this->end(); ?>