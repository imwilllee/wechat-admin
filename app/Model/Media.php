<?php
App::uses('AppModel', 'Model');
/**
 * media表模型
 *
 * @copyright WechatAdmin
 * @package   app.Model
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Media extends AppModel {

/**
 * 保存文件信息
 * 
 * @param array $file 文件信息
 * @param array $config 配置参数
 * @return boolean
 */
	public function saveFileInfo($file, $config = array()) {
		$this->clear();
		$data = array(
			// 上传文件名
			'upload_name' => $file['name'],
			// 文件md5值
			'md5_hash' => $file['md5_hash'],
			// 保存文件名
			'save_name' => $file['save_name'],
			// 保存目录
			'save_dir' => $file['save_dir'],
			// mime类型
			'mime_type' => $file['type'],
			// 扩展名
			'extension' => $file['extension'],
			// 文件大小
			'size' => $file['size']
		);
		if (!empty($this->config['preview_url'])) {
			// 预览链接
			$data['preview_url'] = $config['preview_url'];
		}
		return $this->save($data);
	}
}
