<?php

/**
 * ������ ���������� � ����������� 
 */
class Question extends DB_Connect
{
	/**
	 * ������������� �������
	 * 
	 * @var int
	 */
	public $id;
	
	/**
	 * ����� �������
	 *
	 * @var string
	 */
	public $text;
	
	/**
	 * ��� ����������
	 * 
	 * @var real
	 */
	public $rate;
	
	/**
	 * ���������� ��������� ������ �� ������
	 *
	 * @var int
	 */
	public $numAns;
	
	/**
	 * ������ ��������� ������
	 *
	 * @var array
	 */
	public $arrResponseOptions;
	
	/**
	 * ��������� ������ ������ � ������� � ��������� ���.
	 * ��� �� �������� ���������� � ��������� ������.
	 *
	 * @param array $arrQuestion
	 * @param object $objDB
	 * @return void
	 */
	public function __construct($arrQuestion, $objDB=NULL)
	{
		/*
		 * ������� ����������� ������������� ������ ��� ��������
		 * ������������� ������� ���� ������
		 */
		parent::__construct($objDB);
		
		if ( is_array($arrQuestion) )
		{
			$this->id = $arrQuestion['question_id'];
			$this->text = $arrQuestion['question_text'];
			$this->rate = $arrQuestion['question_rate'];
			$this->numAns = $arrQuestion['question_numAns'];
			
			/*
			 * �������� �� ���� ������ ��� �������� ������ �� ������ ������
			 */
			$strQuery = "SELECT 
							`responseoptions`.`responseOption_id`,
							`responseoptions`.`responseOption_text`,
							`responseoptions`.`responseOption_num`,
							`responseoptions`.`responseOption_isCorrect`
						FROM `responseoptions`
						WHERE `responseoptions`.`question_id` = $this->id";
			try
			{
				$stmt = $this->_objDB->prepare($strQuery);
			
				$stmt->execute();
				$arrResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$stmt->closeCursor();
			
				/*
				 * �������� ����� ������ ��������
				*/
				$this->arrResponseOptions = array();
				$i = 0;
				foreach( $arrResults as $option )
				{
					try
					{
						$this->arrResponseOptions[$i++] = new ResponseOption($option);
					}
					catch ( Exception $e )
					{
						die ($e->getMessage() );
					}
				}
			}
			catch ( Exception $e )
			{
				die ( $e->getMessage() );
			}
		}
		else
		{
			throw new Exception("�� ���� ������������� ������ � �������.");
		}
	}
}

?>