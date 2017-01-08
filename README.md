GSMS
====

GSMS is simple and lightweith PHP MV3 framework.


install

clone the project : 
git clone https://github.com/nasservb/GSMS.git
create a database and import gsms.sql to that . 
open the 
gsms.php
file and rename that lines in the beginig of file  :
	'db_system'=>'mysql',   ---->db engin
	'db_hostname'=>'localhost',     ----->host name
	'db_databasename'=>'offtel_ir', ----->db name
	'db_databaseuser'=>'root',  ------>db user
	'db_databasepass'=>'',    ----->db pass
	'db_charset'=>'utf8',   ------>charset of db
the system is ready and you can browse the home page
-------------------------
all the controller and view file is save in panel folder (the panel name can change in gsms.php file ,exm: controller )
all the model files is save in class 

mvc[model,controller,view]
 |
 |-panel(conntroller and view folder)
 |  |-administrator
 |  |   |-views
 |  |   |   |-users(the directory that contain all view file of user controller)
 |  |   |-users.php (user controller)
 |  |
 |  |-index.php(root of site controller)
 |  |-views(directory that contain all view file of root index controller)
 |  |
 |  |
 |  |-theme
 |  | |-contain all the theme folders
 |  
 |-database
 |  |-mysql(contain mysql engin that load by default and accessable by GSMS::$class['mysql']->)
 |  |-rb(readbeen data base orm engin that load by default and accessable by exp:  R::exec('') )
 |
 |
 |-lib(contain all the library of code)
 |  |-template
 |  | |-template.php(template library exp: GSMS::load('template','lib'); GSMS::$class['template']->header($parameter))
 |
 |
 |
 |-class(contain all the model files)
 |  |-admin.php( admin model , exp : GSMS::load('admin','class'); GSMS::$class['admin']->getAdmin(1)) 
 |  
 |  
 |-errors(error files)
 |  |-404.php
 |
 |-log(dir for store log file like session )
 |-tmp(dir for store temporary file like image upload)
 
 
all the folder can change by gsms.php 

all the controller can access by 
site_url/index.php/controllername/functionname/parametr1/parametr2
for example
file of edit_admin($adminid) controller is : 
/panel/admin/admins.php
and can access by this url :  
http://mysite.com/index.php/admin/admins/edit_admin/1
the "panel" foder is removed from url and "index.php" can remove by .htaccess file configs . 

for load a model like admin we could use this code : 

GSMS::load('classname','lib');
$admin =new admin() ; 


or load one library : 

GSMS::load('calendar','lib');

for safe retrive the POST and GET value use this library : 

$variable=$GSMS::class['input']->get('parametername');
$variable=$GSMS::class['input']->post('parametername');
