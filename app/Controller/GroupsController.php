<?php
App::uses('AppController', 'Controller');
/**
 * 用户组管理控制器
 *
 * @copyright WechatAdmin
 * @package   app.Controller
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class GroupsController extends AppController {

	public $uses = array('Group', 'GroupAccess', 'Menu');

/**
 * 主标题
 * @var string
 */
	public $controllerTitle = '管理员用户组';

/**
 * 用户组管理
 *
 * @return void
 */
	public function admin_index() {
		$this->actionTitle = '用户组管理';
		$options = array(
			'contain' => false
		);
		$this->set('groups', $this->Group->find('all', $options));
	}

/**
 * 用户组详细
 *
 * @param string $id ID
 * @throws NotFoundDataException
 * @return void
 */
	public function admin_view($id = null) {
		$this->actionTitle = '用户组详细';
		if (!$this->Group->exists($id)) {
			throw new NotFoundDataException('数据不存在或已被删除！');
		}
		$options = array(
			'conditions' => array('Group.id' => $id),
			'contain' => false
		);
		$group = $this->Group->find('first', $options);
		$menus = $this->Menu->getMenuActions();
		$this->request->data['GroupAccess'] = $this->GroupAccess->getGroupAccessForCheckbox($id);
		$this->set(compact('group', 'menus'));
	}

/**
 * 创建用户组
 *
 * @return void
 */
	public function admin_add() {
		$this->actionTitle = '创建用户组';
		if ($this->request->is('post')) {
			if ($this->Group->saveAll($this->request->data)) {
				$this->_showSuccessMessage('数据保存成功！');
				return $this->redirect(array('controller' => 'groups', 'action' => 'index', 'admin' => true));
			} else {
				$this->_showErrorMessage('数据保存失败！请根据错误提示修正。');
			}
		}
		$menus = $this->Menu->getMenuActions();
		$this->set(compact('menus'));
	}

/**
 * 编辑用户组
 *
 * @param string $id ID
 * @throws NotFoundDataException
 * @return void
 */
	public function admin_edit($id = null) {
		$this->actionTitle = '编辑用户组';
		if (!$this->Group->exists($id)) {
			throw new NotFoundDataException('数据不存在或已被删除！');
		}
		if (Configure::read('Group.supper_id') == $id) {
			$this->_showWarningMessage('不能编辑超级管理员用户组！');
			return $this->redirect(array('controller' => 'groups', 'action' => 'index', 'admin' => true));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Group->validates($this->request->data)) {
				$this->Group->begin();
				$delete = $this->GroupAccess->deleteAll(array('GroupAccess.group_id' => $this->request->data['Group']['id']), false);
				if ($delete && $this->Group->saveAll($this->request->data, array('validate' => false, 'atomic' => false))) {
					$this->_showSuccessMessage('数据保存成功！');
					$this->Group->commit();
					return $this->redirect(array('controller' => 'groups', 'action' => 'index', 'admin' => true));
				} else {
					$this->Group->rollback();
					$this->_showErrorMessage('数据保存失败！');
				}
			} else {
				$this->_showErrorMessage('数据验证出错！请根据错误提示修正。');
			}
		} else {
			$options = array('conditions' => array('Group.id' => $id), 'contain' => false);
			$this->request->data = $this->Group->find('first', $options);
			$this->request->data['GroupAccess'] = $this->GroupAccess->getGroupAccessForCheckbox($id);
		}
		$menus = $this->Menu->getMenuActions();
		$this->set(compact('menus'));
	}

/**
 * 用户组删除
 *
 * @param string $id ID
 * @throws NotFoundDataException
 * @return void
 */
	public function admin_delete($id = null) {
		$this->actionTitle = '用户组删除';
		$options = array('conditions' => array('Group.id' => $id), 'contain' => false);
		$group = !empty($id) ? $this->Group->find('first', $options) : null;
		if (empty($group)) {
			throw new NotFoundDataException('数据不存在或已被删除！');
		}
		if (Configure::read('Group.supper_id') == $id) {
			$this->_showWarningMessage('不能删除超级管理员用户组！');
			return $this->redirect(array('controller' => 'groups', 'action' => 'index', 'admin' => true));
		}

		if ($this->request->is('delete')) {
			$this->Group->begin();
			$this->Group->id = $id;
			if ($this->Group->delete() && $this->GroupAccess->deleteAll(array('GroupAccess.group_id' => $id), false)) {
				$this->Group->commit();
				$this->_showSuccessMessage('数据删除成功！');
				return $this->redirect(array('controller' => 'groups', 'action' => 'index', 'admin' => true));
			} else {
				$this->Group->rollback();
				$this->_showErrorMessage('数据删除失败！');
			}
		}
		$this->set(compact('group'));
	}
}
