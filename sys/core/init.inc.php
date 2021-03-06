<?php

/*
 * Отвечает за загрузку и определение всех необходимых констант,
 * создание объекта базы данных и настройку функции автозагрузки для классов.
 */

/*
 * Запуск сеанса
 */ 
session_start();

/*
 * Сгенерировать маркер защиты от CSRF, если это не было 
 * сделано ранее
 */
if ( !isset($_SESSION['token']))
{
	$_SESSION['token'] = sha1(uniqid(mt_rand(), TRUE));
}
 
/*
 * Включить необходимую конфигурационную информацию
 */ 
include_once '../sys/config/db-cred.inc.php';

/*
 * Определить константы для конфигурационной информации
 */
foreach ( $C as $name => $val )
{
	define($name, $val);
}

/*
 * Создать PDO-объект
 */
$strDSN = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
$objDB = new PDO($strDSN, DB_USER, DB_PASS);
$objDB->exec('SET NAMES utf8');

/*
 * Определить для классов функцию автозагрузки
 *
 * Функция автозагрузки вызывается в тех случаях, когда в сценарии 
 * делается попытка создания экземпляра класса, но сам класс к этому 
 * времени еще не был загружен.
 */
function __autoload($strClassName)//myAutoload($strClassName)
{
	$strFileName = "../sys/class/class." . strtolower($strClassName) . ".inc.php";
	if ( file_exists($strFileName) )
	{
		include_once $strFileName;
	}
}
?>