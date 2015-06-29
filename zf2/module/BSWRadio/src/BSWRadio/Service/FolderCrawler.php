<?php

namespace BSWRadio\Service;

class FolderCrawler 
{	
	private $_cache = true;
    private $_cache_file = 'cache/data.cache';
    private $_cache_interval = 'YMD';

    public function __construct( ) {
        
        chdir("public");

        if( $this->_cache == true && !file_exists( $this->_cache_file ) ) {
            file_put_contents( $this->_cache_file, json_encode(array('created' => 'now' )));
        }

    }

    private function getCache( $key ) {
        
        $file = file_get_contents( $this->_cache_file );
        $list = json_decode( $file, true );

        return ( isset( $list[$key] ) ) ? $list[$key] : false;
    }

    private function updateCache( $key, $array ) {
        
        $file = file_get_contents( $this->_cache_file );
        $list = json_decode( $file, true );

        if( !$this->getCache( $key ) ) {
            $list[ $key ] = $array;
        }

        file_put_contents( $this->_cache_file, json_encode( $list ));
    }

    public function file_count( $folder_name ) {
        $files = scandir($folder_name);

        if( !scandir($folder_name) ) {
            die( 'Folder specified is unknown: ' . $folder_name );
        }

        return count( $files );
    }

	public function crawl( $_folder_name, $_type ) {
		
        $cache_index = date( $this->_cache_interval ) . strip_tags( addslashes( $_folder_name ) )  . $this->file_count( $_folder_name );

        if( $this->_cache == true ) {
            
            $cache = $this->getCache( $cache_index );

            if( $cache != false ) {                    
                return $cache;
            }
        }

		$files = scandir($_folder_name);

		if( !scandir($_folder_name) ) {
			die( 'Folder specified is unknown: ' . $_folder_name );
		}

		$files_added = array();

		foreach ($files as $key => $value ) {

			$path = $_folder_name . '/' . $value;
            $png = $_folder_name . '/' . basename( $value, ".mp3" ) . ".png";

			$info = new \SplFileInfo( $path );

			if( $info->getExtension() == $_type ) {
				
				$mp3 = new CMP3File;
				$mp3->getid3( $path );

				if( trim( strip_tags( $mp3->title ) ) != "" ) {
                    $files_added[] = array(
                        "mp3"    => $path,
                        "title"  => strip_tags( addslashes( $mp3->title ) ),
                        "artist" => strip_tags( addslashes( $mp3->artist ) ),
                        "png"    => (file_exists( $png )) ? $png : ""
                    );
                } else {
                    $files_added[] = array(
                        "mp3"    => $path,
                        "title"  => strip_tags( addslashes( $value ) ),
                        "artist" => 'Mr. Pogi',
                        "png"    => (file_exists( $png )) ? $png : ""
                    );
                }
			}
		}

        if( $this->_cache == true ) {
            $this->updateCache( $cache_index, $files_added );
        }

		return $files_added;
	}
}