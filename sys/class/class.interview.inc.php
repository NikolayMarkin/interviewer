<?php

/**
 * ������������ ���������� ������
 */
class Interview extends DB_Connect
{
	/*
	 * ���������� ��� �������� ���� ��������������� �����
	 */
	private $_type;
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
	public function __construct($type, $dbo=NULL)
	{
		/**
		 * ������� ����������� ������������� ������ ��� ��������
		 * ������������� ������� ���� ������
		 */
		parent::__construct($dbo);
		
		/*
		 * ���������� ��� ��������������� �����
		 */
		if ( !empty($type) && $type >= M_TRIANG && $type <=M_CONSUM )
		{
			$this->_type = $type;
		}
		else
		{
			die ("������� ����� ��� ��������������� �����!");
		}
	}
	
	/**
	 * ���������� HTML-�������� ��� ����������� ����� ��������.
	 *
	 * @return string: HTML-��������
	 */
	public function nextCluster()
	{
		/*
		 * �������� ��� � ������� ����������� � ������� ����
		 */
		//$strTasterName = $this->_curTasterName();
		
//������ �����������, ���������������� � ������������ �������
		/*
		 * ���������� ���� �� ��� ����� �������� � �������������� �����
		 */
		$arrProduct = $this->_nextProduct(4);//$idProd);
		if ( empty($arrProduct) )
		{
			//���������� �������� � �������������� � ������� ��������� �����
			echo "lksd";
			return;
		}
		
		print_r($arrProduct);
		
		/*
		 * ������ �������� � ����������� �� ���� ��������������� �����
		 */
		switch ($this->_type)
		{
			case M_TRIANG:
				break;
			case M_PROFIL:
				break;
			case M_COMPLX:
				break;
			case M_CONSUM:
				break;
		}
	}
	
	/**
	 * ���������� ������������� ������ ���������� ��� ������ � �������� � 
	 * ��������������� ������ ��� ����������
	 *
	 * @param int $id: ������������� ���������� ��������
	 * @return mixed: NULL - � ������ ���������� ���������� ������� ��������� 
	 * ��� ������ ������ � array ������������� ������ ���� ������� ����������
	 */
	private function _nextProduct($id)
	{
		$strQuery = "SELECT
						`product_id`, 
						`product_name`
					FROM `products` 
					WHERE `product_id` > :id
					LIMIT 1";
		
		
		try
		{
			$stmt = $this->_objDB->prepare($strQuery);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			
			return empty($result) ? NULL : $result[0];
		}
		catch (Exception $e)
		{
			die ($e->getMessage() );
		}
	}
	
	/**
	 * ���������� ������ � ������ � �������� �������� �����������
	 *
	 * @return string
	 */
	private function _curTasterName()
	{
		/*
		 * �������� ��� � ������� �������� �������������� �� ������
		 */
		$strSurname = $_SESION['surname'];
		$strName = $_SESSION['name'];
		
		return $strSurname . " " . $strName;
	}
	
	
	/**
	 * ���������� �����, ����������� ������������� ������ �
	 * ����������� ��� ��������� ������ � �������.
	 *
	 * @return string: HTML-�������� ����� ��� �������������� 
	 * ���������� � �����������
	 */
	public function displayTasterForm()
	{
		/**
		 * ���������, ��� �� ������� �������������
		 */
		if ( isset($_POST['taster_id']) )
		{
			// ������������� ������ ������������� ��� ���
			// ����������� ������������ ������
			$id = (int) $_POST['taster_id'];
		}
		else
		{
			$id = NULL;
		}
		
		/*
		 * ������������� �������� ��� ������ ���� �����������
		 * �� ��������� ���������� ������� ���
		 */
		$strSexList = "<select name=\"taster_sex\">
							<option selected value=\"�\">M</option>
							<option value=\"�\">�</option>
						</select>";
		
		/**
		 * ���� ��� ������� ID, ��������� �������������� ����������
		 */
		if ( !empty($id) )
		{
			$objTaster = $this->_loadTasterById($id);
			
			/**
			 * ���� �� ��� ��������� ������, ���������� NULL 
			 */
			if ( !is_object($objTaster) )
			{
				return NULL;
			}
			
			/*
			 * �������� �������� ��� ������ ���� �����������
			 */
			
			//���� ����������, ������ �������� ���������� ������� ������ �� ������
			if (  $objTaster->sex !== "M" )
			{
				$strSexList = "<select name=\"taster_sex\">
								<option value=\"�\">M</option>
								<option selected value=\"�\">�</option>
							</select>";
			}
		}
		
		/**
		 * ������� ��������
		 */
		return <<<FORM_MARKUP
	<form action="assets/inc/process.inc.php" method="post"
		<fieldset>
			<label for="taster_surname">�������</label>
			<input type="text" name="taster_surname" 
				id="taster_surmane" value="$objTaster->surname"/>
			<label for="taster_name">���</label>
			<input type="text" name="taster_name"
				id="taster_name" value="$objTaster->name"/>
			<label for="taster_sex">���</label>
			$strSexList
			<input type="hidden" name="taster_id" value="$objTaster->id"/>
			<input type="hidden" name="action" value="taster_edit" />
			<input type="hidden" name="token" value="$_SESSION[token]" />
			<input type="submit" name="taster_submit" value="���������" />
			��� <a href="./">������</a>
		</fieldset>
	</form>
FORM_MARKUP;
	}
	
	
	/**
	 *
	 */
	
	/**
	 *
	 */
	
	/**
	 *
	 */
	 
	
	 
	/**
	 * ������������ ��� �������� ����� � ���������� ��� ��������������
	 * ������ � �����������
	 *
	 * @return mixed: TRUE � ������ ��������� ���������� ��� 
	 * ��������� �� ������ � ������ ����
	 */
	public function processTasterForm()
	{
		/*
		 * �����, ���� �������� "action" ������ �����������
		 */
		if ($_POST['action'] !== 'taster_edit' )
		{
			return "������������ ������� ������ ������ processTasterForm";
		}
		
		/*
		 * ������� ������ �� �����
		 */
		$strSurname = htmlentities($_POST['taster_surname'], ENT_QUOTES);
		$strName = htmlentities($_POST['taster_name'], ENT_QUOTES);
		$strSex = htmlentities($_POST['taster_sex'], ENT_QUOTES);
		
		/*
		 * ���� id �� ��� �������, �������� ������ ����������� � �������
		 */
		if ( empty($_POST['taster_id']) )
		{
			$strQuery = "INSERT INTO `tasters`
							(`taster_surname`, `taster_name`,`taster_sex`)
						VALUES
							(:surname, :name, :sex)";
		}
		/*
		 * �������� ���������� � �����������, ���� ��� ���������������
		 */
		else
		{
			// �������� id ����������� � �������������� ���� � ���������
			// ������������
			$id = (int) $_POST['taster_id'];
			$strQuery = "UPDATE `tasters`
						SET
							`taster_surname`=:surname,
							`taster_name`=:name,
							`taster_sex`=:sex
						WHERE `taster_id`=$id";
		}
		
		/*
		 * ����� �������� ������ ��������� ������ �������� ��� 
		 * �������������� ���������� � �����������
		 */
		try
		{
			$stmt = $this->_objDB->prepare($strQuery);
			$stmt->bindParam(":surname", $strSurname, PDO::PARAM_STR);
			$stmt->bindParam(":name", $strName, PDO::PARAM_STR);
			$stmt->bindParam(":sex", $strSex, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
			return true;
		}
		catch (Exception $e)
		{
			return $e->getMessage();
		}
	}
	
	/**
	 * ��������� ���������� � ������������ (�������������) � ������
	 * 
	 * @param int $id: �������������� ������������� (ID),
	 * ������������ ��� ���������� �����������
	 * @return array: ������ ������������, ����������� �� ���� ������
	 */
	private function _loadTasterData($id=NULL)
	{
		$strQuery = "SELECT
						`taster_id`,
						`taster_surname`,
						`taster_name`,
						`taster_sex`
					FROM `tasters`";
		
		/*
		 * ���� ������������ ������������� �����������, �������� �����������
		 * WHERE, ����� ������ ��������� ������ ��� �������
		 */
		if ( !empty($id) )
		{
			$strQuery .= "WHERE `taster_id`=:id LIMIT 1";
		}
		
		try
		{
			$stmt = $this->_objDB->prepare($strQuery);
			
			/*
			 * ��������� ��������, ���� ��� ������� �������������
			 */
			if ( !empty($id) )
			{
				$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			}
			
			$stmt->execute();
			$arrResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			
			return $arrResults;
		}
		catch ( Exception $e )
		{
			die ( $e->getMessage() );
		}
	}
}
 
?>