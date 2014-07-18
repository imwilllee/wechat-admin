<?php
App::uses('ExceptionRenderer', 'Error');
/**
 * 异常处理
 *
 * @copyright WechatAdmin
 * @package   app.Lib.Error
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class AppExceptionRenderer extends ExceptionRenderer {

/**
 * 输出错误信息
 * 
 * @param string $template 模板
 * @return void
 */
	protected function _outputMessage($template) {
		if ($this->controller->_admin == true) {
			$this->controller->layout = 'Admin/error';
			$template = 'Admin/' . $template;
		} else {
			$this->controller->layout = 'Front/error';
			$template = 'Front/' . $template;
		}
		parent::_outputMessage($template);
	}
}