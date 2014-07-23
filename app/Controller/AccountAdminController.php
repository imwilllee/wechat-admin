<?php
App::uses('AppController', 'Controller');
/**
 * 公众号管理控制器
 *
 * @copyright WechatAdmin
 * @package   app.Controller
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class AccountAdminController extends AppController {

/**
 * 主标题
 * @var string
 */
	public $controllerTitle = '微信公众平台';

/**
 * 公众号管理
 * 
 * @return void
 */
	public function admin_index() {
		$this->actionTitle = '公众号管理';
	}

/**
 * 添加公众号
 * 
 * @return void
 */
	public function admin_add() {
		$this->actionTitle = '添加公众号';
	}
}