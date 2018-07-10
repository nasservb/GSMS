# GSMS (simple and lightweith PHP MV3 framework)

Basic useful feature list:

 * Fast : this framework is very optimized for fast loading. 
 * Easy : oop not necessary in depth and all controller and model and view is simple class without extend.
 * Clear : every file is on a clear place and every view is near that controller.
 * Small but Scalable: this framework is very small but you want to add more librery in libs directory per case. 

install
-----------------------

clone the project : 
```git
git clone https://github.com/nasservb/GSMS.git
```

create a database and import gsms.sql to that .

open the gsms.php file and rename that lines in the beginig of file  :
 

	'db_system'=>'mysql',   ---->db engin
    
	'db_hostname'=>'localhost',     ----->host name
	
	'db_databasename'=>'offtel_ir', ----->db name
	
	'db_databaseuser'=>'root',  ------>db user
	
	'db_databasepass'=>'',    ----->db pass
	
	'db_charset'=>'utf8',   ------>charset of db
 	

the system is ready and you can browse the home page :

```javascript
gsms root[mvc structure :model,controller,view]
 |
 |-models(contain all the model files)
 |  |-admin.php( admin model , exp : GSMS::load('admin','models'); GSMS::$class['admin']->getAdmin(1)) 
 |   
 |-views
 |  |-contain all the view files
 |    
 |-conntrollers(conntroller files)
 |  |-admin
 |  |   |-users.php (user controller)
 |  |
 |  |-index.php(root of site controller)
 |   
 |   
 |-public
 |  |-theme
 |  | |-contain all the theme folders
 |  |
 |  |-assets 
 |  | |-contain all the asset files(picture,js,css,..)
 |  |
 |  |-errors 
 |  | |-system error files(404.php,403.php,..)
 |  
 |  
 |  
 |-database
 |  |-mysql(contain mysql engin that load by default and accessable by GSMS::$class['mysql']->)
 |  |-rb(readbeen data base orm engin that load by default and accessable by exp:  R::exec('') )
 |
 |
 |-libs(contain all the library of code)
 |  |-smssender
 |  | |-smssender.php(smssender library exp: GSMS::load('smssender','libs'); GSMS::$class['smssender']->sen(..))
 |
 |
 |
 |-plugins(contain all the plugin files)
 |  |-ticket.php( ticket plugin example, all the plugin is autoload) 
 |  
 |  
 |-core(system files)
 |  |-(router.php,template, ..)
 |
 |-archive(dir for store log files or user files like session )
 |  |-tmp(dir for store temporary file like image upload)
 
```


all the folder can change by gsms.php 

all the controller can access by :
```php
site_url/index.php/controllername/functionname/parametr1/parametr2
```

for example : 

file of edit_admin($adminid) controller is : 
```php
/controllers/admin/admins.php
```

and can access by this url :  

```php
http://mysite.com/index.php/admin/admins/edit_admin/1
```

the "controllers" foder is removed from url and "index.php" can remove by .htaccess file configs . 

for load a model like admin we could use this code : 

```php
GSMS::load('classname','models');
$admin =new admin() ; 
```

or load one library : 

```php
GSMS::load('calendar','libs');
```

for safe retrive the POST and GET value use this library : 

```php
$variable=$GSMS::class['input']->get('parametername');
$variable=$GSMS::class['input']->post('parametername');
```



several project are writed by this framework . 

for any question cantact me by nasservb@gmail.com or  nasservb@gmail.com in skype . 

