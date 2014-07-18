<?php
App::uses('AppController', 'Controller');
/**
 * 项目入口控制器
 *
 * @copyright WechatAdmin
 * @package   app.Controller
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class HomeController extends AppController {

/**
 * 默认入口方法
 * 
 * @return void
 */
	public function index() {
		$this->autoRender = false;
	}
}