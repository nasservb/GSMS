<?php  //allahoma sale ala mohammad va ale mohammad 


class Model
{
	public $exportable=[]; 
	
	public $id=0;
	
	public $tableName='';
	
	public $createTable='';
	
	public $updateTable='';
		
	public function __construct()
    {
		try
		{
			$row='';
			$max=0;
			GSMS::$class['DB']->run($q,
							'admin.php',	//file of code
							$row,			//variable to return first row			
							$max,			//variable to return row count	
							'describe `'. $this->tableName . '`'	//sql code subject	
							);
		}
		catch ($e)
		{
			$row='';
			$max=0;
			GSMS::$class['DB']->run($q,
							'admin.php',	//file of code
							$row,			//variable to return first row			
							$max,			//variable to return row count	
							$this->createTable 	//sql code subject	
							);
		}		
	}
	
	public function save()
	{
		$temp = R::dispense($this->tableName);
		if(intval($this->id) > 0)
		{
			$temp = R::load($this->tableName,$this->id);
		}
		
		foreach ($this->property as $key => $value) 		
		{
			$temp->$key = $value;
		}
		
		$this->id = R::store( $temp);
	}
}
?>