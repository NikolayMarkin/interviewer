<?php

/**
 * ������ ���������� � ����������� 
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
	 * @var array: "�" ��� "�"
	 */
	public $sex;
	 
	/**
	 * ��������� ������ ������ � ����������� � ��������� ���
	 *
	 * @param array $arrTaster
	 * @return void
	 */
	public function __construct($arrTaster)
	{
		if ( is_array($arrTaster) )
		{
			$this->id = $arrTaster['taster_id'];
			$this->surname = $arrTaster['taster_surname'];
			$this->name = $arrTaster['taster_name'];
			$this->sex = $arrTaster['taster_sex'];
		}
		else
		{
			throw new Exception("�� ���� ������������� ������ � �����������.");
		}
	}
}

?>