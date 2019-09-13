<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "inicio";
$route['404_override'] = '';


/* RUTAS PYME */

#login
$route['login']											= "inicio/login";

#logout
$route['logout']										= "inicio/logout";

#hospital
$route['hospital/(:num)'] 								= "hospital/index/$1";
$route['hospital'] 										= "hospital";
$route['hospital/editar/(:num)'] 						= "hospital/editar/$1";

#rubros
$route['rubros/(:num)'] 								= "rubros/index/$1";
$route['rubros'] 										= "rubros";
$route['rubros/editar/(:num)'] 							= "rubros/editar/$1";

#unidades_medida
$route['unidades_medida/(:num)'] 						= "unidades_medida/index/$1";
$route['unidades_medida'] 								= "unidades_medida";
$route['unidades_medida/editar/(:num)'] 				= "unidades_medida/editar/$1";

#proveedor
$route['proveedor/(:num)'] 								= "proveedor/index/$1";
$route['proveedor'] 									= "proveedor";
$route['proveedor/editar/(:num)'] 						= "proveedor/editar/$1";

#insumos
$route['insumos/(:num)'] 								= "insumos/index/$1";
$route['insumos'] 										= "insumos";
$route['insumos/editar/(:num)'] 						= "insumos/editar/$1";

#Aportes Nutricionales
$route['aportes_nutricionales/(:num)'] 					= "aportes_nutricionales/index/$1";
$route['aportes_nutricionales'] 						= "aportes_nutricionales";
$route['aportes_nutricionales/editar/(:num)'] 			= "aportes_nutricionales/editar/$1";

#Tipos de recetas
$route['tipos_de_recetas/(:num)'] 						= "tipos_de_recetas/index/$1";
$route['tipos_de_recetas'] 								= "tipos_de_recetas";
$route['tipos_de_recetas/editar/(:num)'] 				= "tipos_de_recetas/editar/$1";

#Servicios Clinicos
$route['servicio_clinico/(:num)'] 						= "servicio_clinico/index/$1";
$route['servicio_clinico'] 								= "servicio_clinico";
$route['servicio_clinico/editar/(:num)'] 				= "servicio_clinico/editar/$1";

#Camas
$route['camas/(:num)'] 									= "camas/index/$1";
$route['camas'] 										= "camas";
$route['camas/editar/(:num)'] 							= "camas/editar/$1";

#Salas
$route['salas/(:num)'] 									= "salas/index/$1";
$route['salas'] 										= "salas";
$route['salas/editar/(:num)'] 							= "salas/editar/$1";

#Aportes por insumo
$route['aporte_insumo/(:num)'] 							= "aporte_insumo/index/$1";
$route['aporte_insumo'] 								= "aporte_insumo";
$route['aporte_insumo/editar/(:num)'] 					= "aporte_insumo/editar/$1";

#Regimen
$route['regimen/(:num)'] 								= "regimen/index/$1";
$route['regimen'] 										= "regimen";
$route['regimen/editar/(:num)'] 						= "regimen/editar/$1";

#Recetas
$route['recetas/(:num)'] 								= "recetas/index/$1";
$route['recetas'] 										= "recetas";
$route['recetas/editar/(:num)'] 						= "recetas/editar/$1";

#Insumos por Recetas
$route['insumo_receta/(:num)'] 							= "insumo_receta/index/$1";
$route['insumo_receta'] 								= "insumo_receta";
$route['insumo_receta/editar/(:num)'] 					= "insumo_receta/editar/$1";

#Pacientes Hospitalizados
$route['paciente/(:num)'] 								= "paciente/index/$1";
$route['paciente'] 										= "paciente";
$route['paciente/editar/(:num)'] 						= "paciente/editar/$1";

#Todos los pacientes
$route['paciente_general/(:num)'] 						= "paciente_general/index/$1";
$route['paciente_general'] 								= "paciente_general";
$route['paciente_general/editar/(:num)'] 				= "paciente_general/editar/$1";

#Desayuno
$route['desayuno/(:num)'] 								= "desayuno/index/$1";
$route['desayuno'] 										= "desayuno";
$route['desayuno/editar/(:num)'] 						= "desayuno/editar/$1";
$route['desayuno/(:num)/cambio_estado'] 			    = "desayuno/cambio_estado/$1";

#Almuerzo
$route['almuerzo/(:num)'] 								= "almuerzo/index/$1";
$route['almuerzo'] 										= "almuerzo";
$route['almuerzo/editar/(:num)'] 						= "almuerzo/editar/$1";

#Once
$route['once/(:num)'] 									= "once/index/$1";
$route['once'] 											= "once";
$route['once/editar/(:num)'] 							= "once/editar/$1";
$route['once/(:num)/cambio_estado'] 			        = "once/cambio_estado/$1";

#Cena
$route['cena/(:num)'] 									= "cena/index/$1";
$route['cena'] 											= "cena";
$route['cena/editar/(:num)'] 							= "cena/editar/$1";

#Colacion de las 10
$route['colacion/(:num)'] 								= "colacion/index/$1";
$route['colacion'] 										= "colacion";
$route['colacion/editar/(:num)'] 						= "colacion/editar/$1";
$route['colacion/(:num)/cambio_estado'] 			    = "colacion/cambio_estado/$1";

#Colacion de las 20
$route['col_20/(:num)'] 								= "col_20/index/$1";
$route['col_20'] 										= "col_20";
$route['col_20/editar/(:num)'] 							= "col_20/editar/$1";

#Usuarios
$route['usuarios/(:num)'] 								= "usuarios/index/$1";
$route['usuarios'] 										= "usuarios";
$route['usuarios/editar/(:num)'] 						= "usuarios/editar/$1";

#Comunas
$route['comuna/(:num)'] 								= "comuna/index/$1";
$route['comuna'] 										= "comuna";
$route['comuna/editar/(:num)'] 							= "comuna/editar/$1";

#Diagnostico
$route['diagnostico/(:num)'] 							= "diagnostico/index/$1";
$route['diagnostico'] 									= "diagnostico";
$route['diagnostico/editar/(:num)'] 					= "diagnostico/editar/$1";

#Escolaridad
$route['escolaridad/(:num)'] 							= "escolaridad/index/$1";
$route['escolaridad'] 									= "escolaridad";
$route['escolaridad/editar/(:num)'] 					= "escolaridad/editar/$1";

#Etnia
$route['etnia/(:num)'] 									= "etnia/index/$1";
$route['etnia'] 										= "etnia";
$route['etnia/editar/(:num)'] 							= "etnia/editar/$1";

#Pais
$route['pais/(:num)'] 									= "pais/index/$1";
$route['pais'] 											= "pais";
$route['pais/editar/(:num)'] 							= "pais/editar/$1";

#Region
$route['region/(:num)'] 								= "region/index/$1";
$route['region'] 										= "region";
$route['region/editar/(:num)'] 							= "region/editar/$1";

#Producto
$route['producto/(:num)'] 								= "producto/index/$1";
$route['producto'] 										= "producto";
$route['producto/editar/(:num)'] 						= "producto/editar/$1";

#Detalle_codigo
$route['detalle_codigo/(:num)'] 						= "detalle_codigo/index/$1";
$route['detalle_codigo'] 								= "detalle_codigo";
$route['detalle_codigo/editar/(:num)'] 					= "detalle_codigo/editar/$1";

#Detalle_codigo
$route['destinos/(:num)'] 								= "destinos/index/$1";
$route['destinos'] 										= "destinos";
$route['destinos/editar/(:num)'] 						= "destinos/editar/$1";

#Aportes por Regimen
$route['aportes_regimen/(:num)'] 						= "aportes_regimen/index/$1";
$route['aportes_regimen'] 								= "aportes_regimen";
$route['aportes_regimen/editar/(:num)'] 				= "aportes_regimen/editar/$1";

#Aportes por Regimen
$route['funcionario/(:num)'] 						    = "funcionario/index/$1";
$route['funcionario'] 							    	= "funcionario";
$route['funcionario/editar/(:num)'] 				    = "funcionario/editar/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
