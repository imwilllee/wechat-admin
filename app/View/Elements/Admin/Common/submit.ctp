                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> 保存数据</button>
                                                <?php
                                                    if (isset($return_url) && !empty($return_url)) {
                                                        $url = $this->Admin->parseStringUrl($return_url);
                                                    } else {
                                                        $url = env('HTTP_REFERER');
                                                    }
                                                    if (!empty($url)) {
                                                        echo $this->Html->link('<i class="fa fa-backward"></i> 返回', $url, ['class' => 'btn btn-default btn-flat', 'escape' => false] );
                                                    }
                                                ?>
                                            </div>
                                        </div>