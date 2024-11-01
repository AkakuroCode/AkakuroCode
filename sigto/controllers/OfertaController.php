<?php
require_once __DIR__ . '/../models/Oferta.php';

class OfertaController {

    public function create($data) {
        $oferta = new Oferta();
        $oferta->setSku($data['sku']);
        $oferta->setPorcentajeOferta($data['porcentaje_oferta']);
        $oferta->setPrecioOferta($data['preciooferta']);
        $oferta->setFechaInicio($data['fecha_inicio']);
        $oferta->setFechaFin($data['fecha_fin']);

        if ($oferta->create()) {
            return ['status' => 'success', 'message' => 'Oferta creada exitosamente.'];
        } else {
            return ['status' => 'error', 'message' => 'Error al crear la oferta.'];
        }
    }

    public function readBySku($sku) {
        $oferta = new Oferta();
        $oferta->setSku($sku);
        $resultado = $oferta->readBySku();

        if ($resultado) {
            return $resultado;
        } else {
            return ['status' => 'error', 'message' => 'No se encontraron ofertas.'];
        }
    }

    public function update($data) {
        $oferta = new Oferta('write');
        $oferta->setSku($data['sku']);
        $oferta->setPorcentajeOferta($data['porcentaje_oferta']);
        $oferta->setPrecioOferta($data['preciooferta']);
        $oferta->setFechaInicio($data['fecha_inicio']);
        $oferta->setFechaFin($data['fecha_fin']);

        if ($oferta->update()) {
            return ['status' => 'success', 'message' => 'Oferta actualizada exitosamente.'];
        } else {
            return ['status' => 'error', 'message' => 'Error al actualizar la oferta.'];
        }
    }

    // Nuevo método para eliminar las ofertas relacionadas con un producto (por SKU)
    public function deleteBySku($sku) {
        $oferta = new Oferta();
        $oferta->setSku($sku);

        if ($oferta->deleteBySku()) {
            return ['status' => 'success', 'message' => 'Ofertas eliminadas exitosamente.'];
        } else {
            return ['status' => 'error', 'message' => 'Error al eliminar las ofertas.'];
        }
    }
}
?>
