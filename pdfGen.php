<?php
if(isset($_GET['date0'])&&isset($_GET['date1'])&&isset($_GET['area']))
{

include('php/restriccionAcceso.php');

$fechaI=$_GET['date0'];
$fechaF=$_GET['date1'];
//$fechaE="2014-04-02";
$area=$_GET['area'];
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

    // get the HTML
    ob_start();
    include('indexx.php');
    $content = ob_get_clean();

    // convert in PDF
    require_once('libs/libPDF/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'Letter', 'fr');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('indexx.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}elseif (isset($_GET['id'])){
	include('php/restriccionAcceso.php');
	
	$idCatalogo=$_GET['id'];
	/**
	 * HTML2PDF Librairy - example
	 *
	 * HTML => PDF convertor
	 * distributed under the LGPL License
	 *
	 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
	 *
	 * isset($_GET['vuehtml']) is not mandatory
	 * it allow to display the result in the HTML format
	*/
	
	// get the HTML
	ob_start();
	include('pdfcomunicado.php');
	$content = ob_get_clean();
	
	// convert in PDF
	require_once('libs/libPDF/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P', 'Letter', 'es', true, 'UTF-8', 3);
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('indexx.pdf');
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}
}