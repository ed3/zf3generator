<?php
namespace Generator\Controller;
use Zend\Mvc\Controller\AbstractActionController,
Zend\Db\Adapter\Adapter,
Zend\View\Model\ViewModel;
class IndexController extends AbstractActionController {
	private function mm() {
		$dbAdapter = new Adapter(['driver' => 'Mysqli','database' => 'test','username' => 'root','password' => '']);
		return new \Generator\Model\Generator($dbAdapter);
	}
	public function moduleAction() {
		if ($this->request->isPost()) {
		$params = $this->request->getPost();
		$createController = false;
		if (!empty($params['module_name'])) {
			$moduleName = ucfirst($params['module_name']);
			if (isset($params['create_controller'])) {
				$createController = true;
				if (!empty($params['controller_name'])) $controllerName = $params['controller_name'];
				else $controllerName = $moduleName;
			} else {
				$controllerName = null;
			}
			$this->mm()->generateModule($moduleName, $createController, $controllerName);
			$this->redirect()->toRoute('generator', array('action' => 'success', 'id' => 'Module'));
		}
		}
	}
	public function controllerAction() {
		$modules = $this->mm()->getModules();
		if($this->request->isPost()){
			$params = $this->request->getPost();
			if(!empty($params['controller_name'])){
			$this->mm()->createControllerForModule($params['module'], $params['controller_name'], $params['action_name']);
			$this->redirect()->toRoute('generator', array('action' => 'success', 'id' => 'Controller'));
			}
		}
		return array('modules' => $modules);
	}
	public function formAction() {
		$modules = $this->mm()->getModules();
		$tables = $this->mm()->getDatabaseTables();
		if ($this->request->isPost()) {
			$module = $this->request->getPost('module');
			$table = $this->request->getPost('table');
			$this->mm()->generateForm($module, $table);
			$this->redirect()->toRoute('generator', array('action' => 'success', 'id' => 'Form'));
		}
		return array('tables' => $tables, 'modules' => $modules);
	}
	public function successAction() {
		$type = $this->getEvent()->getRouteMatch()->getParam('id');
		return array('type' => $type);
	}
}
