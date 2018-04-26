<?php

	/**
	* Clase para el control de procesos con la base de datos
	* @author Oscar Castro
	*/

	class BDAdmin{

		public $bd = false;
		public $num_grupo = 18; // Numero del grupo
		public $mensaje = "";
		
		protected $nombre_bd;
		protected $nombre_tabla;
		protected $error_conexion_mysql = "No se ha realizado conexión con el motor de base de datos";

		/**
		 * Realizar la conexion al motor de base de datos tomando los datos previamente configurados
		 */
		function __construct(){
			require_once('config.php');
			$servidor = $config['bd_config']['servidor'];
			$usuario = $config['bd_config']['usuario'];
			$clave = $config['bd_config']['clave'];

			$this->nombre_bd = 'bdunad'.$this->num_grupo;
			$this->nombre_tabla = 'tabla'.$this->num_grupo;

			$this->bd = new mysqli($servidor, $usuario, $clave);
			if ($this->bd->connect_error) {
			    echo "Fallo al conectar a MySQL: " . $this->bd->connect_error; die;
			    // return $this->bd = false;
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
				}
			    return false;
		    }
		    else{
		    	return true;
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
		function verificar_tabla(){
			if (!$this->bd) return $this->error_conexion_mysql;
			$query="SHOW TABLES LIKE '$this->nombre_tabla'";
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

		/**
		 * Eliminación de un producto por medio de su codigo
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

	}
?>