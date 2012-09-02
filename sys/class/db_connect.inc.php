<?php

/**
 * ������������ ����������� � ���� ������ (������ � ��, �������� � �.�.)
 */
class DB_Connect
{
	/**
	 * ���������� ��� �������� ������� ���� ������
	 *
	 * @var object: ������ ���� ������
	 */
	protected $objDB;
	
	/**
	 * ��������� ������� ������� ��, � � ������� ��� ����������
	 * ������� �����
	 * 
	 * @param object $dbo: ������ ���� ������
	 */
	protected function __construct($dbo = NULL)
	{
		if ( is_object($dbo) )
		{
			$this->$objDB = $dbo;
		}
		else
		{
			// ��������� ���������� � �����
			// /sys/config/db-cred.inc.php
			$strDSN = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
			try
			{
				$this->objDB = new PDO($strDSN, DB_USER, DB_PASS);
			}
			catch ( Exception $e )
			{
				// ���� �� ������� ���������� ���������� � ��,
				// ������� ��������� �� ������
				die ( $e->getMessage() );
			}
		}
	}
}
?>