<?php
App::uses('Helper', 'View');
/**
 * 项目全局视图助手
 *
 * @copyright WechatAdmin
 * @package   app.View.Helper
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class AppHelper extends Helper {

/**
 * 格式化显示日期时间
 * 
 * @param string $date 日期
 * @param string $format 格式
 * @return string
 */
	public function showDateTime($date, $format = 'Y-m-d') {
		if (empty($date)) {
			return null;
		}
		$date = new DateTime($date);
		return !$date ? null : $date->format($format);
	}
}
