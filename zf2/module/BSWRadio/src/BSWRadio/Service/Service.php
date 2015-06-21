<?php

namespace BSWRadio\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BSWRadio\Service\CMP3File;
use BSWRadio\Service\FolderCrawler;
use BSWRadio\Service\Pusher;

class Service implements ServiceLocatorAwareInterface
{
	protected $sl;

	public function setServiceLocator(ServiceLocatorInterface $sl) {
        $this->sl = $sl;
    }

    public function getServiceLocator() {
        return $this->sl;
    }

    public function getConfig() {
    	$config = $this->getServiceLocator()->get('config');
    	$bsw_radio_config = $config['bsw_radio'];

    	return $bsw_radio_config;
    }

    public function djupdate() {
    	$config = $this->getConfig();

    	$pusher = new Pusher($config['app_key'], $config['app_secret'], $config['app_id']);

		$data['message'] = 'update_dj_123';
		$data['updatedj'] = $config['dj_ip'];

		$pusher->trigger($config['app_channel'], 'my_event', $data);
    }

    public function send( $data ) {

    	$config = $this->getConfig();

    	$pusher = new Pusher($config['app_key'], $config['app_secret'], $config['app_id']);

		if ( strpos( $data['localip'], $config['dj_ip'] ) !== false ) {    
			$pusher->trigger($config['app_channel'], 'my_event', $data);
		}

    }

    public function refresh() {
    	$config = $this->getConfig();
    	$pusher = new Pusher($config['app_key'], $config['app_secret'], $config['app_id']);
		
		$data['message'] = 'refresh_this_123';

		$pusher->trigger($config['app_channel'], 'my_event', $data);
    }
    
    public function getSongList() {
  
    	$f = new FolderCrawler;

	    $playlist = array_merge(        
	        $f->crawl( 'mix', 'mp3' )
	    );

	    return $playlist;
    }
}
