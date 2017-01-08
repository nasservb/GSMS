<?php		
global $CI;
		R::setup( 'mysql:host='.$this->config['db_hostname'].
					';dbname='.$this->config['db_databasename'],
					$this->config['db_databaseuser'], 
					$this->config['db_databasepass'] ); //for both mysql or mariaDB
		R::exec('SET NAMES utf8');
		