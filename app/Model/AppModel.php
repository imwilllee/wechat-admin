<?php
App::uses('Model', 'Model');
App::uses('Inflector', 'Utility');
App::uses('CakeSession', 'Model/Datasource');
/**
 * 项目全局模型
 * 在此文件内定义的方法可在项目其他模型内调用
 *
 * @copyright WechatAdmin
 * @package   app.Model
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class AppModel extends Model {

/**
 * 加载行为
 * @var array
 */
	public $actsAs = array('Containable');

/**
 * 数据验证前回调方法
 * 
 * @param array $options 参数
 * @return boolean
 */
	public function beforeValidate($options = array()) {
		if (isset($options['validate']) && $options['validate'] == true) {
			$ruleFuc = !empty($options['validateRule']) ? 'validate_' . $options['validateRule'] : 'validate_default';
			$method = Inflector::variable($ruleFuc);
			if (method_exists($this, $method)) {
				call_user_func_array(array($this, $method), array($options));
			}
		}
		return true;
	}

/**
 * 数据保存前回调方法
 * 
 * @param array $options 参数
 * @return boolean
 */
	public function beforeSave($options = array()) {
		if (CakeSession::check('Auth.Admin')) {
			$uid = CakeSession::read('Auth.Admin.id');
			// 新增的情况下
			if (empty($this->data[$this->alias][$this->primaryKey])) {
				if ($this->hasField('created_by')) {
					if (!isset($this->data[$this->alias]['created_by'])) {
						$this->data[$this->alias]['created_by'] = $uid;
					} elseif ($this->data[$this->alias]['created_by'] === false) {
						unset($this->data[$this->alias]['created_by']);
					}
				}
			}
			if ($this->hasField('updated_by')) {
				if (!isset($this->data[$this->alias]['updated_by'])) {
					$this->data[$this->alias]['updated_by'] = $uid;
				} elseif ($this->data[$this->alias]['updated_by'] === false) {
					unset($this->data[$this->alias]['updated_by']);
				}
			}
		}
		return true;
	}

/**
 * 对比两个值是否相等
 * 
 * @param string $check 比较内容
 * @param string $targetField 对比字段
 * @return boolean
 */
	public function confirm($check, $targetField) {
		$value = array_values($check);
		return $value[0] == $this->data[$this->alias][$targetField];
	}

/**
 * 日期格式检查
 * 
 * @param string $check 比较内容
 * @param string $format 日期格式
 * @return boolean
 */
	public function checkDateTimeFormat($check, $format = 'Y-m-d') {
		$value = array_values($check);
		$date = DateTime::createFromFormat($format, $value[0]);
		return $date && $date->format($format) == $value[0];
	}

/**
 * 开启事务
 * 
 * @return void
 */
	public function begin() {
		$this->getDataSource()->begin();
	}

/**
 * 事务回滚
 * 
 * @return void
 */
	public function rollback() {
		$this->getDataSource()->rollback();
	}

/**
 * 事务提交
 * 
 * @return void
 */
	public function commit() {
		$this->getDataSource()->commit();
	}

/**
 * 清空表数据
 * 
 * @return boolean
 */
	public function truncate() {
		$sql = sprintf('TRUNCATE TABLE %s;', $this->tablePrefix . $this->table);
		return $this->query($sql);
	}
}
