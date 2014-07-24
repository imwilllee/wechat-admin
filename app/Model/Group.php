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
 * hasMany 关系定义
 * @var array
 */
	public $hasMany = array(
		'GroupAccess' => array(
			'className' => 'GroupAccess',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * 默认验证规则
 *
 * @param array $options 参数
 * @return void
 */
	public function validateDefault($options = array()) {
		$this->validator()
			->add('name', array(
				'required' => array(
					'on' => 'create',
					'required' => 'create',
					'rule' => 'notEmpty',
					'message' => '名称必须填写！',
					'last' => true
				),
				'maxLength' => array(
					'rule' => array('maxLength', 32),
					'message' => '名称长度超出限制！',
					'last' => false
				),
			))
			->add('is_active', array(
				'required' => array(
					'required' => true,
					'rule' => 'notEmpty',
					'message' => '登陆限制必须选择！',
					'last' => true
				),
				'boolean' => array(
					'rule' => 'boolean',
					'message' => '登陆限制选择错误！',
					'last' => false
				)
			))
			->add('explain', array(
				'maxLength' => array(
					'rule' => array('maxLength', 500),
					'message' => '备注说明长度超出限制！',
					'allowEmpty' => true,
					'last' => false
				)
			));
	}

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
