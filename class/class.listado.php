<?php

	class Listado{
		private $bd;
		
		public $page;
		public $rows;
		public $sord;
		public $sidx;
		public $acciones;
		
		private $cual;
		private $query;
		private $where;
		private $group;
		private $sort;
		private $limit;
		private $total_pages 	= 0;
		private $total_records	= 0;
		private $columns = array();
		
		public $error = array();
		
		public function Listado( $cual = ''){
			
			if ( $cual != ''){
				
				$this->cual = $cual;
				$this->page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : 1;
				$this->rows = isset($_REQUEST['rows']) && is_numeric($_REQUEST['rows']) ? $_REQUEST['rows'] : 30;
				$this->sord = isset($_REQUEST['sord']) && $_REQUEST['sord'] != '' ? $_REQUEST['sord'] : "ASC";
				$this->sidx = isset($_REQUEST['sidx']) && $_REQUEST['sidx'] != '' ? $_REQUEST['sidx'] : "ID";
				
				$this->set_where();
				$this->set_consulta();
				
			} else {
				$this->limpiar();
				$this->error[] = "Listado inválido.";
			}
			
		}
		
		private function set_consulta() {
			switch ( $this->cual ){
				case 'usuarios':
					$this->query = " SELECT " 
									. " id_usuario as id, us_correo as usuario, us_timestamp AS fecha, pf_perfil as perfil, "
									. " CONCAT(IFNULL(us_apaterno, ''), ' ', IFNULL(us_amaterno, ''), ', ', us_nombre) AS nombre "
									. " FROM usuario "
									. " INNER JOIN perfil ON id_perfil = us_pf_id_perfil "
									. " WHERE id_usuario > 0 ";
					$this->group = " GROUP BY id ";
					$this->columns = array(  'usuario', 'nombre', 'perfil', 'fecha', 'acciones');
					
					break;
				case 'visitas':
					$this->query = "";
					$this->columns = array();
					break;
			}
			$this->sort = " ORDER BY " . $this->sidx . " " . $this->sord . " ";
		}
		
		private function set_where(){
			$this->where = "";
			if (isset($_REQUEST['searchField']) && $_REQUEST['searchField'] != '') { 
				$sfield = $_REQUEST['searchField'];
				$sstr 	= $_REQUEST['searchString'];
				$this->where .= " AND $sfield LIKE '%" . $sstr . "%' "; 
			}
		}
		 
		public function imprime(){
			if (count($this->error) == 0 && $this->query != ''){
				$this->bd = new IBD;
				
				$consulta_cuenta = "SELECT count(*) as RecordCount FROM (" . $this->query 
							. " " . $this->where 
							. " " . $this->group 
							. " " . $this->sort . ") as cuenta " ;
				
				if (($result = $this->bd->Query("Cuenta", $consulta_cuenta ))!= IBD_SUCCESS) {
					$this->error[] = "Ocurrió un error al consultar la BD. "; 
					echo $consulta_cuenta;
					return false;
				}
				else {
					
					$registro = $this->bd->Fetch("Cuenta"); 
					if ( !$registro ) { 
						$this->error[] = "Ocurrió un error al obtener la información de la BD. "; 
						return false;
					} 
					else { 
						$this->total_records = $registro['RecordCount']; 
						$start = (($this->page - 1) * $this->rows);
						if ($this->total_records > 0) {
							 $this->total_pages = ceil($this->total_records / $this->rows);
						} else { $this->total_pages = 0; } 
						$this->limit = " LIMIT " . $start . ", " . $this->rows;
						
						$consulta = $this->query 
									. " " . $this->where 
									. " " . $this->group 
									. " " . $this->sort
									. " " . $this->limit; 
						if (($result = $this->bd->Query("Listado", $consulta ))!= IBD_SUCCESS) {
							$this->error[] = "Ocurrió un error al consultar los registros en la BD. "; 
							return false;
						} 
						else {
							$result = $this->bd->Fetcharray("Listado");
							if ( $result !== FALSE ){
							
								$xml = $this->get_header(); 
								
								foreach ($result as $k => $lin) { 
									$xml .= "<row id='" . $lin["id"] . "'>\n";
									foreach ($this->columns as $c => $col) {
										switch ($col){
											case 'acciones':
												$xml .= "<cell><![CDATA[" . str_replace('%ID%',$lin['id'], $this->acciones) . "]]></cell>\n";
												break;
											case 'fecha':
											case 'timestamp':
												$xml .= "<cell><![CDATA[" . date( 'Y-m-d H:i:s' , $lin[$col] ) . "]]></cell>\n";
												break;
											default: 
												$xml .= "<cell><![CDATA[" . $lin[$col]  . "]]></cell>\n";
												break; 
										}
									} 
									$xml .= "</row>\n";
								} 
								$xml .= "</rows>";
								echo $xml; 
							}
							else {
								$this->error[] = 'Ocurrió un error al obtener los registros de la BD';
								return false;
							}
						} 
					}
					
				}
			} 
		}
		
		private function get_header(){
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
			header("Cache-Control: no-cache, must-revalidate");
			header("Pragma: no-cache");
			header("Content-type: text/xml");
			
			$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			$xml .= "<rows>\n";
			$xml .= "<page>" 	. $this->page 			. "</page>\n";
			$xml .= "<total>" 	. $this->total_pages 	. "</total>\n";
			$xml .= "<records>" . $this->total_records 	. "</records>\n"; 
			
			return $xml;
		}
		
		public function limpiar(){
			
			$this->where = "";
			$this->columns = array();
			$this->error 	= array();
		}  
	}
	
?>