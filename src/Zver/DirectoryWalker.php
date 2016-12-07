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
         * Get deepest (last) directory name
         *
         * @return mixed
         */
        protected function getDeepestDirectory()
        {
            return ArrayHelper::load($this->explodeParts($this->get()))
                              ->getLastValue();
        }
        
        /**
         * Get number of parts in current path
         *
         * @return int
         */
        protected function getPartsNumber()
        {
            return ArrayHelper::load($this->explodeParts($this->get()))
                              ->count();
        }
        
        /**
         * Go up while reaching certain directory
         *
         * @param null $directory
         */
        public function upUntil($directory)
        {
            while ($this->getDeepestDirectory() != $directory && $this->getPartsNumber() > 1)
            {
                $this->up();
            }
            
            return $this;
        }
        
        /**
         * Return array of path directories
         *
         * @param $path
         *
         * @return array
         */
        protected function explodeParts($path)
        {
            return array_filter(
                explode(
                    '/', StringHelper::load($path)
                                     ->replace(preg_quote('\\'), preg_quote('/'))
                                     ->get()
                )
            );
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
            $directories = $this->explodeParts($directory);
            
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
            
            $path = array_merge(explode(DIRECTORY_SEPARATOR, $this->origin), $this->path);
            
            $path = implode(DIRECTORY_SEPARATOR, $this->resolve($path));
            
            if ($path != DIRECTORY_SEPARATOR)
            {
                $path .= DIRECTORY_SEPARATOR;
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