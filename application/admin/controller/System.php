<?php
namespace app\admin\controller;

/**
 * 	系统设置控制器
 */
class System extends Common {

	/**
	 * 网站设置
	 */
	Public function index() {
		$config = include APP_PATH . DS . 'index/extra/system.php';

		return view('', ['config' => $config]);
	}

	/**
	 * 修改网站设置
	 */
	Public function runEdit() {
		$path = APP_PATH . DS . 'index/extra/system.php';
		$config = include $path;
		$config['WEBNAME'] = $_POST['webname'];
		$config['COPY'] = $_POST['copy'];
		$config['REGIS_ON'] = $_POST['regis_on'];

		$data = "<?php\r\nreturn " . var_export($config, true) . ";\r\n?>";

		if (file_put_contents($path, $data)) {
			$this->success('修改成功', url('index'));
		} else {
			$this->error('修改失败， 请修改' . $path . '的写入权限');
		}
	}

	/**
	 * 关键设置视图
	 */
	Public function filter() {
		$config = include APP_PATH . DS . 'index/extra/system.php';
		$this->assign('filter', implode('|', $config['FILTER']));
		return $this->fetch();
	}

	/**
	 * 执行修改关键词
	 */
	Public function runEditFilter() {
		$path = APP_PATH . DS . 'index/extra/system.php';
		$config = include $path;
		$config['FILTER'] = explode('|', $_POST['filter']);

		$data = "<?php\r\nreturn " . var_export($config, true) . ";\r\n?>";

		if (file_put_contents($path, $data)) {
			$this->success('修改成功', url('filter'));
		} else {
			$this->error('修改失败， 请修改' . $path . '的写入权限');
		}
	}

}
?>