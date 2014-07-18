<?php
App::uses('Controller', 'Controller');
/**
 * 项目全局控制器
 * 在此文件内定义的方法可在项目其他控制器内调用
 *
 * @copyright WechatAdmin
 * @package   app.Controller
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class AppController extends Controller {

/**
 * 加载的组件
 * @var array
 */
	public $components = array('Session', 'Paginator', 'Auth', 'Security' => array('csrfUseOnce' => false));

/**
 * 加载的视图助手
 * @var array
 */
	public $helpers = array();

/**
 * 加载的模型
 * @var array
 */
	public $uses = array();

/**
 * 分页默认参数
 * @var array
 */
	public $paginate = array(
		'paramType' => 'querystring',
		'limit' => 10
	);

/**
 * 页面主标题
 * @var string
 */
	public $controllerTitle = null;

/**
 * 页面副标题
 * @var string
 */
	public $actionTitle = null;

/**
 * 管理端标志
 * @var boolean
 */
	protected $_admin = false;

/**
 * 显示信息session标志
 * @var boolean
 */
	protected $_flashKey = 'Front';

/**
 * 控制器方法调用前回调方法
 * 
 * @return void
 */
	public function beforeFilter() {
		if (isset($this->request->params['admin']) && $this->request->params['admin'] == true) {
			$this->_admin = true;
			$this->_flashKey = 'Admin';
			$this->__setAdminAuthConfig();
			$this->layout = 'Admin/default';
			$this->helpers = array_merge($this->helpers, array('Admin'));
		} else {
			$this->__setFrontAuthConfig();
			$this->layout = 'Front/default';
		}
	}

/**
 * 模板加载前回调方法
 * 
 * @return void
 */
	public function beforeRender() {
		parent::beforeRender();
		$this->set('controllerTitle', $this->controllerTitle);
		$this->set('actionTitle', $this->actionTitle);
		if ($this->_admin == true) {
			$this->__setAdminBeforeRender();
		} else {
			$this->__setFrontBeforeRender();
		}
	}

/**
 * 显示信息
 * 
 * @param string $message 内容
 * @param string $element element
 * @param array $params 参数
 * @return void
 */
	protected function _showFlashMessage($message, $element = 'error', $params = array()) {
		$prefix = $this->_admin == true ? 'Admin' : 'Front';
		$flashElement = sprintf('%s/Flash/%s', $prefix, $element);
		$this->Session->setFlash($message, $flashElement, $params, $this->_flashKey);
	}

/**
 * 显示错误信息
 * 
 * @param string $message 内容
 * @param array $params 参数
 * @return void
 */
	protected function _showErrorMessage($message, $params = array()) {
		$this->_showFlashMessage($message, 'error', $params);
	}

/**
 * 显示成功信息
 * 
 * @param string $message 内容
 * @param array $params 参数
 * @return void
 */
	protected function _showSuccessMessage($message, $params = array()) {
		$this->_showFlashMessage($message, 'success', $params);
	}

/**
 * 显示提示信息
 * 
 * @param string $message 内容
 * @param array $params 参数
 * @return void
 */
	protected function _showInfoMessage($message, $params = array()) {
		$this->_showFlashMessage($message, 'info', $params);
	}

/**
 * 显示警告信息
 * 
 * @param string $message 内容
 * @param array $params 参数
 * @return void
 */
	protected function _showWarningMessage($message, $params = array()) {
		$this->_showFlashMessage($message, 'warning', $params);
	}

/**
 * 管理端Auth配置
 * 
 * @return void
 */
	private function __setAdminAuthConfig() {
		AuthComponent::$sessionKey = 'Auth.Admin';
		$this->Auth->authenticate = array(
			'Form' => array(
				'userModel' => 'User',
				'contain' => false,
				'fields' => array('username' => 'email'),
				'scope' => null,
				'passwordHasher' => array(
					'className' => 'Simple',
					'hashType' => 'sha256'
				)
			)
		);
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => true);
		$this->Auth->loginRedirect = array('controller' => 'dashboard', 'action' => 'index', 'admin' => true);
		$this->Auth->flash = array('element' => 'Admin/Flash/warning', 'key' => 'Admin');
		$this->Auth->authError = '无权访问该页面！';
	}

/**
 * 管理端模板加载前
 * 
 * @return void
 */
	private function __setAdminBeforeRender() {
		$this->set('sideMenus', array());
	}

/**
 * 前端Auth配置
 * 
 * @return void
 */
	private function __setFrontAuthConfig() {
		AuthComponent::$sessionKey = 'Auth.Front';
		$this->Auth->allow();
	}

/**
 * 前端模板加载前
 * 
 * @return void
 */
	private function __setFrontBeforeRender() {
	}
}
