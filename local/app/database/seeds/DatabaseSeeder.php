<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
    public function run() {
        
        
        // First, delete all tables
        $tables = DB::select('SHOW TABLES');
        $db_name = 'Tables_in_'.DB::connection()->getDatabaseName();
        
        foreach ($tables as $table){
            if($table->$db_name != 'role'){
                DB::statement('DROP TABLE IF EXISTS `'.$table->$db_name.'`');
            }

        }
        DB::statement('DROP TABLE IF EXISTS `role`');

        
        // Then, import the new database 
        DB::unprepared(File::get('db.sql'));
    }

}
