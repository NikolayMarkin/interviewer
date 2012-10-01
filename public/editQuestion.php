<?php

/*
 * �������� ����������� �����, ��������� ������������� ����������
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

/*
 * ������ �������� �������� � ����� CSS
 */
$strPageTitle = "";
$arrCSSFiles = array('style.css', 'admin.css');

/*
 * �������� ��������� ����� ��������
 */
include_once 'assets/common/header.inc.php';

$objInterview = new Interview();

/*
 * ���������� ��������� ��������
 */
?>

<div id="content">

<?php echo $objInterview->displayQuestionForm(); ?>

</div><!-- end #content -->

<?php

/*
 * �������� ����������� ����� ��������
 */
include_once 'assets/common/footer.inc.php';
?>