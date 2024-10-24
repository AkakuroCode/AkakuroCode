<?php
require_once __DIR__ . '/../models/Favorito.php';

class FavoritoController {

    public function actualizarFavorito() {
        // Asegúrate de enviar un header que indique que la respuesta es JSON
        header('Content-Type: application/json');
    
        if (isset($_POST['idus']) && isset($_POST['sku']) && isset($_POST['accion'])) {
            $idus = $_POST['idus'];
            $sku = $_POST['sku'];
            $accion = $_POST['accion'];
    
            if ($accion === 'agregar') {
                if ($this->addFavorito($idus, $sku)) {
                    echo json_encode(['success' => true, 'message' => 'Producto agregado a favoritos']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al agregar producto a favoritos']);
                }
            } elseif ($accion === 'quitar') {
                if ($this->removeFavorito($idus, $sku)) {
                    echo json_encode(['success' => true, 'message' => 'Producto eliminado de favoritos']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al eliminar producto de favoritos']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        }
        exit; // Importante: Salir para asegurarte de que no se envíe más contenido después del JSON
    }
    
    public function addFavorito($idus, $sku) {
        $favorito = new Favorito();
        $favorito->setIdus($idus);
        $favorito->setSku($sku);
        return $favorito->addFavorito();
    }
    
    public function removeFavorito($idus, $sku) {
        $favorito = new Favorito();
        $favorito->setIdus($idus);
        $favorito->setSku($sku);
        return $favorito->removeFavorito();
    }

    // Método para obtener los productos favoritos de un usuario
    public function getFavoritosByUser($idus) {
        $favorito = new Favorito();
        return $favorito->getFavoritosByUser($idus);
    }

    public function esFavorito($idus, $sku) {
        $favorito = new Favorito();
        $favorito->setIdus($idus);
        $favorito->setSku($sku);
        return $favorito->esFavorito($idus, $sku);
    }
}

// Llama al método correspondiente según la acción
if (isset($_GET['action']) && $_GET['action'] === 'actualizarFavorito') {
    $favoritoController = new FavoritoController();
    $favoritoController->actualizarFavorito();
}

