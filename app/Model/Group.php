<?php
App::uses('AppModel', 'Model');
App::uses('CakeSession', 'Model/Datasource');
/**
 * groups表模型
 *
 * @copyright WechatAdmin
 * @package   app.Model
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Group extends AppModel {

/**
 * 用户组集合
 * 
 * @return array
 */
	public function getGroupList() {
		$options = array(
			'fields' => array('Group.id', 'Group.name'),
			'contain' => false
		);
		if (CakeSession::read('Auth.Admin.group_id') != Configure::read('Group.supper_id')) {
			$options['conditions'] = array('Group.id <>' => Configure::read('Group.supper_id'));
		}
		return $this->find('list', $options);
	}
}
