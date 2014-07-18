<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * users表模型
 *
 * @copyright WechatAdmin
 * @package   app.Model
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class User extends AppModel {

/**
 * belongsTo 关系定义
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * 数据保存前回调方法
 * 
 * @param array $options 参数
 * @return boolean
 */
	public function beforeSave($options = array()) {
		if (isset($this->data['User']['password']) && $this->data['User']['password'] != '') {
			$passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
			$this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
		} else {
			unset($this->data['User']['password']);
		}
	}
}
