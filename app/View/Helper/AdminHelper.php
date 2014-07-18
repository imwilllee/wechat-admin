<?php
App::uses('AppHelper', 'View/Helper');
/**
 * 管理端视图助手
 *
 * @copyright WechatAdmin
 * @package   app.View.Helper
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class AdminHelper extends AppHelper {

/**
 * 加载助手
 * @var array
 */
	public $helpers = array('Form', 'Html');

/**
 * 显示用户头像
 * 
 * @param string $src 路径
 * @param array $options 参数
 * @return string
 */
	public function showUserAvatar($src = null, $options = array()) {
		if (empty($src)) {
			$src = Configure::read('Default.avatar_src');
		}
		return $this->Html->image($src, $options);
	}
}
