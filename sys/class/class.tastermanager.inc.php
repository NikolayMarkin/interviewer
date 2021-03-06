<?php

/**
 * Обеспечивает работу с дегустаторами: создание в системе, 
 * редактирование данных о дегустаторе
 */
class TasterManager extends DB_Connect
{
	/**
	 * Создает объект базы
	 * 
	 * При создании экземпляра этого класса конструктор принимает
	 * объект базы данных в качестве параметра. Если значение этого 
	 * параметра отлично от null, оно сохраняется в закрытом 
	 * свойстве $_objDB. Если же это значение равно null, то вместо
	 * этого создается и сохраняется новый PDO-объект.
	 *
	 * @param object $dbo:
	 * @return void
	 */
	public function __construct($dbo=NULL)
	{
		/**
		 * Вызвать конструктор родительского класса для проверки
		 * существования объекта базы данных
		 */
		parent::__construct($dbo);
	}
	
	/**
	 * Возвращает HTML-разметку для отображения выпадающего списка 
	 * всех дегустаторов зарегистрированных в системе
	 *
	 * @return string: HTML-разметка
	 */
	public function buildTasterList()
	{
		/*
		 * Получаем список всех дегустаторов зарегистрированных в системе
		 */
		$arrTasters = $this->_createTasterObj(); 
		
		/*
		 * Создать HTML-разметку выпадающего списка дегустаторов
		 */
		$html = "<select name=\"taster_id\">\n\r";
		foreach ( $arrTasters as $objTaster )
		{
			$html .= "<option value=\"$objTaster->id\">$objTaster->surname $objTaster->name</option>\n\r";
		}
		$html .="</select>";
		return $html;
	}
	
	/**
	 * Генерирует форму, позволяющую редактировать данные о
	 * дегустаторе или создавать нового в системе.
	 *
	 * @return string: HTML-разметка формы для редактирования 
	 * информации о дегустаторе
	 */
	public function displayTasterForm()
	{
		/**
		 * Проведить, был ли передан идентификатор
		 */
		if ( isset($_POST['taster_id']) )
		{
			// Принудительно задать целочисленный тип для
			// обеспечения безопасности данных
			$id = (int) $_POST['taster_id'];
		}
		else
		{
			$id = NULL;
		}
		
		/*
		 * Сгенерировать разметку для выбора пола дегустатора
		 * по умолчанию установлен мужской пол
		 */
		$strSexList = "<select name=\"taster_sex\">
							<option selected value=\"М\">M</option>
							<option value=\"Ж\">Ж</option>
						</select>";
		
		/**
		 * Если был передан ID, загрузить соотвествующую информацию
		 */
		if ( !empty($id) )
		{
			$objTaster = $this->_loadTasterById($id);
			
			/**
			 * Если не был возвращен объект, возвратить NULL 
			 */
			if ( !is_object($objTaster) )
			{
				return NULL;
			}
			
			/*
			 * Изменить разметку для выбора пола дегустатора
			 */
			
			//если дегустатор, данные которого изменяются мужчина ничего не делаем
			if (  $objTaster->sex !== "M" )
			{
				$strSexList = "<select name=\"taster_sex\">
								<option value=\"М\">M</option>
								<option selected value=\"Ж\">Ж</option>
							</select>";
			}
			 
		}
		
		/**
		 * Создать разметку
		 */
		return <<<FORM_MARKUP
	<form action="assets/inc/process.inc.php" method="post">
		<fieldset>
			<label for="taster_surname">Фамилия:</label>
			<input type="text" name="taster_surname" 
				id="taster_surmane" value="$objTaster->surname"/>
			<label for="taster_name">Имя:</label>
			<input type="text" name="taster_name"
				id="taster_name" value="$objTaster->name"/>
			<label for="taster_date_birth">Дата рождения (ГГГГ-ММ-ДД):</label>
			<input type="text" name="taster_date_birth"
				id="taster_date_birth" value="$objTaster->dateBirth"/>
			<label for="taster_sex">Пол:</label>
			$strSexList
			<label for="taster_preffered">Предпочитаемая группа кондитерских изделий:</label>
			<input type="text" name="taster_preffered"
				id="taster_preffered" value="$objTaster->preffered"/>
			<label for="taster_residense">Место проживания:</label>
			<input type="text" name="taster_residense"
				id="taster_residense" value="$objTaster->residense"/>
			<label for="taster_allergy">Аллергия, если есть:</label>
			<input type="text" name="taster_allergy"
				id="taster_allergy" value="$objTaster->allergy"/>
			<label for="taster_work">Характер работы:</label>
			<input type="text" name="taster_work"
				id="taster_work" value="$objTaster->work"/>
			<label for="taster_in_research">Участие в исследованиях:</label>
			<input type="text" name="taster_in_research"
				id="taster_in_research" value="$objTaster->inResearch"/>
			<label for="taster_scale_from">Шкала дохода от:</label>
			<input type="text" name="taster_scale_from"
				id="taster_scale_from" value="$objTaster->scaleFrom"/>
			<label for="taster_scale_to">до:</label>
			<input type="text" name="taster_scale_to"
				id="taster_scale_to" value="$objTaster->scaleTo"/>
			<input type="hidden" name="taster_id" value="$objTaster->id"/>
			<input type="hidden" name="action" value="taster_edit" />
			<input type="hidden" name="token" value="$_SESSION[token]" />
			<input type="submit" name="taster_submit" value="Сохранить" />
			или <a href="./">отмена</a>
		</fieldset>
	</form>
FORM_MARKUP;
	}
	
	/**
	 * Предназначен для проверки формы и сохранения или редактирования
	 * данных о дегустаторе
	 *
	 * @return mixed: TRUE в случае успешного завершения или 
	 * сообщение об ошибке в случае сбоя
	 */
	public function processTasterForm()
	{
		/*
		 * Выход, если значение "action" задано неправильно
		 */
		if ($_POST['action'] !== 'taster_edit' )
		{
			return "Некорректная попытка вызова метода processTasterForm";
		}
		
		/*
		 * извлечь данные из формы
		 */
		$strSurname = htmlentities($_POST['taster_surname'], ENT_QUOTES);
		$strName = htmlentities($_POST['taster_name'], ENT_QUOTES);
		$strSex = htmlentities($_POST['taster_sex'], ENT_QUOTES);
		$strDateBirth = htmlentities($_POST['taster_date_birth']);
		$strPreffered = htmlentities($_POST['taster_preffered']);
		$strResidense = htmlentities($_POST['taster_residense']);
		$strAllergy = htmlentities($_POST['taster_allergy']);
		$strWork = htmlentities($_POST['taster_work']);
		$strInResearch = htmlentities($_POST['taster_in_research']);
		$intScaleFrom = (int)$_POST['taster_scale_from'];
		$intScaleTo = (int)$_POST['taster_scale_to'];
		
		/*
		 * Если id не был передан, созадать нового дегустатора в системе
		 */
		if ( empty($_POST['taster_id']) )
		{
			$strQuery = "INSERT INTO `tasters`
							(
							`taster_surname`,
							`taster_name`,
							`taster_sex`,
							`taster_date_birth`,
							`taster_preffered`,
							`taster_residense`,
							`taster_allergy`,
							`taster_work`,
							`taster_in_research`,
							`taster_scale_from`,
							`taster_scale_to`
							)
						VALUES
							(
							:surname, 
							:name, 
							:sex,
							:date_birth,
							:preffered,
							:residense,
							:allrgy,
							:work,
							:in_research,
							$intScaleFrom,
							$intScaleTo
							)";
		}
		/*
		 * Обновить информацию о дегустаторе, если она редактировалась
		 */
		else
		{
			// Привести id дегустатора к целочисленному типу в интересах
			// безопасности
			$id = (int) $_POST['taster_id'];
			$strQuery = "UPDATE `tasters`
						SET
							`taster_surname`=:surname,
							`taster_name`=:name,
							`taster_sex`=:sex,
							`taster_date_birth` = :date_birth,
							`taster_preffered` = :preffered,
							`taster_residense` = :residense,
							`taster_allergy` = :allrgy,
							`taster_work` = :work,
							`taster_in_research` = :in_research,
							`taster_scale_from` = $intScaleFrom,
							`taster_scale_to` = $intScaleTo
						WHERE `taster_id`=$id";
		}
		
		/*
		 * После привязки данных выполнить запрос создания или 
		 * редактирования информации о дегустаторе
		 */
		try
		{
			$stmt = $this->_objDB->prepare($strQuery);
			$stmt->bindParam(":surname", $strSurname, PDO::PARAM_STR);
			$stmt->bindParam(":name", $strName, PDO::PARAM_STR);
			$stmt->bindParam(":sex", $strSex, PDO::PARAM_STR);
			$stmt->bindParam(":date_birth", $strDateBirth, PDO::PARAM_STR);
			$stmt->bindParam(":preffered", $strPreffered, PDO::PARAM_STR);
			$stmt->bindParam(":work", $strWork, PDO::PARAM_STR);
			$stmt->bindParam(":residense", $strResidense, PDO::PARAM_STR);
			$stmt->bindParam(":allrgy", $strAllergy, PDO::PARAM_STR);
			$stmt->bindParam(":in_research", $strInResearch, PDO::PARAM_STR);
			
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
	 * Загружает информацию о пользователе (пользователях) в массив
	 * 
	 * @param int $id: необязательный идентификатор (ID),
	 * используемый для фильтрации результатов
	 * @return array: массив дегустаторов, извлеченных из базы данных
	 */
	private function _loadTasterData($id=NULL)
	{
		$strQuery = "SELECT
						`taster_id`,
						`taster_surname`,
						`taster_name`,
						`taster_sex`,
						`taster_date_birth`,
						`taster_preffered`,
						`taster_residense`,
						`taster_allergy`,
						`taster_work`,
						`taster_in_research`,
						`taster_scale_from`,
						`taster_scale_to`
					FROM `tasters`";
		
		/*
		 * Если предоставлен идентификатор дегустатора, добавить предложение
		 * WHERE, чтобы запрос возвращал только это событие
		 */
		if ( !empty($id) )
		{
			$strQuery .= " WHERE `taster_id`=:id ";
		}
		
		/*
		 * Добавить условие сортировки, чтобы последний добавленный пользователь
		 * попадал в начало списка
		 */
		$strQuery .= " ORDER BY `taster_id` DESC";
		
		try
		{
			$stmt = $this->_objDB->prepare($strQuery);
			
			/*
			 * Привязать параметр, если был передан идентификатор
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
	
	/**
	 * Загружает всех дегустаторов, зарегистрированных в системе, в массив
	 * 
	 * @return array: информация о дегустаторах
	 */
	private function _createTasterObj($id=NULL)
	{
		/*
		 * Загрузить массив информации о дегустаторах
		 */
		$arrTasters = $this->_loadTasterData($id);
		
		/*
		 * Созадать новый массив объектов
		 */
		$arrObjTasters = array();
		$i = 0;
		foreach( $arrTasters as $taster )
		{
			try
			{
				$arrObjTasters[$i++] = new Taster($taster);
			}
			catch ( Exception $e )
			{
				die ($e->getMessage() );
			}
		}
		return $arrObjTasters;
	}
	
	/**
	 * Возвращает объект дегустатора
	 *
	 * @param int $id: идентификатор дегустатора
	 * @return object: объект дегустатора
	 */
	public function getTasterById($id)
	{
		/*
		 * Если идентификатор не передан, возвратить NULL
		 */
		if ( empty($id) )
		{
			return NULL;
		}
		
		/*
		 * Загрузить данные о дегустаторе в массив
		 */
		$arrTaster = $this->_loadTasterData($id);
		
		/*
		 * Возвратить объект дегустатора
		 */
		if ( isset($arrTaster[0]) )
		{
			return new Taster($arrTaster[0]);
		}
		else
		{
			return NULL;
		}
	}
}
 
?>