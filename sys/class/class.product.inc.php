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
	 * �������� �������
	 * 
	 * @var string
	 */
	public $name;
	
	/**
	 * ������������� ������ ������������ �������
	 * � ������� ����������� �������
	 * 
	 * @var int
	 */
	public $productGroupId;
	
	/**
	 * ������������� ������������ �����������
	 * 
	 * @var int
	 */
	public $enterpriseId;
	
	
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
			$this->productGroupId = $arrProduct['productgroup_id'];
			$this->enterpriseId = $arrProduct['enterprise_id'];
		}
		else
		{
			throw new Exception("�� ���� ������������� ������ �� ������� ���������.");
		}
	}
}

?>