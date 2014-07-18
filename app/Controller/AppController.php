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
	public $components = array('Session', 'Auth');

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
 * 管理端标志
 * @var boolean
 */
	protected $_admin = false;

/**
 * 控制器方法调用前回调方法
 * 
 * @return void
 */
	public function beforeFilter() {
		if (isset($this->request->params['admin']) && $this->request->params['admin'] == true) {
			$this->_admin = true;
			$this->__setAdminAuthConfig();
			$this->layout = 'admin';
		} else {
			$this->__setFrontAuthConfig();
		}
	}

/**
 * 模板加载前回调方法
 * 
 * @return void
 */
	public function beforeRender() {
		parent::beforeRender();
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
				'fields' => array('username' => 'email'),
				'scope' => null,
				'contain' => null,
				'passwordHasher' => array(
					'className' => 'Simple',
					'hashType' => 'sha256'
				)
			)
		);
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => true);
		$this->Auth->loginRedirect = array('controller' => 'dashboard', 'action' => 'index', 'admin' => true);
		$this->Auth->flash = array('element' => 'Admin/Flash/warning', 'key' => 'admin');
		$this->Auth->authError = '无权访问该页面！';
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
}
