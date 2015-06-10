<?php


class FolderCrawler 
{
	public function crawl( $_folder_name, $_type ) {
		
		$files = scandir($_folder_name);

		if( !scandir($_folder_name) ) {
			die( 'Folder specified is unknown: ' . $_folder_name );
		}

		$files_added = array();

		foreach ($files as $key => $value ) {

			$path = $_folder_name . '/' . $value;

			$info = new SplFileInfo( $path );

			if( $info->getExtension() == $_type ) {
				
				$mp3 = new CMP3File;
				$mp3->getid3( $path );

				if( trim( strip_tags( $mp3->title ) ) != "" )
					$files_added[] = array(
						"mp3"    => $path,
						"title"  => strip_tags( addslashes( $mp3->title ) ),
						"artist" => strip_tags( addslashes( $mp3->artist ) )
					);
			}
		}

		return $files_added;
	}
}