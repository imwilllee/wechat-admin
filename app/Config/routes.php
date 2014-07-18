<?php
/**
 * 路由定义
 * 定义项目核心url访问规则
 *
 * @copyright WechatAdmin
 * @package   app.Config
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 项目入口
 */
	Router::connect('/', array('controller' => 'home', 'action' => 'index'));

/**
 * 管理登陆入口
 */
	Router::connect('/admin', array('controller' => 'users', 'action' => 'login', 'admin' => true));
	Router::connect('/admin/logout', array('controller' => 'users', 'action' => 'logout', 'admin' => true));

/**
 * 默认plugin路由定义
 */
	CakePlugin::routes();

/**
 * 默认路由定义
 */
	require CAKE . 'Config' . DS . 'routes.php';
