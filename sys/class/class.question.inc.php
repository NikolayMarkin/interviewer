<?php

/**
 * ������ ���������� � �������
 */
class Question
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
	public function __construct($objDB=NULL)
	{
		/*
		 * ������� ����������� ������������� ������ ��� ��������
		 * ������������� ������� ���� ������
		 */
		//parent::__construct($objDB);
	}
	
	/**
	 * ����� ������� ������ ������ �� ���������� ���������� � ���������
	 *
	 * @param array: ������ ���������� ����� �������, ��� ����������
	 *					������ ��������� ������
	 * @return object
	 */
	static function createQuestion($arrQuestion)
	{
		$objQuestion = new self();
		
		$objQuestion->text = $arrQuestion['text'];
		$objQuestion->rate = $arrQuestion['rate'];
		
		$objQuestion->arrResponseOptions = array();
		for($i = 0; $i < NUM_OF_OPTIONS; $i++ )
		{
			$option = $arrQuestion['options'][$i];
			try
			{
				$objQuestion->arrResponseOptions[$i] = new ResponseOption($option);
			}
			catch ( Exception $e )
			{
				die ($e->getMessage() );
			}
		}
		
		return $objQuestion;
	}
	
	/**
	 * ����� ���������� ������ ������ ����������� � ���� ������
	 *
	 * @param int: id
	 * @param object: ������ ���� ������
	 * @return object
	 */
	static function getQuestionById($id, $objDB)
	{
		if ( empty($id) )
		{
			return NULL;
		}
		
		$objQuestion = new self(/*$objDB*/);
		
		/*
		 * �������� ������ � ������� �� ���� ������
		 */
		$strQuery = "SELECT 
						`question_text`, 
						`question_rate`  
					FROM `questions` 
					WHERE `question_id` = :id
					LIMIT 1";
					
		/*
		 * ��������� ��� ��� ������� ������ ���� ������
		 */
		try
		{
			$stmt = $objDB->prepare($strQuery);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->execute();
			$arrResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			
			if ( !is_array($arrResults) )
			{
				return NULL;
			}
			
			$objQuestion->id = $id;
			$objQuestion->text = $arrResults[0]['question_text'];
			$objQuestion->rate = $arrResults[0]['question_rate'];
		
			/*
			 * �������� �������� ������� �� ���� ������
			 */
			$strQuery = "SELECT 
							`responseoptions`.`responseOption_id`,
							`responseoptions`.`responseOption_text`,
							`responseoptions`.`responseOption_num`,
							`responseoptions`.`responseOption_isCorrect`
						FROM `responseoptions`
						WHERE `responseoptions`.`question_id` = $id";
			
			
			try
			{
				$stmt = $objDB->prepare($strQuery);
				$stmt->execute();
				$arrResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$stmt->closeCursor();
			
				/*
				 * �������� ����� ������ ��������
				 */
				$objQuestion->arrResponseOptions = array();
				$i = 0;
				foreach( $arrResults as $option )
				{
					try
					{
						$objQuestion->arrResponseOptions[$i++] = new ResponseOption($option);
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
		catch ( Exception $e )
		{
			die ( $e->getMessage() );
		}
		
		return $objQuestion;
	}
}

?>