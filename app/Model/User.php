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
 * 默认验证规则
 *
 * @param array $options 参数
 * @return void
 */
	public function validateDefault($options = array()) {
		$groups = array_keys($this->Group->getGroupList());
		$this->validator()
			->add('username', array(
				'required' => array(
					'on' => 'create',
					'required' => 'create',
					'rule' => 'notEmpty',
					'message' => '用户名必须填写！',
					'last' => true
				),
				'custom' => array(
					'on' => 'create',
					'rule' => '/^[a-z0-9]{6,12}$/i',
					'message' => '用户名格式错误！',
					'last' => false
				),
				'unique' => array(
					'on' => 'create',
					'rule' => 'isUnique',
					'message' => '该用户名已存在！',
					'last' => false
				)
			))
			->add('email', array(
				'required' => array(
					'rule' => 'notEmpty',
					'required' => true,
					'message' => '邮箱必须填写！',
					'last' => true
				),
				'email' => array(
					'rule' => 'email',
					'message' => '邮箱格式错误！',
					'last' => false
				),
				'maxLength' => array(
					'rule' => array('maxLength', 32),
					'message' => '邮箱长度超出限制！',
					'last' => false
				),
				'unique' => array(
					'rule' => 'isUnique',
					'message' => '该邮箱已存在！',
					'last' => false
				)
			))
			->add('password', array(
				'required' => array(
					// 创建的时候规则生效(当不设置on或者on=null的时候两者都生效)
					'on' => 'create',
					// 项目必须存在
					'required' => 'create',
					// 值不能为空
					'rule' => 'notEmpty',
					'message' => '密码必须填写！',
					'last' => true
				),
				'custom' => array(
					'rule' => '/^[_0-9a-zA-Z]{6,32}$/i',
					'message' => '密码格式错误！',
					'allowEmpty' => true,
					'last' => false
				)
			))
			->add('confirm_password', array(
				'required' => array(
					'on' => 'create',
					'required' => 'create',
					'rule' => 'notEmpty',
					'message' => '确认密码必须填写！',
					'last' => true
				),
				'confirm' => array(
					'on' => 'create',
					'rule' => array('confirm', 'password'),
					'message' => '两次密码输入不一致！',
					'last' => false
				)
			))
			->add('group_id', array(
				'required' => array(
					'required' => true,
					'rule' => 'notEmpty',
					'message' => '请选择一个用户组！',
					'last' => true
				),
				'inList' => array(
					'rule' => array('inList', $groups),
					'message' => '所属用户组选择错误！',
					'last' => false
				)
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
			->add('alias_name', array(
				'maxLength' => array(
					'rule' => array('maxLength', 18),
					'message' => '用户昵称长度超出限制！',
					'allowEmpty' => true,
					'last' => false
				)
			))
			->add('mobile', array(
				'custom' => array(
					'rule' => '/^[_0-9]{11}$/i',
					'message' => '手机号码格式错误！',
					'allowEmpty' => true,
					'last' => false
				)
			))
			->add('birth', array(
				'checkDateTimeFormat' => array(
					'rule' => array('checkDateTimeFormat', 'Y-m-d'),
					'message' => '出生年月格式错误！',
					'allowEmpty' => true,
					'last' => false
				)
			))
			->add('sex', array(
				'inList' => array(
					'rule' => array('inList', array_keys(Configure::read('User.sex'))),
					'message' => '性别选择项目错误！',
					'allowEmpty' => true,
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
			))
			->add('avatar', array(
				'maxLength' => array(
					'rule' => array('maxLength', 500),
					'message' => '头像路径长度超出限制！',
					'allowEmpty' => true,
					'last' => false
				)
			));
	}

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
		parent::beforeSave($options);
	}
}
