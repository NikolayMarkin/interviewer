<?php

/**
 * ������ ���������� � �������� ������
 */
class ResponseOption
{
	/**
	 * ������������� �������� ������
	 * 
	 * @var int
	 */
	public $id;
	
	/**
	 * ����� ������
	 * 
	 * @var string
	 */
	public $text;
	
	/**
	 * ����� �������� ������
	 *
	 * @var int
	 */
	public $num;
	
	/**
	 * ��������� ���������� ������� ������ 
	 *
	 * @var bool
	 */
	public $isCorrect;
	 
	/**
	 * ��������� ������ ������ � �������� ������ � ��������� ���
	 *
	 * @param array $arrResponseOption
	 * @return void
	 */
	public function __construct($arrResponseOption)
	{
		if ( is_array($arrResponseOption) )
		{
			$this->id = $arrResponseOption['responseOption_id'];
			$this->text = $arrResponseOption['responseOption_text'];
			$this->num = $arrResponseOption['responseOption_num'];
			$this->isCorrect = (bool)$arrResponseOption['responseOption_isCorrect'];
		}
		else
		{
			throw new Exception("�� ���� ������������� ������ � �������� ������.");
		}
	}
}

?>