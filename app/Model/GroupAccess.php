<?php
App::uses('AppModel', 'Model');
/**
 * group_access表模型
 *
 * @copyright WechatAdmin
 * @package   app.Model
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class GroupAccess extends AppModel {

/**
 * 主键
 * @var boolean
 */
	public $primaryKey = false;

/**
 * belongsTo 关系定义
 * @var array
 */
	public $belongsTo = array(
		'MenuAction' => array(
			'className' => 'MenuAction',
			'foreignKey' => 'menu_action_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * 用户组访问权限
 * 
 * @param integer $groupId 用户组ID
 * @return array
 */
	public function getUserGroupAccess($groupId) {
		$access = array();
		$options = array(
			'conditions' => array('GroupAccess.group_id' => $groupId),
			'contain' => array('MenuAction')
		);
		$actions = $this->find('all', $options);
		foreach ($actions as $action) {
			$access[] = $action['MenuAction']['link'];
		}
		unset($options, $actions);
		return $access;
	}
}
