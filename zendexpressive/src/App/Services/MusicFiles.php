<?php

namespace App\Services;

class MusicFiles
{
    protected $config = false;

    private function checkConfigs()
    {
        if (!$this->config) {
            throw new \Exception("Please Set Music Config Files");
        }
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function path()
    {
        return $this->config['music']['path'];
    }

    public function getIndexFilepath()
    {
        return getcwd() . $this->config['music']['index_file'];
    }

    public function getCurrentlyPlaying()
    {
        return file_get_contents(getcwd() . $this->config['music']['temp_file']);
    }

    public function setCurrentlyPlaying($index)
    {
        return file_put_contents(getcwd() . $this->config['music']['temp_file'], $index);
    }

    public function publicPath()
    {
        return getcwd() . $this->config['music']['public_path'];
    }

    public function getPusherKey()
    {
        return $this->config['pusher']['key'];
    }

    public function getPusherChannel()
    {
        return $this->config['pusher']['channel'];
    }

    public function getPusherEvent()
    {
        return $this->config['pusher']['event'];
    }

    public function getExtension($file)
    {
        $extensions = $this->config['music']['extensions'];

        foreach ($extensions as $extension) {
            if (preg_match('/\.'.$extension.'$/', $file)) {
                return $extension;
            }
        }

        return false;
    }

    public function get()
    {
        $path       = $this->publicPath();
        $files      = scandir($path);
        $extensions = $this->config['music']['extensions'];
        $validFiles = [];

        foreach ($files as $file) {
            foreach ($extensions as $extension) {
                if (preg_match('/\.'.$extension.'$/', $file)) {
                    $validFiles[$this->getCanonicalName($file)] = $file;
                }
            }
        }

        return $validFiles;
    }

    public function getCanonicalName($name)
    {
        return strtolower(preg_replace('/[^\w]*/', '', $name));
    }
}