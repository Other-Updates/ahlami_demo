<?php  
if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed');

if (!function_exists('create_pdf')) 
{
    function create_pdf($html_body,$html_header,$file_name = '') 
	{
        $body = $html_body;
		if ($file_name == '') {
            $file_name = 'pdf_' .time();
        }
        require 'mpdf/mpdf.php';
        $mpdf = new mPDF();		
        $mpdf = new mPDF('', 'A4', '10', '"Roboto", "Noto", sans-serif', 5, 5, 36, 10, 5, 5, 'L');
        $mpdf->SetHTMLHeader($html_header);        
        $mpdf->setFooter('{PAGENO} / {nb}');	
        $mpdf->WriteHTML($body);
        $mpdf->Output($file_name.'.pdf', 'D');		
        exit;
    }
}