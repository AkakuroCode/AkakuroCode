<?php
// Incluimos el archivo de configuración de la base de datos.
require 'config/Database.php';

class Productos {
    // Conexión a la base de datos y nombre de la tabla.
    private $conn;
    private $table_name1 = "producto";

    // Atributos privados.
    private $sku;
    private $id_emp;
    private $Nombre;
    private $descripcion;
    private $oferta;
    private $fecof;
    private $estado;
    private $origen;
    private $Precio;
    private $stock;

    

    // Constructor para inicializar la conexión a la base de datos.
    public function __construct() {
        $database = new Database(); // Creamos una instancia de la clase Database.
        $this->conn = $database->getConnection(); // Obtenemos la conexión a la base de datos.
    }

    // Getters y Setters para los atributos.
    public function getIdProd() {
        return $this->sku; // Retornamos el ID del producto
    }

    public function setIdProd($sku) {
        $this->sku = $sku; // Asignamos el ID del producto
    }
    public function getid_emp(){
        return $this->$id_emp; // retornamos el id_emp del producto 
    }
    public function setid_emp($id_emp){
        $this->id_emp = $id_emp; // asignamos el idemp de producto
    }

    public function getNom() {
        return $this->Nombre; // Retornamos el email del producto
    }

    public function setNom($Nombre) {
        $this->Nombre = $Nombre; // Asignamos el email del producto
    }
    public function getDesc(){
        return $this->descripcion;

    }
    public function setDesc($descripcion){
        $this->descripcion = $descripcion;

    }
    public function getOferta(){
        return $this->$oferta;
    }
    public function setOferta($oferta){
        $this->oferta = $oferta;
    }
    public function getFecof(){
        return $this->$fecof;
    }
    public function setFecof($fecof){
        $this->fecof = $fecof;
    }
    public function getEstado(){
        return $this->$estado;
    }
    public function setEstado($estado){
        $this->estado = $estado;
    }
    public function getOrigen(){
        return $this->$origen;
    }
    public function setOrigen($origen){
        $this->origen = $origen;
    }

    public function getCantidad() {
        return $this->Cantidad; // 
    }

    public function setCantidad($stock) {
        $this->Cantidad = $stock; // 
    }

    public function getPrecio() {
        return $this->Precio; // 
    }

    public function setPrecio($Precio) {
        $this->Precio = $Precio; // Asignamos el número de celular del producto
    }


    

    // Método para crear un nuevo producto
    public function create() {
        // Creamos una consulta SQL para insertar un nuevo registro en la tabla de usuarios.
        $query = "INSERT INTO " . $this->table_name1 . " SET Nombre=?, descripcion=?, estado=?, origen=?, precio=?, stock=?" ;
        
        // Preparamos la consulta SQL.
        $stmt = $this->conn->prepare($query);
        
        // Unimos los valores a los parámetros de la consulta SQL.
        $stmt->bind_param("sssii", $this->Nombre,$this->descripcion,$this->estado, $this->origen,$this->Precio,$this->Cantidad);
        
        // Ejecutamos la consulta y verificamos si se ejecutó correctamente.
        if ($stmt->execute()) {
            return true; // Retornamos true si el usuario fue creado exitosamente.
        } else {
            // Manejo de errores: mostramos el error y retornamos false.
            echo "Error: " . $stmt->error;
            return false;
        }
    }
    
    // Método para leer todos los usuarios.
    public function readAll() {
        // Consulta SQL para seleccionar todos los registros de la tabla de usuarios.
        $query = "SELECT * FROM " . $this->table_name1;
        
        // Ejecutamos la consulta y almacenamos el resultado.
        $result = $this->conn->query($query);
        return $result; // Retornamos el resultado de la consulta.
    }

    // Método para leer un usuario específico por su ID.
    public function readOne() {
        // Consulta SQL para seleccionar un registro específico por ID.
        $query = "SELECT * FROM " . $this->table_name1 . " WHERE sku = ? LIMIT 0,1";
        
        // Preparamos la consulta SQL.
        $stmt = $this->conn->prepare($query);
        
        // Unimos el ID al parámetro de la consulta SQL.
        $stmt->bind_param("i", $this->sku);
        
        // Ejecutamos la consulta.
        $stmt->execute();
        
        // Obtenemos el resultado y retornamos el registro como un arreglo asociativo.
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Método para actualizar un usuario existente.
    public function update() {
        // Consulta SQL para actualizar un registro en la tabla de usuarios.
        $query = "UPDATE " . $this->table_name1 . " SET Nombre=?, descripcion=?, oferta=? ,fecof=?, estado=?, origen=?, precio=?, stock=? WHERE sku=?";
        
        // Preparamos la consulta SQL.
        $stmt = $this->conn->prepare($query);
        
        
        // Unimos los valores a los parámetros de la consulta SQL.
        $stmt->bind_param("ssidssiis", $this->Nombre,$this->descripcion,$this->oferta,$this->fecof,$this->estado,$this->origen,$this->Precio,$this->Cantidad, $this->sku);
        
        // Ejecutamos la consulta y retornamos el resultado (true si fue exitoso, false si no lo fue).
        return $stmt->execute();
    }

    // Método para eliminar un usuario por su ID.
    public function delete() {
        // Consulta SQL para eliminar un registro específico por ID.
        $query = "DELETE FROM " . $this->table_name1 . " WHERE sku = ?";
        
        // Preparamos la consulta SQL.
        $stmt = $this->conn->prepare($query);
        
        // Unimos el ID al parámetro de la consulta SQL.
        $stmt->bind_param("i", $this->sku);
        
        // Ejecutamos la consulta y retornamos el resultado (true si fue exitoso, false si no lo fue).
        return $stmt->execute();
    }
}
?>
