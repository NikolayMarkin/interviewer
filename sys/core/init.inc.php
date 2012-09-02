<?php

/*
 * �������� �� �������� � ����������� ���� ����������� ��������,
 * �������� ������� ���� ������ � ��������� ������� ������������ ��� �������.
 */

/*
 * �������� ����������� ���������������� ����������
 */ 
include_once '../sys/config/db-cred.inc.php';

/*
 * ���������� ��������� ��� ���������������� ����������
 */
foreach ( $C as $name => $val )
{
	define($name, $val);
}

/*
 * ������� PDO-������
 */
$strDSN = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
$objDB = new PDO($strDSN, DB_USER, DB_PASS);

/*
 * ���������� ��� ������� ������� ������������
 *
 * ������� ������������ ���������� � ��� �������, ����� � �������� 
 * �������� ������� �������� ���������� ������, �� ��� ����� � ����� 
 * ������� ��� �� ��� ��������.
 */
function __autoload($strClassName)
{
	$strFileName = "..sys/class/class." . $strClassName . ".inc.php";
	if ( file_exists($strFileName) )
	{
		include_once $strFileName;
	}
}
?>