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
		$accesses = $this->GroupAccess->getUserGroupAccessIds($id);
		$menus = $this->Menu->getMenuActions();
		$checked = $id == Configure::read('Group.supper_id') ? true : false;
		$this->set(compact('group', 'accesses', 'menus', 'checked'));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id ID
 * @throws NotFoundDataException
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Group->exists($id)) {
			throw new NotFoundDataException(__('Invalid group'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$this->request->data = $this->Group->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @param string $id ID
 * @throws NotFoundDataException
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundDataException(__('Invalid group'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Group->delete()) {
			$this->Session->setFlash(__('The group has been deleted.'));
		} else {
			$this->Session->setFlash(__('The group could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
