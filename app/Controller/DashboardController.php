<?php
App::uses('AppController', 'Controller');
/**
 * 控制面板控制器
 *
 * @copyright WechatAdmin
 * @package   app.Controller
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class DashboardController extends AppController {

/**
 * 加载模型
 * @var array
 */
	public $uses = array();

/**
 * 主标题
 * @var string
 */
	public $controllerTitle = '控制面板';

/**
 * 首页
 * 
 * @return void
 */
	public function admin_index() {
		if (Configure::read('debug') > 0) {
			$this->__initMenuDB();
		}
	}

/**
 * 初始化菜单
 * 
 * @return void
 */
	private function __initMenuDB() {
		if ($this->request->is('get') && $this->request->query('init') == 'menu' ) {
			$this->loadModel('Menu');
			if ($this->Menu->initDB()) {
				$this->_showSuccessMessage('初始化菜单成功！');
			} else {
				$this->_showErrorMessage('初始化菜单失败！');
			}
			return $this->redirect(array('action' => 'index', 'admin' => true));
		}
	}
}