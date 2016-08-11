<?php

namespace Zver
{
    
    class DirectoryWalker
    {
        
        protected $origin = null;
        protected $path = [];
        
        protected function getDirectorySeparator()
        {
            return DIRECTORY_SEPARATOR;
        }
        
        public function up($times = 1)
        {
            for ($i = 0; $i < $times; $i++)
            {
                $this->path[] = '..';
            }
            
            return $this;
        }
        
        public function enter($directory)
        {
            $directories = explode('\/', $directory);
            
            foreach ($directories as $directory)
            {
                if (!empty($directory))
                {
                    $this->path[] = $directory;
                }
            }
            
            return $this;
        }
        
        protected function __construct()
        {
            
        }
        
        public static function fromCurrent()
        {
            $walker = new static();
            
            $lastCalledFile = ArrayHelper::load(debug_backtrace())
                                         ->getFirstValue()['file'];
            
            $walker->origin = StringHelper::load(dirname($lastCalledFile))
                                          ->removeEnding('/')
                                          ->removeEnding('\\');
            
            return $walker;
            
        }
        
        public function get()
        {
            $directorySeparator = $this->getDirectorySeparator();
            
            $path = $this->origin;
            
            if (!empty($this->path))
            {
                $path .= $directorySeparator . implode($directorySeparator, $this->path);
            }
            
            return realpath($path) . $directorySeparator;
        }
    }
}