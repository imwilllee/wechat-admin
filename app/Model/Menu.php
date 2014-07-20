<?php
App::uses('AppModel', 'Model');
App::uses('CakeSession', 'Model/Datasource');
/**
 * menus表模型
 *
 * @copyright WechatAdmin
 * @package   app.Model
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Menu extends AppModel {

/**
 * hasMany 关系定义
 * @var array
 */
	public $hasMany = array(
		'MenuAction' => array(
			'className' => 'MenuAction',
			'foreignKey' => 'menu_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * 项目核心菜单定义
 * link定义用“/”分割,支持plugin定义
 * 例如 
 * 1. admin/dashboard/index 
 * admin代表路由前缀,dashboard代表控制器,index代表操作
 * 
 * 2. admin/weixin/users/index
 *
 * admin代表路由前缀,weixin代表插件名称,users代表控制器,index代表操作
 * 
 * @var array
 */
	protected $_defineCoreMenus = array(
		array(
			'menu_code' => 'dashboard',
			'parent_code' => null,
			'name' => '控制面板',
			'link' => 'admin/dashboard/index',
			'class' => 'fa fa-dashboard',
			'rank' => 0,
			'display_flg' => true,
			'menu_actions' => array(
				array('link' => 'admin/dashboard/index', 'name' => '控制面板')
			)
		),
		array(
			'menu_code' => 'users',
			'parent_code' => null,
			'name' => '管理员用户组',
			'link' => null,
			'class' => 'fa fa-user',
			'rank' => 0,
			'display_flg' => true
		),
		array(
			'menu_code' => null,
			'parent_code' => 'users',
			'name' => '系统管理员',
			'link' => 'admin/users/index',
			'class' => null,
			'rank' => 0,
			'display_flg' => true,
			'menu_actions' => array(
				array('link' => 'admin/users/add', 'name' => '创建'),
				array('link' => 'admin/users/index', 'name' => '查看'),
				array('link' => 'admin/users/view', 'name' => '详细'),
				array('link' => 'admin/users/edit', 'name' => '编辑'),
				array('link' => 'admin/users/delete', 'name' => '删除')
			)
		),
		array(
			'menu_code' => null,
			'parent_code' => 'users',
			'name' => '创建管理员',
			'link' => 'admin/users/add',
			'class' => null,
			'rank' => 0,
			'display_flg' => true
		),
		array(
			'menu_code' => null,
			'parent_code' => 'users',
			'name' => '用户组管理',
			'link' => 'admin/groups/index',
			'class' => null,
			'rank' => 0,
			'display_flg' => true,
			'menu_actions' => array(
				array('link' => 'admin/groups/add', 'name' => '创建'),
				array('link' => 'admin/groups/index', 'name' => '查看'),
				array('link' => 'admin/groups/edit', 'name' => '编辑'),
				array('link' => 'admin/groups/delete', 'name' => '删除')
			)
		),
		array(
			'menu_code' => null,
			'parent_code' => 'users',
			'name' => '创建用户组',
			'link' => 'admin/groups/add',
			'class' => null,
			'rank' => 0,
			'display_flg' => true
		)
	);

/**
 * 初始化menus表数据
 * 
 * @return boolean
 */
	public function initDB() {
		$this->truncate();
		$this->MenuAction->truncate();
		$this->begin();
		foreach ($this->_defineCoreMenus as $menu) {
			$data = array();
			if (!empty($menu['menu_actions'])) {
				$data['MenuAction'] = $menu['menu_actions'];
				unset($menu['menu_actions']);
			}
			$data['Menu'] = $menu;
			if (!$this->saveAll($data, array('validate' => false))) {
				$this->rollback();
				return false;
			}
		}
		$this->commit();
		Cache::delete('cache_admin_menus');
		Cache::delete('cache_admin_has_menus');
		return true;
	}

/**
 * 管理端左侧导航菜单
 * 
 * @return array
 */
	public function getLeftSidebarMenus() {
		$sideBarMenus = array();
		$options = array(
			'fields' => array('id', 'plugin_code', 'menu_code', 'parent_code', 'name', 'link', 'class'),
			'conditions' => array(
				'Menu.display_flg' => true,
				'Menu.menu_code IS NOT NULL',
				'Menu.parent_code IS NULL'
			),
			'order' => array('Menu.rank' => 'ASC'),
			'contain' => false
		);
		$supperAdmin = CakeSession::read('Auth.Admin.group_id') == Configure::read('Group.supper_admin_id') ? true : false;

		$access = CakeSession::read('Auth.Admin.Access');
		$menus = Cache::read('cache_admin_menus');
		if (empty($menus)) {
			$menus = $this->find('all', $options);
			Cache::write('cache_admin_menus', $menus);
		}
		foreach ($menus as $menu) {
			if ($supperAdmin == false) {
				if (!empty($menu['Menu']['link'])) {
					if (!in_array($menu['Menu']['link'], $access)) {
						continue;
					}
				}
			}
			$menu['Menu']['has_menus'] = array();
			$sideBarMenus[$menu['Menu']['menu_code']] = $menu['Menu'];
		}
		unset($menus);
		if (!empty($sideBarMenus)) {
			$hasMenus = Cache::read('cache_admin_has_menus');
			if (empty($hasMenus)) {
				$options['conditions'] = array(
					'Menu.display_flg' => true,
					'Menu.menu_code IS NULL',
					'Menu.parent_code IS NOT NULL'
				);
				$options['order'] = array('Menu.parent_code' => 'ASC', 'Menu.rank' => 'ASC');
				$hasMenus = $this->find('all', $options);
				Cache::write('cache_admin_has_menus', $hasMenus);
			}

			foreach ($hasMenus as $key) {
				if ($supperAdmin == false) {
					if (!empty($key['Menu']['link'])) {
						if (!in_array($key['Menu']['link'], $access)) {
							continue;
						}
					}
				}
				if (isset($sideBarMenus[$key['Menu']['parent_code']])) {
					$sideBarMenus[$key['Menu']['parent_code']]['has_menus'][] = $key['Menu'];
				} else {
					$sideBarMenus[$key['Menu']['parent_code']] = $key['Menu'];
					$sideBarMenus[$key['Menu']['parent_code']]['has_menus'] = array();
				}
			}
			unset($hasMenus);
		}
		unset($options);
		return $sideBarMenus;
	}
}
