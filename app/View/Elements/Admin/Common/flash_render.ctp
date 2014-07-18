<?php if ($this->Session->check('Message.Admin')): ?>
                <div class="row">
                    <div class="col-md-12">
<?php echo $this->Session->flash('Message.Admin'); ?>

                    </div>
                </div>
<?php endif; ?>