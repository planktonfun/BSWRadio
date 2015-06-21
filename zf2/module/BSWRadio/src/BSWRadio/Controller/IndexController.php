<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace BSWRadio\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction() {
    	return $this->redirect()->toRoute('dj_client', array(
		    'action' => 'client'
		));
    }

    public function clientAction() {
    	$service = $this->getServiceLocator()->get('bsw_radio_service');
    	$config = $service->getConfig();
		$playlist = $service->getSongList();		

		$view = new ViewModel();
		
		foreach ( $config as $name => $value) {
			$view->setVariable($name, $value);
		}

		$view->setVariable('playlist', $playlist);

        return $view;
    }

    public function deejayAction() {
    	$service = $this->getServiceLocator()->get('bsw_radio_service');
    	$config = $service->getConfig();
		$playlist = $service->getSongList();		

		$view = new ViewModel();
		
		foreach ( $config as $name => $value) {
			$view->setVariable($name, $value);
		}

		$view->setVariable('playlist', $playlist);

		$service->djupdate();

        return $view;
    }

    public function refreshAction() {
    	$service = $this->getServiceLocator()->get('bsw_radio_service');
    	$service->refresh();

    	return $this->response;
    }

    public function lanAction() {
    	return new ViewModel();
    }

    public function serverAction() {
    	return new ViewModel();
    }

}
