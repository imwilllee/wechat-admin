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
		if ($this->_admin == true) {
			$this->Auth->allow(array('admin_login', 'admin_logout'));
			if ($this->request->is('ajax')) {
				$this->Security->unlockedActions = array('admin_upload');
			}
		}
		parent::beforeFilter();
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
				if ($user['is_active'] == Configure::read('Default.active_ok') &&
					$user['Group']['is_active'] == Configure::read('Default.active_ok')) {
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
 * @throws NotFoundDataException
 * @return void
 */
	public function admin_view($id = null) {
		$this->actionTitle = '管理员详细';
		if (is_null($id)) {
			$id = $this->Session->read('Auth.Admin.id');
		}
		if (!$this->User->exists($id)) {
			throw new NotFoundDataException('数据不存在或已被删除！');
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
			if ($this->User->save($this->request->data, array('validateRule' => 'default'))) {
				$this->_showSuccessMessage('数据保存成功！');
				return $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
			} else {
				$this->_showErrorMessage('数据保存失败！请根据错误提示修正。');
			}
		}
		$groups = $this->User->Group->getGroupList();
		$this->set(compact('groups'));
	}

/**
 * 管理员编辑
 *
 * @param string $id ID
 * @throws NotFoundDataException
 * @return void
 */
	public function admin_edit($id = null) {
		$this->actionTitle = '管理员编辑';
		$options = array('conditions' => array('User.id' => $id), 'contain' => false);
		$user = !empty($id) ? $this->User->find('first', $options) : null;
		if (empty($user)) {
			throw new NotFoundDataException('数据不存在或已被删除！');
		}
		if (!$this->__userExclusive($user['User']['group_id'])) {
			$this->_showWarningMessage('不能编辑其他用户组下用户！');
			return $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
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
		$groups = $this->User->Group->getGroupList();
		$this->set(compact('groups'));
	}

/**
 * 管理员删除
 *
 * @param string $id ID
 * @throws NotFoundDataException
 * @return void
 */
	public function admin_delete($id = null) {
		$this->actionTitle = '管理员删除';
		$options = array('conditions' => array('User.id' => $id), 'contain' => array('Group'));
		$user = !empty($id) ? $this->User->find('first', $options) : null;
		if (empty($user)) {
			throw new NotFoundDataException('数据不存在或已被删除！');
		}
		if ($id == $this->Session->read('Auth.Admin.id')) {
			$this->_showWarningMessage('不能删除当前登陆用户！');
			return $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
		}
		if (!$this->__userExclusive($user['User']['group_id'])) {
			$this->_showWarningMessage('不能删除其他用户组下用户！');
			return $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
		}

		if ($this->request->is('delete')) {
			$this->User->id = $id;
			if ($this->User->delete()) {
				$this->_showSuccessMessage('数据删除成功！');
				return $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
			} else {
				$this->_showErrorMessage('数据删除失败！');
			}
		}
		$this->set(compact('user'));
	}

/**
 * 上传头像
 * 
 * @return void
 */
	public function admin_upload() {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$rs = array('err' => 1, 'err_msg' => '', 'url' => '');
			if (empty($this->request->form['avatar_file']['tmp_name'])) {
				$rs['err_msg'] = '没有选择上传文件！';
			} else {
				$ext = pathinfo($this->request->form['avatar_file']['name'], PATHINFO_EXTENSION);
				$dir = Configure::read('User.avatar.save_dir');
				$fileName = md5_file($this->request->form['avatar_file']['tmp_name']) . '.' . $ext;
				$path = $dir . $fileName;
				if (move_uploaded_file($this->request->form['avatar_file']['tmp_name'], $path)) {
					$rs['err'] = 0;
					$rs['url'] = sprintf(Configure::read('User.avatar.preview_url'), $fileName);
				}
			}
			$this->response->type('json');
			$this->response->body(json_encode($rs));
		} else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->_stop();
		}
	}
/**
 * 数据排他限制
 * 
 * @param integer $userGroupId 用户组ID
 * @return boolean
 */
	private function __userExclusive($userGroupId) {
		if ($this->Session->read('Auth.Admin.group_id') != Configure::read('Group.supper_id')) {
			if ($userGroupId != $this->Session->read('Auth.Admin.group_id')) {
				return false;
			}
		}
		return true;
	}
}
