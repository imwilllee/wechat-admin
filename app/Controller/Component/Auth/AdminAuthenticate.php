<?php
App::uses('FormAuthenticate', 'Controller/Component/Auth');
/**
 * 管理端登陆验证Auth扩展
 *
 * @copyright WechatAdmin
 * @package   app.Controller.Component.Auth
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class AdminAuthenticate extends FormAuthenticate {

/**
 * 扩展登陆验证支持多字段验证
 * 
 * @param CakeRequest $request The request that contains login information.
 * @param CakeResponse $response Unused response object.
 * @return mixed False on login failure. An array of User data on success.
 */
	public function authenticate(CakeRequest $request, CakeResponse $response) {
		$userModel = $this->settings['userModel'];
		list(, $model) = pluginSplit($userModel);

		$fields = $this->settings['fields'];
		if (!$this->_checkFields($request, $model, $fields)) {
			return false;
		}
		$username = $request->data[$model][$fields['username']];
		if (!empty($this->settings['both_fields'])) {
			$fieldName = $model . '.' . $fields['username'];
			$conditions = array(
				'OR' => array(
					$fieldName => $username,
				)
			);
			if (is_string($this->settings['both_fields'])) {
				$fieldName = $model . '.' . $this->settings['both_fields'];
				$conditions['OR'][$fieldName] = $username;
			} elseif (is_array($this->settings['both_fields'])) {
				foreach ($this->settings['both_fields'] as $field) {
					$fieldName = $model . '.' . $field;
					$conditions['OR'][$fieldName] = $username;
				}
			}
			return $this->_findUser(
				$conditions,
				$request->data[$model][$fields['password']]
			);
		}
		return $this->_findUser(
			$username,
			$request->data[$model][$fields['password']]
		);
	}
}