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
		),
		'avatar' => array(
			'save_dir' => WWW_ROOT . 'img' . DS . 'avatar' . DS,
			'preview_url' => '/img/avatar/%s',
			// 限制大小(KB)
			'max_size' => 50
		)
	),
/**
 * 用户组配置项
 */
	'Group' => array(
		'supper_id' => 1
	),
/**
 * 媒体资源配置项
 */
	'Media' => array(
		// 上传规则
		'upload_rule' => array(
			'image' => array(
				// 允许图片上传扩展名
				'allow_ext' => array('bmp', 'png', 'jpeg', 'jpg', 'gif'),
				// 限制大小(KB) 2M
				'max_size' => 2048
			),
			'voice' => array(
				// 允许音频上传扩展名
				'allow_ext' => array('mp3', 'wma', 'wav', 'amr'),
				// 限制大小(KB) 5M
				'max_size' => 5120
			),
			'video' => array(
				// 允许视频上传扩展名
				'allow_ext' => array('rm', 'rmvb', 'wmv', 'avi', 'mpg', 'mpeg', 'mp4'),
				// 限制大小(KB) 20M
				'max_size' => 20480
			)
		),
		'type_mapping' => array(
			'image' => '图片',
			'voice' => '音频',
			'video' => '视频'
		)
	)
);