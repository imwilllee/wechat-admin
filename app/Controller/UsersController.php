<?php
App::uses('AppController', 'Controller');
/**
 * 用户管理控制器
 *
 * @copyright WechatAdmin
 * @package   app.Controller
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class UsersController extends AppController {

/**
 * 加载模型
 * @var array
 */
	public $uses = array('User');

/**
 * 主标题
 * @var string
 */
	public $controllerTitle = '管理员用户组';

/**
 * 控制器方法调用前回调方法
 * 
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		if ($this->_admin) {
			$this->Auth->allow(array('admin_login', 'admin_logout'));
		}
	}

/**
 * 用户登陆
 *
 * @return void
 */
	public function admin_login() {
		if ($this->Auth->loggedIn()) {
			return $this->redirect(array('controller' => 'dashboard', 'action' => 'index', 'admin' => true));
		}
		$this->layout = false;
		$this->controllerTitle = '管理员登陆';
		if ($this->request->is('post')) {
			$user = $this->Auth->identify($this->request, $this->response);
			if (empty($user)) {
				$this->_showErrorMessage('登录账号或密码错误！');
			} else {
				if ($user['is_active'] == Configure::read('User.active_ok') &&
					$user['Group']['is_active'] == Configure::read('Group.active_ok')) {
					if ($this->Auth->login($user)) {
						$this->__updateLoginInfo($user['id']);
						$this->__setUserAccess($user['group_id']);
						return $this->redirect($this->Auth->redirect());
					}
				} else {
					$this->_showErrorMessage('该账号已被限制登录！');
				}
			}
		}
	}

/**
 * 更新用户登陆信息
 *
 * @param integer $uid 用户信息
 * @return boolean
 */
	private function __updateLoginInfo($uid) {
		$data = array(
			'id' => $uid,
			'last_logined' => date('Y-m-d H:i:s'),
			'last_login_ip' => $this->request->clientIp(),
			'last_user_agent' => env('HTTP_USER_AGENT'),
			'updated' => false,
			'updated_by' => false
		);
		$this->Session->write('Auth.Admin.logined', $data['last_logined']);
		$this->Session->write('Auth.Admin.login_ip', $data['last_login_ip']);
		$this->Session->write('Auth.Admin.user_agent', $data['last_user_agent']);
		return $this->User->save($data, array('validate' => false));
	}

/**
 * 设置用户访问权限
 *
 * @param integer $groupId 用户组ID
 * @return void
 */
	private function __setUserAccess($groupId) {
		if ($groupId !== Configure::read('Group.supper_id')) {
			$this->loadModel('GroupAccess');
			$this->Session->write('Auth.Admin.Access', $this->GroupAccess->getUserGroupAccess($groupId));
		}
	}

/**
 * 退出登陆
 * 
 * @return void
 */
	public function admin_logout() {
		return $this->redirect($this->Auth->logout());
	}

/**
 * 系统管理员
 *
 * @return void
 */
	public function admin_index() {
		$this->actionTitle = '系统管理员';
		$options = array(
			'contain' => array('Group'),
			'conditions' => $this->__makeConditions(),
			'order' => array('User.updated' => 'DESC', 'User.id' => 'ASC')
		);
		$this->Paginator->settings = array_merge($this->paginate, $options);
		$users = $this->Paginator->paginate('User');
		$groups = $this->User->Group->find('list');
		$this->set(compact('users', 'groups'));
	}

/**
 * 检索条件组合
 * 
 * @return array
 */
	private function __makeConditions() {
		App::uses('Validation', 'Utility');
		$conditions = array();
		if ($this->request->is('post')) {
			$this->request->query = $this->request->data['User'];
		} else {
			$this->request->data['User'] = $this->request->query;
		}
		if (isset($this->request->query['username']) && Validation::notEmpty($this->request->query['username'])) {
			$conditions['User.username'] = $this->request->query['username'];
		}
		if (isset($this->request->query['email']) && Validation::notEmpty($this->request->query['email'])) {
			$conditions['User.email'] = $this->request->query['email'];
		}
		if (isset($this->request->query['mobile']) && Validation::notEmpty($this->request->query['mobile'])) {
			$conditions['User.mobile'] = $this->request->query['mobile'];
		}
		if (isset($this->request->query['group_id']) && Validation::notEmpty($this->request->query['group_id'])) {
			$conditions['User.group_id'] = $this->request->query['group_id'];
		}
		if (!empty($this->request->query['is_active'])) {
			$conditions['User.is_active'] = $this->request->query['is_active'];
		}
		return $conditions;
	}

/**
 * 管理员详细
 *
 * @param string $id ID
 * @throws NotFoundException
 * @return void
 */
	public function admin_view($id = null) {
		$this->actionTitle = '管理员详细';
		if (is_null($id)) {
			$id = $this->Session->read('Auth.Admin.id');
		}
		if (!$this->User->exists($id)) {
			throw new NotFoundException('用户信息不存在！');
		}
		$options = array(
			'conditions' => array('User.id' => $id),
			'contain' => array('Group')
		);
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * 创建管理员
 *
 * @return void
 */
	public function admin_add() {
		$this->actionTitle = '创建管理员';
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data, array('validateRule' => 'default'))) {
				$this->_showSuccessMessage('数据保存成功！');
				return $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
			} else {
				$this->_showErrorMessage('数据保存失败！请根据错误提示修正。');
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * 管理员编辑
 *
 * @param string $id ID
 * @throws NotFoundException
 * @return void
 */
	public function admin_edit($id = null) {
		$options = array('conditions' => array('User.id' => $id), 'contain' => false);
		$user = !empty($id) ? $this->User->find('first', $options) : null;
		if (empty($user)) {
			throw new NotFoundException('用户信息不存在！');
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->_showSuccessMessage('数据保存成功！');
				return $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
			} else {
				$this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
				$this->_showErrorMessage('数据保存失败！请根据错误提示修正。');
			}
		} else {
			$options = array('conditions' => array('User.id' => $id), 'contain' => false);
			unset($user['User']['password']);
			$this->request->data = $user;
		}
		unset($user);
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * delete method
 *
 * @param string $id ID
 * @throws NotFoundException
 * @return void
 */
	public function admin_delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
