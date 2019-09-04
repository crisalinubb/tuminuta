<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
//si no existe la función invierte_date_time la creamos
if(!function_exists('send_email'))
{
    //formateamos la fecha y la hora, función de cesarcancino.com
 function send_email($to, $message, $subject, $recipients, $attach){
 	$config = Array(
 	  'protocol' => 'smtp',
 	  'smtp_host' => 'mail.redsalud.gov.cl',
 	  'smtp_port' => 25,
 	  'smtp_user' => 'hospital.herminda',
 	  'smtp_pass' => 'HCHM001Mail',
 	  'mailtype'  => 'html', 
 	  'charset'   => 'utf-8',
 	  'wordwrap'  => true
 	);
 	$CI =& get_instance();
 	$CI->load->library('email', $config);
 	$CI->email->from('hospital.herminda@redsalud.gov.cl', 'Hospital Clínico Herminda Martin');
 	$CI->email->to($to);
 	$CI->email->bcc($recipients);

 	$CI->email->subject($subject);
 	$CI->email->message(mb_convert_encoding($message, "UTF-8"));
 	if(isset($attach)) { $CI->email->attach($path); }
 	$CI->email->set_newline("\r\n");
 	$CI->email->set_crlf( "\r\n" );
 	
 	$CI->email->send();
 	
 }
 
}