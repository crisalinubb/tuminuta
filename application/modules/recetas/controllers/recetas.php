<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Recetas extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_recetas", "objRecetas");
		$this->load->model("modelo_tiporeceta", "objTiporeceta");
		$this->load->model("regimen/modelo_regimen", "objRegimen");
		$this->load->model("insumo_receta/modelo_insumoreceta", "objInsumoreceta");
		$this->load->model("insumos/modelo_insumos", "objInsumo");
		#current
		$this->layout->current = 1;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Recetas');

		#Metas
		$this->layout->setMeta('title','Recetas');
		$this->layout->setMeta('description','Recetas');
		$this->layout->setMeta('keywords','Recetas');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'recetas/';
		$config['total_rows'] = count($this->objRecetas->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/recetas'.$url;

		$this->pagination->initialize($config);

		//$contenido['datos'] = $this->objRecetas->listar($where, $pagina, $config['per_page']);

		$contenido['recetas'] = $this->objRecetas->listar();

		$contenido['pagination'] = $this->pagination->create_links();

		//$contenido["regimenes"]= $this->objRegimen->listar();
		$contenido["regimenes"]= $this->objRecetas->Obtener_bases();

		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'id_receta' => null,
				'nombre' => $this->input->post('nombre'),
				'id_regimen' => $this->input->post('codigo_regimen'),
				'id_tipo_receta' => $this->input->post('codigo_tiporeceta'),
				'formula' => $this->input->post('formula'),
				'complemento' => $this->input->post('complemento')
			);
			
			if($this->objRecetas->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Receta');

			#metas
			$this->layout->setMeta('title','Agregar Receta');
			$this->layout->setMeta('description','Agregar Receta');
			$this->layout->setMeta('keywords','Agregar Receta');

			#js
			$this->layout->js('js/sistema/recetas/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');
			#nav
			$this->layout->nav(array("Recetas "=> "recetas", "Agregar Receta" =>"/"));

			$contenido["tipo_recetas"]= $this->objTiporeceta->listar();
			$contenido["regimenes"]= $this->objRegimen->listar();

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'nombre' => $this->input->post('nombre'),
				'id_regimen' => $this->input->post('codigo_regimen'),
				'id_tipo_receta' => $this->input->post('codigo_tiporeceta'),
				'formula' => $this->input->post('formula'),
				'complemento' => $this->input->post('complemento')
			);

			if($this->objRecetas->actualizar($datos,array("id_receta"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{

			if(!$codigo) redirect(base_url() . "recetas/");
			#js
			$this->layout->js('js/sistema/recetas/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#title
			$this->layout->title('Editar Receta');

			#metas
			$this->layout->setMeta('title','Editar Receta');
			$this->layout->setMeta('description','Editar Receta');
			$this->layout->setMeta('keywords','Editar Receta');

			#contenido
			if($contenido['recetas'] = $this->objRecetas->obtener(array("id_receta" => $codigo)));
			else show_error('');

			$contenido["tipo_recetas"]= $this->objTiporeceta->listar();
			$contenido["regimenes"]= $this->objRegimen->listar();

			#nav
			$this->layout->nav(array("Recetas "=>"recetas", "Editar Receta" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function eliminar($codigo = false){
		if(!$codigo) redirect(base_url() . "recetas/");

			//buscando datos de elemento eliminado
			$receta_eliminado = $this->objRecetas->obtener(array('id_receta' => $codigo));

			//borrando el registro
			//$this->objRecetas->eliminar($codigo);
			$this->objRecetas->desactivar_recetas($codigo, $this->session->userdata("usuario")->id_unidad, $this->session->userdata("usuario")->id_usuario);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'recetas/';
			$config['total_rows'] = count($this->objRecetas->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/recetas'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objRecetas->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $receta_eliminado->nombre." registro desactivado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['recetas'] = $this->objRecetas->listar();
			//$contenido["regimenes"]= $this->objRegimen->listar();
			$contenido["regimenes"]= $this->objRecetas->Obtener_bases();

			$this->layout->view('index', $contenido);
	}

	public function activar($codigo = false){
		if(!$codigo) redirect(base_url() . "recetas/");

			//buscando datos de elemento eliminado
			$receta_eliminado = $this->objRecetas->obtener(array('id_receta' => $codigo));

			//borrando el registro
			//$this->objRecetas->eliminar($codigo);
			$this->objRecetas->activar_recetas($codigo, $this->session->userdata("usuario")->id_unidad, $this->session->userdata("usuario")->id_usuario);

			$url = explode('?',$_SERVER['REQUEST_URI']);
			if(isset($url[1]))
				$contenido['url'] = $url = '/?'.$url[1];
			else
				$contenido['url'] = $url = '/';

			#paginacion
			$config['base_url'] = base_url() . 'recetas/';
			$config['total_rows'] = count($this->objRecetas->listar($where));
			$config['per_page'] = 15;
			$config['suffix'] = $url;
			$config['first_url'] = base_url() . '/recetas'.$url;

			$this->pagination->initialize($config);

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			$contenido['datos'] = $this->objRecetas->listar($where, $pagina, $config['per_page']);

			$contenido['mesagge'] = $receta_eliminado->nombre." registro activado";

			$contenido['pagination'] = $this->pagination->create_links();
			$contenido['recetas'] = $this->objRecetas->listar();
			//$contenido["regimenes"]= $this->objRegimen->listar();
			$contenido["regimenes"]= $this->objRecetas->Obtener_bases();

			$this->layout->view('index', $contenido);
	}

	public function busqueda(){
		$recetas = $this->input->get('recetas',true);
		$regimenes = $this->input->get('regimenes',true);

		#Title
		$this->layout->title('Recetas');

		#Metas
		$this->layout->setMeta('title','Recetas');
		$this->layout->setMeta('description','Recetas');
		$this->layout->setMeta('keywords','Recetas');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		if (($recetas ==  0 || !$recetas)) {
			$contenido['datos'] = $this->objRecetas->listar(array('id_regimen' => $regimenes));
			//print_r("aaaaa");die();
		}else{
			$contenido['datos'] = $this->objRecetas->obtener_Receta_regimen($recetas, $regimenes);
			//print_r("ccccc");die();
		}

		$contenido['recetas'] = $this->objRecetas->listar();
		//$contenido["regimenes"]= $this->objRegimen->listar();
		$contenido["regimenes"]= $this->objRecetas->Obtener_bases();

		$this->layout->view('index', $contenido);

	}

	public function buscarRecetas(){
		$idRegimen = $this->input->post('idRegimen');
        if($idRegimen){
            $recetas = $this->objRecetas->listar(array('id_regimen' => $idRegimen));
            echo '<option value="0">Seleccione Receta</option>';
            foreach($recetas as $recet){
                echo '<option value="'. $recet->id_receta .'">'. $recet->nombre .'</option>';
            }
        }  else {
            echo '<option value="0">recetas</option>';
        }
	}

	public function InformeRecetas1(){

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		#JS - Formulario
		$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
		$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$this->layout->js('js/sistema/trazabilidad/index.js');

		$resultado = $this->objRecetas->listar();

		//EXCEL 1
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->
			getProperties()
				->setCreator("Mi Minuta")
				->setLastModifiedBy("Mi Minuta")
				->setTitle("Exportar Excel HHCC")
				->setSubject("Exportar Excel HHCC")
				->setDescription("Exportar Excel HHCC")
				->setKeywords("Exportar Excel HHCC")
				->setCategory("recetas");


		$styleArray = array(
			   'borders' => array(
					 'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '000000'),
					 ),
			   ),
			    'font'    => array(
				 'bold'      => true,
				 'italic'    => false,
				 'strike'    => false,
			 ),
			'alignment' => array(
					'wrap'       => true,
			  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'BABDBB')
			),
		);
		
		$styleArraInfo = array(
				'font'    => array(
				 'bold'      => false,
				 'italic'    => false,
				 'strike'    => false,
				 'size' => 10
				 ),
				 'borders' => array(
					 'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '000000'),
					 ),
			   ),
			   'alignment' => array(
					'wrap'       => true,
			  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			  )
		);
		
		
		$styleFont = array(
			 'font'    => array(
				 'bold'      => true,
				 'italic'    => false,
				 'strike'    => false,
			 ),
			'alignment' => array(
					'wrap'       => true,
			  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('1:3')->applyFromArray($styleFont);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Pedidos');
		
		$i=1;
		$letra = 'A';
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Receta');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(20);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Regimen');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(20);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Tipo de Receta');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(20);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Activado/Desactivado');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(20);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Insumo');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(10);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Cantidad');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(15);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Unidad de Medida');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$i=2;
		foreach ($resultado as $recetas){	
		
		$insumo_receta = $this->objInsumoreceta->listar(array('id_receta' => $recetas->id_receta));

		if(!$insumo_receta){
			$letra = "A";

		//EXCEL 2
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $recetas->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

		$regimen = $this->objRegimen->obtener(array('id_regimen' => $recetas->id_regimen));
			
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $regimen->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 

		$tipo_receta = $this->objTiporeceta->obtener(array('id_tipo_receta' => $recetas->id_tipo_receta));

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $tipo_receta->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 

		if ($recetas->estado == 0) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Activado');
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 
		}else if($recetas->estado == 1){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Desactivado');
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 
		}


		//$insumo = $this->objInsumo->obtener(array('id_insumo' => $ins_recet->id_insumo));

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, '');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, '');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, '');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

		$i++; 

		}else{
		
		foreach ($insumo_receta as $ins_recet) {

		$letra = "A";

		//EXCEL 2
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $recetas->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

		$regimen = $this->objRegimen->obtener(array('id_regimen' => $recetas->id_regimen));
			
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $regimen->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 

		$tipo_receta = $this->objTiporeceta->obtener(array('id_tipo_receta' => $recetas->id_tipo_receta));

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $tipo_receta->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 

		if ($recetas->estado == 0) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Activado');
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 
		}else if($recetas->estado == 1){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Desactivado');
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 
		}


		$insumo = $this->objInsumo->obtener(array('id_insumo' => $ins_recet->id_insumo));

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $insumo->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $ins_recet->cantidad);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $insumo->id_unidad_medida);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
			
		$i++; 
		}
		}
		}		
		
		$objPHPExcel->getActiveSheet()->setTitle("Recetas ".date("d-m-Y"));

		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="InfoRecetas - '.date('d/m/Y').'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save('php://output');
	}

	public function InformeRecetas(){

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		#JS - Formulario
		$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
		$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

		#JS - Ajax multi select
		$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
		$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

		$this->layout->js('js/sistema/trazabilidad/index.js');

		$resultado = $this->objRecetas->listar();

		//EXCEL 1
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->
			getProperties()
				->setCreator("Mi Minuta")
				->setLastModifiedBy("Mi Minuta")
				->setTitle("Exportar Excel HHCC")
				->setSubject("Exportar Excel HHCC")
				->setDescription("Exportar Excel HHCC")
				->setKeywords("Exportar Excel HHCC")
				->setCategory("recetas");


		$styleArray = array(
			   'borders' => array(
					 'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '000000'),
					 ),
			   ),
			    'font'    => array(
				 'bold'      => true,
				 'italic'    => false,
				 'strike'    => false,
			 ),
			'alignment' => array(
					'wrap'       => true,
			  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'BABDBB')
			),
		);
		
		$styleArraInfo = array(
				'font'    => array(
				 'bold'      => false,
				 'italic'    => false,
				 'strike'    => false,
				 'size' => 10
				 ),
				 'borders' => array(
					 'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '000000'),
					 ),
			   ),
			   'alignment' => array(
					'wrap'       => true,
			  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			  )
		);
		
		
		$styleFont = array(
			 'font'    => array(
				 'bold'      => true,
				 'italic'    => false,
				 'strike'    => false,
			 ),
			'alignment' => array(
					'wrap'       => true,
			  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('1:3')->applyFromArray($styleFont);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Pedidos');
		
		$i=1;
		$letra = 'A';
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Receta');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(20);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Regimen');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(20);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Tipo de Receta');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(20);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Activado/Desactivado');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(20);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Insumo');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(10);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Cantidad');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(15);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Unidad de Medida');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);

		$i=2;
		foreach ($resultado as $recetas){	
		
		//$insumo_receta = $this->objInsumoreceta->listar(array('id_receta' => $recetas->id_receta));
		$insumo_receta = $this->objRecetas->Informe_receta($recetas->id_receta);

		if(!$insumo_receta){
			$letra = "A";

		//EXCEL 2
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $recetas->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

		$regimen = $this->objRegimen->obtener(array('id_regimen' => $recetas->id_regimen));
			
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $regimen->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 

		$tipo_receta = $this->objTiporeceta->obtener(array('id_tipo_receta' => $recetas->id_tipo_receta));

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $tipo_receta->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 

		if ($recetas->estado == 0) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Activado');
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 
		}else if($recetas->estado == 1){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Desactivado');
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 
		}


		//$insumo = $this->objInsumo->obtener(array('id_insumo' => $ins_recet->id_insumo));

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, '');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, '');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, '');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

		$i++; 

		}else{
		
		foreach ($insumo_receta as $ins_recet) {

		$letra = "A";

		//EXCEL 2
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $recetas->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

		$regimen = $this->objRegimen->obtener(array('id_regimen' => $recetas->id_regimen));
			
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $regimen->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 

		$tipo_receta = $this->objTiporeceta->obtener(array('id_tipo_receta' => $recetas->id_tipo_receta));

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $tipo_receta->nombre);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 

		if ($recetas->estado == 0) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Activado');
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 
		}else if($recetas->estado == 1){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'Desactivado');
			$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 
		}


		//$insumo = $this->objInsumo->obtener(array('id_insumo' => $ins_recet->id_insumo));

		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $insumo->nombre);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $ins_recet->nombre_insumo);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo); 

		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $ins_recet->cantidad);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $ins_recet->cantidad_ir);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $insumo->id_unidad_medida);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, $ins_recet->nombre_um);
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
			
		$i++; 
		}
		}
		}		
		
		$objPHPExcel->getActiveSheet()->setTitle("Recetas ".date("d-m-Y"));

		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="InfoRecetas - '.date('d/m/Y').'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save('php://output');
	}

}
