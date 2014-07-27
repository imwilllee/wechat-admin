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
 * 构造函数
 *
 * @param Exception $exception 异常对象
 */
	public function __construct(Exception $exception) {
		parent::__construct($exception);
		if ($this->method == 'error400' || $this->method == 'error500') {
			$this->controller->set('code', $exception->getCode());
		}
		if ($this->controller->_admin == true) {
			$this->controller->controllerTitle = '发生错误';
			$this->controller->actionTitle = '错误信息';
		}
	}

/**
 * 输出错误信息
 * 
 * @param string $template 模板
 * @return void
 */
	protected function _outputMessage($template) {
		if ($this->controller->_admin == true) {
			if ($this->controller->request->is('ajax')) {
				$this->controller->layout = false;
				$this->controller->response->type('json');
				$template = 'ajax_' . $template;
			} else {
				if ($this->controller->Auth->loggedIn()) {
					$this->controller->layout = 'Admin/error';
				} else {
					$this->controller->layout = 'Admin/not_login_error';
				}
			}

			$template = 'Admin/' . $template;
		} else {
			$this->controller->layout = 'Front/error';
			$template = 'Front/' . $template;
		}
		parent::_outputMessage($template);
	}
}