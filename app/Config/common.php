<?php
/**
 * 项目配置文件
 *
 * @copyright WechatAdmin
 * @package   app.Config
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
$config = array(
	'WeChat' => array(
		'name' => 'WeChatAdmin',
		'title_separator' => '_'
	),
/**
 * 默认配置项
 */
	'Default' => array(
		'avatar_src' => '/img/avatar/00.png',
		'active_ok' => 1,
		'active' => array(
			0 => '禁止',
			1 => '允许'
		)
	),
/**
 * 用户配置项
 */
	'User' => array(
		'sex' => array(
			0 => '保密',
			1 => '男性',
			2 => '女性'
		)
	),
/**
 * 用户组配置项
 */
	'Group' => array(
		'supper_id' => 1
	)
);