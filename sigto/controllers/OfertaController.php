<?php
require_once __DIR__ . '/../models/Oferta.php';

class OfertaController {
    
    public function create($data) {
        $oferta = new Oferta();
        $oferta->setSku($data['sku']);
        $oferta->setPorcentajeOferta($data['oferta']);
        $oferta->setPrecioOferta($data['precio'] - ($data['precio'] * ($data['oferta'] / 100)));
        $oferta->setFechaInicio($data['fecha_inicio']);
        $oferta->setFechaFin($data['fecha_fin']);

        if ($oferta->create()) {
            return "Oferta creada exitosamente.";
        } else {
            return "Error al crear la oferta.";
        }
    }

    public function readBySku($sku) {
        $oferta = new Oferta();
        $oferta->setSku($sku);
        $resultado = $oferta->readBySku();

        if ($resultado) {
            return $resultado;
        } else {
            return "No se encontraron ofertas.";
        }
    }

    public function update($data) {
        $oferta = new Oferta();
        $oferta->setSku($data['sku']);
        $oferta->setPorcentajeOferta($data['oferta']);
        $oferta->setPrecioOferta($data['precio'] - ($data['precio'] * ($data['oferta'] / 100)));
        $oferta->setFechaInicio($data['fecha_inicio']);
        $oferta->setFechaFin($data['fecha_fin']);

        if ($oferta->update()) {
            return "Oferta actualizada exitosamente.";
        } else {
            return "Error al actualizar la oferta.";
        }
    }

    public function delete($sku) {
        $oferta = new Oferta();
        $oferta->setSku($sku);

        if ($oferta->delete()) {
            return "Oferta eliminada exitosamente.";
        } else {
            return "Error al eliminar la oferta.";
        }
    }
}
?>
