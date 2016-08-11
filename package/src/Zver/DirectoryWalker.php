<?php

namespace Zver
{
    
    /**
     * Class DirectoryWalker helps to walk from directories, include files
     *
     * @package Zver
     */
    class DirectoryWalker
    {
        
        protected $origin = null;
        protected $path = [];
        
        /**
         * Get directory separator
         *
         * @return string
         */
        protected function getDirectorySeparator()
        {
            return DIRECTORY_SEPARATOR;
        }
        
        /**
         * Move into upper folder (parent) of current walked directory
         *
         * @param int $times
         *
         * @return $this
         */
        public function up($times = 1)
        {
            for ($i = 0; $i < $times; $i++)
            {
                $this->path[] = '..';
            }
            
            return $this;
        }
        
        /**
         * Walk into directory or directories
         *
         * @param $directory
         *
         * @return $this
         */
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
        
        /**
         * DirectoryWalker constructor.
         */
        protected function __construct()
        {
            
        }
        
        /**
         * Start walking from function call directory
         *
         * @return static
         */
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
        
        /**
         * Get current walked path
         *
         * @return string
         */
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
        
        /**
         * Include a file in current walking directory.
         *
         * @param   string $file  File to require
         * @param bool     $throw If this argument is true and file not exists
         *                        \Zver\Exceptions\DirectoryWalker\FileNotFoundException will raised
         *
         * @return $this
         * @throws \Zver\Exceptions\DirectoryWalker\FileNotFoundException
         */
        public function includeFile($file, $throw = false)
        {
            $path = $this->get() . $file;
            
            if (file_exists($path))
            {
                include_once "$path";
            }
            else
            {
                if ($throw)
                {
                    throw new Exceptions\DirectoryWalker\FileNotFoundException(
                        'File not found for include "' . $path . '"'
                    );
                }
            }
            
            return $this;
        }
        
        /**
         * Require a file in current walking directory.
         *
         * @param   string $file  File to require
         * @param bool     $throw If this argument is true and file not exists
         *                        \Zver\Exceptions\DirectoryWalker\FileNotFoundException will raised
         *
         * @return $this
         * @throws \Zver\Exceptions\DirectoryWalker\FileNotFoundException
         */
        public function requireFile($file, $throw = false)
        {
            $path = $this->get() . $file;
            
            if (file_exists($path))
            {
                require_once "$path";
            }
            else
            {
                if ($throw)
                {
                    throw new Exceptions\DirectoryWalker\FileNotFoundException(
                        'File not found for require "' . $path . '"'
                    );
                }
            }
            
            return $this;
        }
    }
}