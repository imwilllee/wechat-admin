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
				array('link' => 'admin/dashboard/index', 'name' => '查看')
			)
		),
		array(
			'menu_code' => 'wechat',
			'parent_code' => null,
			'name' => '微信公众号',
			'link' => null,
			'class' => 'fa fa-wechat',
			'rank' => 0,
			'display_flg' => true,
		),
		array(
			'menu_code' => null,
			'parent_code' => 'wechat',
			'name' => '公众号管理',
			'link' => 'admin/account_admin/index',
			'class' => null,
			'rank' => 0,
			'display_flg' => true,
			'menu_actions' => array(
				array('link' => 'admin/account_admin/add', 'name' => '创建'),
				array('link' => 'admin/account_admin/index', 'name' => '查看'),
				array('link' => 'admin/account_admin/view', 'name' => '详细'),
				array('link' => 'admin/account_admin/edit', 'name' => '编辑'),
				array('link' => 'admin/account_admin/delete', 'name' => '删除')
			)
		),
		array(
			'menu_code' => null,
			'parent_code' => 'wechat',
			'name' => '添加公众号',
			'link' => 'admin/account_admin/add',
			'class' => null,
			'rank' => 0,
			'display_flg' => true
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
				array('link' => 'admin/groups/view', 'name' => '详细'),
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
				$menu['has_actions'] = true;
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
		$supperAdmin = CakeSession::read('Auth.Admin.group_id') == Configure::read('Group.supper_id') ? true : false;
		$access = CakeSession::read('Auth.Admin.Access');
		$menus = Cache::read('cache_admin_menus');

		if (empty($menus)) {
			$conditions = array(
				'Menu.menu_code IS NOT NULL',
				'Menu.parent_code IS NULL',
				'Menu.display_flg' => true
			);
			$order = array('Menu.rank' => 'ASC');
			$menus = $this->__getMenus($conditions, $order);
			if (!empty($menus)) {
				Cache::write('cache_admin_menus', $menus);
			}
		}
		// 顶级菜单处理
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
				$conditions = array(
					'Menu.menu_code IS NULL',
					'Menu.parent_code IS NOT NULL',
					'Menu.display_flg' => true
				);
				$order = array('Menu.parent_code' => 'ASC', 'Menu.rank' => 'ASC');
				$hasMenus = $this->__getMenus($conditions, $order);
				if (!empty($hasMenus)) {
					Cache::write('cache_admin_has_menus', $hasMenus);
				}
			}

			// 二级菜单处理
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

/**
 * 菜单对应操作取得
 * 
 * @return array
 */
	public function getMenuActions() {
		$menuActions = array();
		// 主菜单
		$conditions = array(
			'Menu.menu_code IS NOT NULL',
			'Menu.parent_code IS NULL'
		);
		$order = array('Menu.rank' => 'ASC');
		$rootMenus = $this->__getMenus($conditions, $order, array('MenuAction'));
		foreach ($rootMenus as $root) {
			if (!empty($root['MenuAction'])) {
				$root['Menu']['has_actions'] = $root['MenuAction'];
			}
			$root['Menu']['has_menus'] = array();
			$menuActions[$root['Menu']['menu_code']] = $root['Menu'];
		}
		unset($rootMenus);

		// 子菜单
		$conditions = array(
			'Menu.menu_code IS NULL',
			'Menu.parent_code IS NOT NULL',
			'Menu.has_actions' => true
		);
		$order = array('Menu.parent_code' => 'ASC', 'Menu.rank' => 'ASC');
		$childMenus = $this->__getMenus($conditions, $order, array('MenuAction'));
		foreach ($childMenus as $child) {
			$menuCode = $child['Menu']['parent_code'];
			if (isset($menuActions[$menuCode])) {
				$child['Menu']['has_actions'] = $child['MenuAction'];
				$menuActions[$menuCode]['has_menus'][] = $child['Menu'];
			}
		}
		unset($childMenus);
		return $menuActions;
	}

/**
 * 取得菜单
 * 
 * @param array $conditions 顶级节点标志
 * @param array $order 排序
 * @param mixed $contain 关联模型
 * @return array
 */
	private function __getMenus($conditions = array(), $order = array(), $contain = false) {
		$options = array(
			'fields' => array('id', 'plugin_code', 'menu_code', 'parent_code', 'name', 'link', 'class'),
			'conditions' => $conditions,
			'order' => $order,
			'contain' => $contain
		);
		return $this->find('all', $options);
	}
}
