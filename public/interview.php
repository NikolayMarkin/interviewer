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

//���������� �������� ��� ����� ��������
//$objTasterManager = new TasterManager();
$objInterview = new Interview(M_PROFIL,$objDB);
?>

<div id="content">
<?php echo $objInterview->nextCluster()?>
</div><!-- end #content -->

<?php

/*
 * �������� ����������� ����� ��������
 */
include_once 'assets/common/footer.inc.php';
?>