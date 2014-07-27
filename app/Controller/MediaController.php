<?php
App::uses('AppController', 'Controller');
/**
 * 资源管理器控制器
 *
 * @copyright WechatAdmin
 * @package   app.Controller
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class MediaController extends AppController {

/**
 * 主标题
 * @var string
 */
	public $controllerTitle = '资源管理器';

/**
 * 控制器方法调用前回调方法
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
	}

/**
 * 文件管理
 * 
 * @return void
 */
	public function admin_index() {
		$this->actionTitle = '文件管理';
	}

/**
 * 上传文件
 * 
 * @return void
 */
	public function admin_upload() {
		$this->actionTitle = '上传文件';
	}
}