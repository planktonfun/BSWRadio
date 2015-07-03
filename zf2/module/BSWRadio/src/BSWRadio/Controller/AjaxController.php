<?php

namespace BSWRadio\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AjaxController extends AbstractActionController
{
    public function sendAction()
    {
    	$service = $this->getServiceLocator()->get('bsw_radio_service');

    	$post = $this->getRequest()->getPost();

    	if(isset($post['message'])) {
			$data['message'] = $post['message'];
			$data['localip'] = $post['localip'];
			$data['updatedj'] = false;
		} else {
			$data['message'] = 'hello world';
			$data['localip'] = 'n/a';
			$data['updatedj'] = false;
		}

		$service->send( $data );

		return $this->response;
    }

    public function setMessageAction() {    	

    	$service = $this->getServiceLocator()->get('bsw_radio_service');

    	$post = $this->getRequest()->getPost();

    	if(isset($post['update_mod'])) {
			$data['update_mod'] = $post['update_mod'];
			$data['localip'] = $post['localip'];
		} else {
			$data['update_mod'] = 'Hello world!';
			$data['localip'] = 'n/a';
		}

    	$service->setDynamicConfig( 'update_mod', $data['update_mod'] );
		$service->djupdatemessage( $data );

		return $this->response;
    }
}