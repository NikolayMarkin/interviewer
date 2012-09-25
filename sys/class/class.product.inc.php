<?php

/**
 * ������ ���������� �� ������� ���������
 */
class Product
{
	/**
	 * ������������� �������
	 * 
	 * @var int
	 */
	public $id;
	
	/**
	 * ����� ������
	 * 
	 * @var string
	 */
	public $name;
	
	/**
	 * ��������� ������ ������ �� ������� ���������
	 *
	 * @param array $arrProduct
	 * @return void
	 */
	public function __construct($arrProduct)
	{
		if ( is_array($arrProduct) )
		{
			$this->id = $arrProduct['product_id'];
			$this->name = $arrProduct['product_name'];
		}
		else
		{
			throw new Exception("�� ���� ������������� ������ �� ������� ���������.");
		}
	}
}

?>