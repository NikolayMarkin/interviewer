<?php

/**
 * �������� ����������� �����
 */
include_once '../sys/core/init.inc.php';

/*
 * ������������� ��������������������� ������������ �� �������� ��������
 */
if (!isset($_SESSION['user']) )
{
	header("Location: ./");
	exit();
}

/**
 * ������� ��������� ����� ��������
 */
$strPageTitle = "";
$arrCSSFiles = array('style.css', 'admin.css');
include_once 'assets/common/header.inc.php';

$objInterview = new Interview($objDB)

?>

<div id="content">

<?php echo $objInterview->displayInterviewForm(); ?>

</div><!-- end #content -->

<?php

/*
 * ������� ����������� ����� ��������
 */
include_once 'assets/common/footer.inc.php';

?>