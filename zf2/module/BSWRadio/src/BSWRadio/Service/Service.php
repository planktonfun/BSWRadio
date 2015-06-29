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
    protected $dynamic_file = 'public/assets/js/config.js';

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

    public function getDynamicConfig() {

    	$config = $this->getConfig();        

        if(!file_exists( $this->dynamic_file )) {
            $data['message_of_the_day'] = $config['message_of_the_day'];
            $data['current_song']       = $config['current_song'];

            file_put_contents( $this->dynamic_file, json_encode( $data ) );
        }

        return json_decode( file_get_contents( $this->dynamic_file ), true );
    }

    public function setDynamicConfig( $key, $value ) {

        $data = $this->getDynamicConfig();

        $data[$key] = $value;

        file_put_contents( $this->dynamic_file, json_encode( $data ) );

    }

     public function djupdatemessage( $data ) {
        $config = $this->getConfig();

        $pusher = new Pusher($config['app_key'], $config['app_secret'], $config['app_id']);

        if ( strpos( $data['localip'], $config['dj_ip'] ) !== false ) {    
            $pusher->trigger($config['app_channel'], 'my_event', $data);
        }
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
            $this->setDynamicConfig( 'current_song', $data['message'] );
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
            $f->crawl( 'mix2/Music/Copied/Lamb of God', 'mp3' ),              
            $f->crawl( 'mix2/Music/Love Songs', 'mp3' ),              
            $f->crawl( 'mix2/Music/Love Songs/New folder', 'mp3' ),              
	        $f->crawl( 'mix2/Music/Party Musics/Party music - collection', 'mp3' ),              
            $f->crawl( 'mix2/Music/(1995) Wolfgang', 'mp3' ),              
            $f->crawl( 'mix2/Music/Greyhoundz/Execution Style', 'mp3' ),       
            $f->crawl( 'mix2/Music/He Is We - Old Demos -  (2010)', 'mp3' ),            
            $f->crawl( 'mix2/Music/Franco', 'mp3' ),            
            $f->crawl( 'mix2/Music/newly added music/emo', 'mp3' ), 
            $f->crawl( 'mix2/Music/newly added music/OPM', 'mp3' ),      
            $f->crawl( 'mix2/Music/P.N.E/Middle-Aged Juvenile Novelty Pop Rockers', 'mp3' ), 
            $f->crawl( 'mix2/Music/Punk Goes Pop/Punk Goes Pop 5', 'mp3' ),            
            $f->crawl( 'mix2/Music/Punk Goes Pop/Punk Goes Pop 6', 'mp3' ),            
            $f->crawl( 'mix2/Music/Punk Goes Pop/Punk Goes Pop 1+2 CDRip-Music_Monster/Punk Goes Pop 1', 'mp3' ),            
            $f->crawl( 'mix2/Music/Punk Goes Pop/Punk Goes Pop 1+2 CDRip-Music_Monster/Punk Goes Pop 2', 'mp3' ),            
            $f->crawl( 'mix2/Music/Punk Goes Pop/VA - Punk Goes Pop vol.3 (2010)(320kbps)', 'mp3' ),            
            $f->crawl( 'mix2/Music/Punk Goes Pop/VA-Punk_Goes_Pop_4-2011-FNT/VA-Punk_Goes_Pop_4-2011-FNT', 'mp3' ),            
            $f->crawl( 'mix2', 'mp3' ), 
            $f->crawl( 'mix2/Jap/HS music', 'mp3' ),
            $f->crawl( 'mix2/2014', 'mp3' ),
            $f->crawl( 'mix2/BSW-RADIO', 'mp3' ),
            $f->crawl( 'mix2/Billboard 2015 Top 100 Singles (June)', 'mp3' ),
            $f->crawl( 'mix2/Billy', 'mp3' ),
            $f->crawl( 'mix2/Downloads', 'mp3' ),
            $f->crawl( 'mix2/Ed Sheeran', 'mp3' ),
            $f->crawl( 'mix2/Final Riot', 'mp3' ),
            $f->crawl( 'mix2/Music', 'mp3' ),
            $f->crawl( 'mix2/Xmas', 'mp3' )
	    );

	    return $playlist;
    }
}
