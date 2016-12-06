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
        protected static $parentDir = '..';
        protected static $currentDir = '.';
        
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
                $this->path[] = static::$parentDir;
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
            $directories = explode(
                '/', StringHelper::load($directory)
                                 ->replace(preg_quote('\\'), preg_quote('/'))
                                 ->get()
            );
            
            foreach ($directories as $dir)
            {
                if (!empty($dir))
                {
                    $this->path[] = $dir;
                }
            }
            
            return $this;
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
                                          ->removeEnding('\\')
                                          ->get();
            
            return $walker;
        }
        
        /**
         * Return path resolved from current and parent dirs flags
         *
         * @param array $path
         *
         * @return array
         */
        protected function resolve(array $path)
        {
            /**
             * Remove current dir flag
             */
            $resolved = array_filter(
                $path, function ($value)
            {
                return $value != static::$currentDir;
            }
            );
            
            /**
             * Resolving parent dirs
             */
            while (($position = array_search(static::$parentDir, $resolved)) !== false)
            {
                
                /**
                 * Delete parent dir
                 */
                if (isset($resolved[$position - 1]))
                {
                    unset($resolved[$position - 1]);
                }
                
                /**
                 * Unset parent dir flag
                 */
                unset($resolved[$position]);
                
                /**
                 * Reset indexes
                 */
                $resolved = array_values($resolved);
            }
            
            return $resolved;
        }
        
        /**
         * Get current walked path
         *
         * @return string
         */
        public function get()
        {
            $directorySeparator = $this->getDirectorySeparator();
            
            $path = array_merge(explode($directorySeparator, $this->origin), $this->path);
            
            $path = implode($directorySeparator, $this->resolve($path));
            
            if ($path != $directorySeparator)
            {
                $path .= $directorySeparator;
            }
            
            return $path;
        }
        
        public function createAndGet($mode = 0777)
        {
            $path = $this->get();
            
            if (!file_exists($path))
            {
                mkdir($path, $mode, true);
            }
            
            return $path;
        }
        
    }
}