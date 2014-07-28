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
	public $components = array();

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
		'limit' => 10,
		'maxLimit' => 50
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
 * 构造函数重构
 * 
 * @param CakeRequest $request 请求对象
 * @param CakeResponse $response 响应对象
 */
	public function __construct($request = null, $response = null) {
		if (isset($request->params['admin']) && $request->params['admin'] == true) {
			// 管理端加载配置
			$this->_admin = true;
			$this->_flashKey = 'Admin';
			$components = array(
				'Session',
				'Paginator',
				'Auth' => array(
					'authenticate' => array(
						'Admin' => array(
							'userModel' => 'User',
							'contain' => array('Group'),
							// 'fields' => array('username' => 'email'),
							// 多字段验证 支持数组
							'both_fields' => 'email',
							'scope' => null,
							'passwordHasher' => array(
								'className' => 'Simple',
								'hashType' => 'sha256'
							)
						)
					),
					'loginAction' => array('controller' => 'users', 'action' => 'login', 'admin' => true),
					'loginRedirect' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
					'flash' => array('element' => 'Admin/Flash/warning', 'key' => 'Admin'),
					'authError' => '无权访问该页面！'
				),
				'Security' => array(
					'csrfUseOnce' => false
				)
			);
			$this->components = array_merge($components, $this->components);
		} else {
			// 前端加载配置
		}
		parent::__construct($request, $response);
	}

/**
 * 控制器方法调用前回调方法
 *
 * @throws NoPermissionException
 * @return void
 */
	public function beforeFilter() {
		if ($this->_admin == true) {
			$this->Security->blackHoleCallback = 'blackhole';
			AuthComponent::$sessionKey = 'Auth.Admin';
			$this->layout = 'Admin/default';
			$this->helpers = array_merge($this->helpers, array('Admin'));

			if (!in_array($this->request->params['action'], $this->Auth->allowedActions)) {
				if (!$this->Auth->loggedIn()) {
					return false;
				}
				if (!$this->__checkUserAccess()) {
					throw new NoPermissionException("该账号暂无权访问该页面！");
				}
			}
		} else {
			$this->layout = 'Front/default';
		}
	}

/**
 * Security错误捕获处理
 * 
 * @param string $type 类型
 * @throws BadHttpRequestException 异常
 * @return void
 */
	public function blackhole($type) {
		throw new BadHttpRequestException('非法请求！');
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
			// 管理端
			if ($this->Auth->loggedIn()) {
				$this->loadModel('Menu');
				$this->set('sideBarMenus', $this->Menu->getLeftSidebarMenus());
			}
		} else {
			// 前端
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
 * 检查用户访问权限
 * 
 * @return boolean
 */
	private function __checkUserAccess() {
		if ($this->Session->read('Auth.Admin.group_id') != Configure::read('Group.supper_id')) {
			$path = $prefix = null;
			$plugin = !empty($this->request->params['plugin']) ? strtolower($this->request->params['plugin']) . '/' : null;
			$controller = strtolower($this->request->params['controller']) . '/';
			$action = strtolower($this->request->params['action']);

			if (!empty($this->request->params['prefix'])) {
				$prefix = strtolower($this->request->params['prefix']);
				$find = $prefix . '_';
				$action = str_replace($find, '', $action);
				$prefix .= '/';
			}
			$path = $prefix . $plugin . $controller . $action;
			unset($prefix, $plugin, $controller, $action);
			if (!in_array($path, $this->Session->read('Auth.Admin.Access'))) {
				return false;
			}
		}
		return true;
	}
}
