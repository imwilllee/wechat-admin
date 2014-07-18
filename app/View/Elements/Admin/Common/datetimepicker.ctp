<?php $this->append('append_head'); ?>
        <!-- Bootstrap Datetimepicker -->
        <link href="/css/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<?php $this->end(); ?>
<?php $this->append('append_footer'); ?>
        <!-- Moment -->
        <script src="/js/moment.min.js"></script>
        <!-- Bootstrap Datetimepicker -->
        <script src="/js/plugins/datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <!-- Bootstrap Datetimepicker Locale-->
        <script src="/js/plugins/datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>
        <script>
            $(function(){
                $('.datetimepicker').each(function(i, o){
                    $('#' + $(this).attr('id')).datetimepicker({
                        language: 'zh-CN',
                        format: 'YYYY-MM-DD HH:mm:ss',
                        useSeconds: true,
                        icons: {
                            time: 'glyphicon glyphicon-time fa-lg',
                            date: 'glyphicon glyphicon-calendar fa-lg',
                            up:   'glyphicon glyphicon-chevron-up fa-lg',
                            down: 'glyphicon glyphicon-chevron-down fa-lg'
                        },
                        collapse: false,
                        sideBySide: true,
                        useCurrent: false
                    });
                });
                $('.datepicker').each(function(i, o){
                    $('#' + $(this).attr('id')).datetimepicker({
                        language: 'zh-CN',
                        format: 'YYYY-MM-DD',
                        pickTime: false,
                        useCurrent: false
                    });
                });
            })
        </script>
<?php $this->end(); ?>