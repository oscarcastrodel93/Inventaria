<?php

	/**
	* Clase para el control de procesos con la base de datos
	* @author Oscar Castro
	*/

	class BDAdmin{

		public $bd = false;
		public $num_grupo = 18; // Numero del grupo
		
		protected $nombre_bd;
		protected $nombre_tabla;
		protected $error_conexion_mysql = "No se ha realizado conexión con el motor de base de datos";

		/**
		 * Realizar la conexion al motor de base de datos
		 * @param string $servidor [direccion del servidor de base de datos]
		 * @param string $usuario  [usuario de la base de datos]
		 * @param string $clave    [contraseña de la base de datos]
		 */
		function __construct($servidor, $usuario, $clave){
			$this->nombre_bd = 'bdunad'.$this->num_grupo;
			$this->nombre_tabla = 'tabla'.$this->num_grupo;

			$this->bd = new mysqli($servidor, $usuario, $clave);
			if ($this->bd->connect_errno) {
			    echo "Fallo al conectar a MySQL: (" . $this->bd->connect_errno . ")<br>" . $this->bd->connect_error;
			    return $this->bd = false;
		    }
		}
		
		/**
		 * Realizar conexion con la base de datos especifica
		 * @return [objeto] [Instancia de MySQL]
		 */
		function conectar(){
			if (!$this->bd) return $this->error_conexion_mysql;
			$this->bd->select_db($this->nombre_bd);
			if ($this->bd->connect_errno) {
			    echo "Fallo al conectar a la base de datos: (" . $this->bd->connect_errno . ")<br>" . $this->bd->connect_error;
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
				echo "Base de datos creada!";
				return true;
			}
			else{
				echo "Error al crear la base de datos. ". $this->bd->error;
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
				echo "Tabla creada!";
				return true;
			}
			else{
				echo "Error al crear la tabla. ". $this->bd->error;
				return false;
			}
			
		}

		/**
		 * Elimina la base de datos y la crea de nuevo con la respectiva tabla
		 * @return [bool]
		 */
		function resetear(){
			if (!$this->bd) return $this->error_conexion_mysql;

			$query = "DROP DATABASE IF EXISTS $this->nombre_bd";
			if ($this->bd->query($query)) {
				$this->crear_bd();
				$this->crear_tabla();
				return true;
			}
			else{
				echo "Error al eliminar la base de datos. ". $this->bd->error;
				return false;
			}
		}

	}
?>