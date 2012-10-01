<?php

/**
 * ��������� ����������� ���������������� �����
 */
class Admin extends DB_Connect
{
	/**
	 * ������� ������ ����
	 * 
	 * ��� �������� ���������� ����� ������ ����������� ���������
	 * ������ ���� ������ � �������� ���������. ���� �������� ����� 
	 * ��������� ������� �� null, ��� ����������� � �������� 
	 * �������� $_objDB. ���� �� ��� �������� ����� null, �� ������
	 * ����� ��������� � ����������� ����� PDO-������.
	 *
	 * @param int $type: ���������� ���� �� 4-� ����� �������������� ������ 
	 * @param object $dbo: ������ ���� ������
	 * @return void
	 */
	public function __construct($dbo=NULL)
	{
		/**
		 * ������� ����������� ������������� ������ ��� ��������
		 * ������������� ������� ���� ������
		 */
		parent::__construct($dbo);
	}
	
	/**
	 * ��������� ���������������� ������� ������ ������������
	 *
	 * @return mixed: TRUE � ������ ��������� ����������, ����� 
	 * ��������� �� ������
	 */
	public function processLoginForm()
	{
		/*
		 * ��������� ����������, ���� ��� ��������� ����������������
		 * ������� ACTION
		 */
		if ($_POST['action'] != 'user_login' )
		{
			return "� processLoginFrom �������� ���������������� ��������
					�������� ACTION";
		}
		
		/*
		 * ����������� ���������������� ���� � ����� ������������
		 */
		$strUName = htmlentities($_POST['uname'], ENT_QUOTES);
		$strPword = htmlentities($_POST['pword'], ENT_QUOTES); 
		
		/*
		 * ������ �� ���� ������ ����������� ����������, ���� ��� ����������
		 */
		$strQuery = "SELECT
						`user_id`, `user_name`, `user_pass`
					FROM `users`
					WHERE 
						`user_name` = :uname
					LIMIT 1";
		try
		{
			$stmt = $this->_objDB->prepare($strQuery);
			$stmt->bindParam(':uname', $strUName, PDO::PARAM_STR);
			$stmt->execute();
			$arrUser = array_shift($stmt->fetchAll());
			$stmt->closeCursor();
		}
		catch ( Exception $e )
		{
			die($e->getMessage() );
		}
		
		/*
		 * ��������� ����������, ���� ��� ������������ �� 
		 * ����������� �� � ����� ������� � ��
		 */
		if ( !isset($arrUser) )
		{
			return "������������ � ����� ������ �� ���������� � ��.";
		}
		
		/*
		 * ���������, ��������� �� ��������� ������ � ����������� � �� 
		 */
		if ( $arrUser['user_pass'] == $strPword)
		{
			/*
			 * ��������� ���������������� ���������� � ������ � ���� �������
			 */
			$_SESSION['user'] = array(
					'id' => $arrUser['user_id'],
					'name' => $arrUser['user_name']
				);
			return TRUE;
		}
		else
		{
			return "�������� ��� ������������ ��� ������";
		}	
	}
	
	/**
	 * ��������� ����� ������������
	 *
	 * @return mixed: TRUE � ������ ��������� ����������, ����� 
	 * ��������� �� ������
	 */
	public function processLogout()
	{
		/*
		 * ��������� ����������, ���� ��� ��������� ����������������
		 * ������� ACTION
		 */
		if ($_POST['action'] != 'user_logout' )
		{
			return "� processLogout �������� ���������������� ��������
					�������� ACTION";
		}
		
		/*
		 * ��������� ����� ������
		 */
		session_destroy();
		return TRUE;
	}
}
 
?>