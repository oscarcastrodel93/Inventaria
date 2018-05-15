<?php

	// Setear la zona horaria para evitar error al usar el metodo date
	date_default_timezone_set('America/Bogota');

	/**
	* Clase para el control de procesos con la base de datos
	* @author Oscar Castro
	*/
	class BDAdmin{

		private $servidor;
		private $usuario;
		private $clave;

		public $bd = false;
		public $num_grupo = 18; // Numero del grupo
		public $mensaje = "";
		public $conectado = false;
		
		protected $nombre_bd;
		protected $nombre_tabla;
		protected $error_conexion_mysql = "No se ha realizado conexión con el motor de base de datos";

		/**
		 * Realizar la conexion al motor de base de datos tomando los datos previamente configurados
		 */
		function __construct(){
			require_once('config.php');
			$this->servidor = $config['bd_config']['servidor'];
			$this->usuario = $config['bd_config']['usuario'];
			$this->clave = $config['bd_config']['clave'];

			$this->nombre_bd = 'bdunad'.$this->num_grupo;
			$this->nombre_tabla = 'tabla'.$this->num_grupo;

			$this->bd = new mysqli($this->servidor, $this->usuario, $this->clave);
			if ($this->bd->connect_error) {
			    echo "<h3>Fallo al conectar a MySQL: " . $this->bd->connect_error. ". Verifica que los datos de conexión en el archivo bd/config.php sean correctos.</h3>"; 
			    die;
		    }
		}
		
		/**
		 * Realizar conexion con la base de datos especifica
		 * @param [bool] [Para saber si se muestra o no el error de conexion]
		 * @return [objeto] [Instancia de MySQL]
		 */
		function conectar($mostrar_error=true){
			if (!$this->bd) return $this->error_conexion_mysql;
			$this->bd->select_db($this->nombre_bd);
			if ($this->bd->error) {
				if ($mostrar_error) {
			    	$this->mensaje = "Fallo al conectar a la base de datos: " . $this->bd->error;
			    	$this->mensaje.= ". Verifica en la página <a href='administrar.php' class='alert-link'>Administrador</a> que la base de datos haya sido creada.";
				}
			    return $this->conectado = false;
		    }
		    else{
		    	return $this->conectado = true;
		    }
		}

		/**
		 * Creacion de la base de datos
		 * @return [bool]
		 */
		function crear_bd(){
			if (!$this->bd) return $this->error_conexion_mysql;

			$query = "CREATE DATABASE IF NOT EXISTS $this->nombre_bd";
			if ($this->bd->query($query)) {
				$this->mensaje = "Base de datos creada!";
				return true;
			}
			else{
				$this->mensaje = "Error al crear la base de datos: ". $this->bd->error;
				return false;
			}
		}

		/**
		 * Creacion de la tabla de la base de datos
		 * Se crea por defecto con los campos requeridos para almacenar los productos
		 * @return [bool]
		 */
		function crear_tabla(){
			if (!$this->bd) return $this->error_conexion_mysql;

			$query="CREATE TABLE IF NOT EXISTS $this->nombre_tabla (
						id INT(6) AUTO_INCREMENT PRIMARY KEY,
						codigo_producto INT(10) NOT NULL,
						nombre_producto VARCHAR(50) NOT NULL,
						peso_producto DECIMAL(18, 2) NOT NULL,
						um_producto VARCHAR(3) NOT NULL,
						marca_producto VARCHAR(30) NOT NULL,
						fabricante_producto VARCHAR(30) NOT NULL,
						caracteristicas_producto TEXT
					)";
			if ($this->bd->query($query)) {
				$this->mensaje = "Tabla creada!";
				return true;
			}
			else{
				$this->mensaje = "Error al crear la tabla: ". $this->bd->error;
				return false;
			}
		}

		/**
		 * Verificar si la tabla ya ha sido creada
		 * @return [bool]
		 */
		function verificar_tabla($tabla=false){
			if (!$this->bd) return $this->error_conexion_mysql;
			$nombre_tabla = $tabla ? $tabla : $this->nombre_tabla;
			$query="SHOW TABLES LIKE '$nombre_tabla'";
			$resul = $this->bd->query($query);
			return $resul->num_rows > 0 ? true : false;
		}

		/**
		 * Eliminación de la base de datos
		 * @return [bool]
		 */
		function borrar_bd(){
			if (!$this->bd) return $this->error_conexion_mysql;

			$query = "DROP DATABASE IF EXISTS $this->nombre_bd";
			if ($this->bd->query($query)) {
				$this->mensaje = "Base de datos eliminada!";
				return true;
			}
			else{
				$this->mensaje = "Error al eliminar la base de datos: ". $this->bd->error;
				return false;
			}
		}

		/**
		 * Generacion del backup de la base de datos
		 * @return [type] [description]
		 */
		function backup_bd(){
			if (!$this->bd) return $this->error_conexion_mysql;
			$mysqldump = '"C:\AppServ\MySQL\bin\mysqldump.exe"';
			$ruta_backup = "backup/".$this->nombre_bd."_".date('Y-m-d_H-i-s').".sql";
			$cmd = "$mysqldump --no-defaults -u $this->usuario -p$this->clave $this->nombre_bd > $ruta_backup";
			system($cmd, $output);
			if (!$output) {
				$this->mensaje = "Backup generado!";
				return $ruta_backup;
			}
			else{
				$this->mensaje = "Error al generar el backup!";
				return false;
			}
		}

		/**
		 * Eliminación de la tabla de la base de datos
		 * @return [bool]
		 */
		function borrar_tabla(){
			if (!$this->bd) return $this->error_conexion_mysql;

			$query="DROP TABLE IF EXISTS $this->nombre_tabla";
			if ($this->bd->query($query)) {
				$this->mensaje = "Tabla eliminada!";
				return true;
			}
			else{
				$this->mensaje = "Error al eliminar la tabla: ". $this->bd->error;
				return false;
			}
		}

		###################################
		## Operaciones con los productos ##
		###################################

		/**
		 * Creacion de un producto a partir del formulario de ingreso de productos
		 * @param  [array] $datos [conjunto de datos del producto]
		 * @return [bool]
		 */
		function crear_producto($datos){
			if (!$this->bd) return $this->error_conexion_mysql;
			// Se verifica que no haya otro producto con el mismo codigo
			$query="SELECT * FROM $this->nombre_tabla WHERE codigo_producto = '$datos[codigo_producto]'";
			$resul = $this->bd->query($query);
			// Si el producto NO existe, se ingresa
			if (!$resul->num_rows) { 
				$query="INSERT INTO $this->nombre_tabla (codigo_producto
							, nombre_producto
							, peso_producto
							, um_producto
							, marca_producto
							, fabricante_producto
							, caracteristicas_producto) 
						VALUES ($datos[codigo_producto]
							, '$datos[nombre_producto]'
							, $datos[peso_producto]
							, '$datos[um_producto]'
							, '$datos[marca_producto]'
							, '$datos[fabricante_producto]'
							, '$datos[caracteristicas_producto]'
						)";
				if ($this->bd->query($query)) {
					$this->mensaje = "Producto '$datos[codigo_producto]' ingresado!";
					return true;
				}
				else{
					$this->mensaje = "Error al ingresar el producto: ". $this->bd->error;
					return false;
				}
			}
			else{
				$this->mensaje = "Ya existe un producto con el codigo ingresado ($datos[codigo_producto])";
				return false;
			}
		}

		/**
		 * Eliminación de un producto por medio de su codigo
		 * @param  [string] $codigo [codigo del producto a eliminar]
		 * @return [bool]
		 */
		function borrar_producto($codigo){
			if (!$this->bd) return $this->error_conexion_mysql;
			// Se busca si el producto existe
			$query="SELECT * FROM $this->nombre_tabla WHERE codigo_producto = '$codigo'";
			$resul = $this->bd->query($query);
			// Si existe se elimina, por el contrario se muestra el mensaje de error
			if ($resul->num_rows > 0) { 
				$query="DELETE FROM $this->nombre_tabla WHERE codigo_producto = '$codigo'";
				if ($this->bd->query($query)) {
					$this->mensaje = "Producto '$codigo' eliminado!";
					return true;
				}
				else{
					$this->mensaje = "Error al eliminar el producto: ". $this->bd->error;
					return false;
				}
			}
			else{
				$this->mensaje = "El producto '$codigo' no existe";
				return false;
			}
		}

		/**
		 * Consulta de productos
		 * @param  [string] $codigo [codigo del producto a buscar]
		 * @param  [bool] $unico  [si solo debe retornar un producto]
		 * @return [array]        [listado de productos]
		 */
		function consultar_productos($codigo, $unico=false){
			if (!$this->bd) return $this->error_conexion_mysql;
			// Se buscan productos por el codigo
			$where = $codigo ? "WHERE codigo_producto LIKE '$codigo'" : "";
			$query = "SELECT * FROM $this->nombre_tabla $where";
			$resul = $this->bd->query($query);
			$data = array();
			if ($resul->num_rows > 0) { 
				while ($row = $resul->fetch_assoc()) {
					$data[] = $row;
				}
				$this->mensaje = "";
				// Si solo se debe retornar un producto
				if ($unico) {
					return $data[0];
				}
			}
			else{
				$this->mensaje = "Sin resultados";
			}
			return $data;
		}

		/**
		 * Actualiza un producto
		 * @param  [array] $datos [conjunto de datos del producto]
		 * @return [bool]
		 */
		function actualizar_producto($datos){
			if (!$this->bd) return $this->error_conexion_mysql;
			// Se verifica que haya otro producto con el codigo ingresado
			$query="SELECT * FROM $this->nombre_tabla WHERE codigo_producto = '$datos[codigo_producto]'";
			$resul = $this->bd->query($query);
			// Si el producto existe, se actualiza
			if ($resul->num_rows) { 
				$query="UPDATE $this->nombre_tabla SET 
							nombre_producto = '$datos[nombre_producto]'
							, peso_producto = $datos[peso_producto]
							, um_producto = '$datos[um_producto]'
							, marca_producto = '$datos[marca_producto]'
							, fabricante_producto = '$datos[fabricante_producto]'
							, caracteristicas_producto = '$datos[caracteristicas_producto]'
						WHERE codigo_producto = $datos[codigo_producto]";
				if ($this->bd->query($query)) {
					$this->mensaje = "Producto actualizado!";
					return true;
				}
				else{
					$this->mensaje = "Error al actualizar el producto: ". $this->bd->error;
					return false;
				}
			}
			else{
				$this->mensaje = "No existe un producto con el codigo ingresado ($datos[codigo_producto])";
				return false;
			}
		}

		##################################
		## Operaciones con los usuarios ##
		##################################
		
		/**
		 * Creacion de la tabla de usuarios
		 * // Incluye la creacion del usuario admin
		 * @return [bool]
		 */
		function crear_tabla_usuarios(){
			if (!$this->bd) return $this->error_conexion_mysql;

			$query="CREATE TABLE usuarios (
						id INT(6) AUTO_INCREMENT PRIMARY KEY,
						nombre_usuario VARCHAR(50) NOT NULL,
						clave_usuario VARCHAR(50) NOT NULL,
						estado_usuario INT(1) NOT NULL
					)";
			if ($this->bd->query($query)) {
				$this->mensaje = "Tabla para usuarios creada! ";
				// Se crea un usuario admin por defecto
				$datos = array('nombre_usuario' => 'admin', 'clave_usuario' => '1234', 'estado_usuario' => 1);
				$this->crear_usuario($datos);
				return true;
			}
			else{
				$this->mensaje = "Error al crear la tabla de usuarios: ". $this->bd->error;
				return false;
			}
		}

		/**
		 * Creacion de usuario para el ingreso al sistema
		 * @param  [array] $datos   [datos del usuario a crear]
		 * @return [bool]
		 */
		function crear_usuario($datos){
			// Eliminar espacios en blanco
			$datos['nombre_usuario'] = $string = preg_replace('/\s/', '', $datos['nombre_usuario']);

			// Se verifica que no haya otro usuario con el mismo nombre
			$query="SELECT * FROM usuarios WHERE nombre_usuario = '$datos[nombre_usuario]'";
			$resul = $this->bd->query($query);
			// Si el usuario NO existe, se crea
			if (!$resul->num_rows) { 
				$query="INSERT INTO usuarios (nombre_usuario
							, clave_usuario
							, estado_usuario) 
						VALUES ('$datos[nombre_usuario]'
							, '".md5($datos['clave_usuario'])."'
							, $datos[estado_usuario]
						)";
				if ($this->bd->query($query)) {
					$this->mensaje .= "Usuario '$datos[nombre_usuario]' creado!";
					return true;
				}
				else{
					$this->mensaje = "Error al crear el usuario: ". $this->bd->error;
					return false;
				}
			}
			else{
				$this->mensaje = "Ya existe un usuario con el nombre ingresado ($datos[nombre_usuario])";
				return false;
			}
		}

		/**
		 * Consulta de usuarios
		 * @param  [string] $nombre [nombre del usuario a buscar]
		 * @param  [bool] $unico    [si solo debe retornar un usuario, el primero del listado]
		 * @return [array]          [listado de productos]
		 */
		function consultar_usuarios($nombre, $unico=false){
			if (!$this->bd) return $this->error_conexion_mysql;
			// Se buscan productos por el nombre
			$where = $nombre ? "WHERE nombre_usuario LIKE '$nombre'" : "";
			$query = "SELECT * FROM usuarios $where";
			$resul = $this->bd->query($query);
			$data = array();
			if ($resul->num_rows > 0) { 
				while ($row = $resul->fetch_assoc()) {
					$data[] = $row;
				}
				// Si solo se debe retornar un producto
				if ($unico) {
					return $data[0];
				}
			}
			else{
				$this->mensaje = "Sin resultados";
			}
			return $data;
		}

	}
?>