<?php

/*
 * �������� ����������� �����, ��������� ������������� ����������
 */
include_once '../sys/core/init.inc.php';

/*
 * ������ �������� �������� � ����� CSS
 */
$strPageTitle = "";
$arrCSSFiles = array('style.css', 'admin.css', 'ajax.css', 'jquery-ui-1.9.0.custom.css');

/*
 * �������� ��������� ����� ��������
 */
include_once 'assets/common/header.inc.php';

/*
 * ������������� ��������������������� ������������ �� �������� ��������
 */
if (!isset($_SESSION['user']) )
{
	header("Location: ./");
	exit();
}

/*
 * ������� ������ ��� ������ � �������� ������������ �������
 */
$objGroupManager = new ProductGroupManager($objDB);

?>

<div id="content">
	<?php echo $objGroupManager->displayProductGroupForm()?>
</div><!-- end #content -->

<?php

/*
 * �������� ����������� ����� ��������
 */
include_once 'assets/common/footer.inc.php';
?>