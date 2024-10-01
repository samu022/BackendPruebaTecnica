<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorCSV extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session'); // Cargar la librería de sesión
        $this->load->database(); // cargar la base de datos
        $this->load->model('Usuario'); // Modelo usuarios
        $this->load->model('Ciudad_Usuario'); // Modelo ciudadesusuario
       $this->load->model('Ciudad'); // modelo Ciudad

        
    }

    public function index() {
        $datos['usuarios'] = $this->Usuario->get_usuarios(); 
        $this->load->view('formulario', $datos); 
    }
    //Una vez seleccionado del csv se guarda la ciudad seleccionada y el usuario
    public function upload() {
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
              // Obtenemos la extensión del archivo
                $file_inf = pathinfo($_FILES['csv_file']['name']);
                $file_extension = strtolower($file_inf['extension']);

                // Verificar si la extensión es .csv
                if ($file_extension !== 'csv') {
                    $this->load->view('NoCSV'); 
                    return;
                }
                 
            //leemos
            $file = $_FILES['csv_file']['tmp_name']; 
            $file_r = fopen($file, 'r'); 
            if ($file_r) {
                // Verificar si el archivo está vacío
                if (filesize($file) === 0) {
                    
                    fclose($file_r);
                    $this->load->view('VacioCSV'); 
                    return;
                    
                }
                //Validacion
                echo 'Archivo CSV abierto correctamente';
                $ciudades = [];
                while (($row = fgetcsv($file_r, 500, "\t")) !== false) {
                    if (!empty($row[0]) && !empty($row[2])) {
                        //print_r($row[0] . " " . $row[2] . "\n");

                        $ciudades[] = [
                            'nombre' => $row[2], 
                            'Id' => $row[0]  
                        ];
                    }
                } 
                fclose($file_r); 
               
                //obtenemos ciudades del CSV
                if ($ciudades) {
                    $datos['ciudades'] = $ciudades; 
                    $datos['usuarios'] = $this->Usuario->get_usuarios(); 
                    $this->load->view('formulario', $datos); 
                } else {
                    echo 'No hay ciudades para mostrar.'; 
                }
            } else {
                echo 'Error al abrir el archivo.'; 
            }
        } else {
            echo 'Archivo no válido, solo se acepta CSV o error al cargar.'; 
        }
    }

    

    public function save() {
        //print_r($_POST);
        //Obtenemos los POSTS
        $IdUsuario = $this->input->post('IdUsuario'); 
        $IdCiudad = $this->input->post('IdCiudad'); 
        $nombreCiudad = $this->input->post('nombreCiudad');
        //Guardamos la ciudad en el modelo
        if ($this->Ciudad->Guardar_Ciudad($nombreCiudad, $IdCiudad)) {
            //Guardar la relacion
             if ($this->Ciudad_Usuario->Guardar_Ciudad_Usuario($IdUsuario, $IdCiudad)) {
                $this->load->view('exito'); 
            } else {
                echo 'Error al guardar la ciudad.'; 
            }
        } else {
            echo 'Error al guardar la relación y ciudad.'; 
        }
        
    }
    public function mostrarCiudadUsuario() {
        //Obtener datos actualizados 
        $datos['ciudadUsuarios'] = $this->Ciudad_Usuario->obtenerCiudadUsuario();
        $this->load->view('formulario', $datos); 
    }
}
