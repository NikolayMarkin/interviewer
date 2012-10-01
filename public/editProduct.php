<?php

/*
 * �������� ����������� �����, ��������� ������������� ����������
 */
include_once '../sys/core/init.inc.php';

/*
 * ������ �������� �������� � ����� CSS
 */
$strPageTitle = "";
$arrCSSFiles = array('style.css', 'admin.css');

/*
 * �������� ��������� ����� ��������
 */
include_once 'assets/common/header.inc.php';

$objProductManager = new ProductManager();

/*
 * ���������� ��������� ��������
 */
?>

<div id="content">

<?php echo $objProductManager->displayProductForm(); ?>

</div><!-- end #content -->

<?php

/*
 * �������� ����������� ����� ��������
 */
include_once 'assets/common/footer.inc.php';
?>