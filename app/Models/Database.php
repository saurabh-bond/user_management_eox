<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

/**
 * This class is for database query operation
 * @author Saurabh Kumar <saurabhkumar3012official@gmail.com>
 * @since 23rd May 2021
 */
class Database
{
        
        protected $table = 'users';
        private static $_instance = null;
        
        private function __construct()
        {
        }
        
        
        /**
         * Singleton design pattern
         * @return Database|null
         */
        public static function getInstance()
        {
                if (!is_object(self::$_instance))
                        self::$_instance = new Database();
                return self::$_instance;
        }
        
        /**
         * This method is used for fetching query from user table
         * @param $whereCondition , $selectColumns
         * @author Saurabh Kumar <saurabhkumar3012official@gmail.com>
         * @since 23rd May 2021
         */
        public function selectQuery($where, $selectCols = ['*'])
        {
                $results = DB::table($this->table)
                        ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                        ->select($selectCols)
                        ->get();
                
                return ($results) ? json_decode($results, true) : [];
        }
        
        /**
         * Update query
         * @param $whereCondition , $selectColumns
         * @author Saurabh Kumar <saurabhkumar3012official@gmail.com>
         * @since 23rd May 2021
         */
        public function update($where, $dataToUpdate)
        {
                try {
                        $updated = DB::table($this->table)
                                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                                ->update($dataToUpdate);
                        
                        return ($updated) ? true : false;
                } catch (Exception $exception) {
                        return false;
                }
        }
        
}
