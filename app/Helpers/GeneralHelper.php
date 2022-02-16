<?php
//app/Helpers/Envato/User.php
namespace App\Helpers;

use App\Paises;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

 
class GeneralHelper {

    public static function paises() 
    {
        return Paises::whereEnabled(true)->orderBy('nombre')->get();
    }

    public static function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }    

    public static function rankingCluster($retailId, $categoriaId) {
        $sql = "SELECT id, nombre, cantidad_dispositivos, cantidad_office,ta,target_attach,puo,if(puo > 0,((cantidad_office/puo)-1)*100,0) tco
        FROM (
        
            SELECT s.id,s.nombre,IFNULL(cantidad_dispositivos,0) cantidad_dispositivos,IFNULL(cantidad_office,0) cantidad_office,(cantidad_office/cantidad_dispositivos)*100 ta,cat_{$categoriaId}_target_attach target_attach,cat_{$categoriaId}_puo puo
            FROM (
                SELECT s.id, SUM(cantidad_dispositivos) cantidad_dispositivos, SUM(ventas_cant.cantidad) cantidad_office
                FROM ventas v
                INNER JOIN sucursales s ON v.sucursal_id = s.id
                INNER JOIN (
                    SELECT venta_id, SUM(cantidad) cantidad 
                    FROM ventas_productos vp
                    INNER JOIN productos p ON vp.producto_id = p.id
                    WHERE p.deleted_at IS NULL AND p.enabled = 1 
                    GROUP BY venta_id
                ) ventas_cant ON ventas_cant.venta_id = v.id	
                WHERE v.deleted_at IS NULL
                GROUP BY s.id
            ) interna
            RIGHT JOIN sucursales s ON s.id = interna.id 
            INNER JOIN retails r ON s.retail_id = r.id
            WHERE s.retail_id = {$retailId} AND s.categoria_cluster = {$categoriaId}
        ) aux
        ORDER BY ta DESC, cantidad_office DESC, cantidad_dispositivos DESC,nombre ASC";

        //\Log::info($sql);

        return DB::select($sql);
    }

    public static function rankingIndividual($retailId) {
        $sql = "SELECT id, nombre, cantidad_dispositivos, cantidad_office,ta,target_attach,puo,IF(puo > 0,((cantidad_office/puo)-1)*100,0) tco
        FROM (        
            SELECT s.id,s.nombre,IFNULL(cantidad_dispositivos,0) cantidad_dispositivos,IFNULL(cantidad_office,0) cantidad_office,(cantidad_office/cantidad_dispositivos)*100 ta,s.target_attach,s.piso_unidades_office puo
            FROM (
        
                SELECT s.id, SUM(cantidad_dispositivos) cantidad_dispositivos, SUM(ventas_cant.cantidad) cantidad_office
                FROM ventas v
                INNER JOIN sucursales s ON v.sucursal_id = s.id
                INNER JOIN (
                    SELECT venta_id, SUM(cantidad) cantidad 
                    FROM ventas_productos vp
                    INNER JOIN productos p ON vp.producto_id = p.id
                    WHERE p.deleted_at IS NULL AND p.enabled = 1 
                    GROUP BY venta_id
                ) ventas_cant ON ventas_cant.venta_id = v.id	
                WHERE v.deleted_at IS NULL 
                GROUP BY s.id
            ) interna
            RIGHT JOIN sucursales s ON s.id = interna.id 
            INNER JOIN retails r ON s.retail_id = r.id
            WHERE s.retail_id = {$retailId} 
        ) aux
        ORDER BY ta DESC, cantidad_office DESC, cantidad_dispositivos DESC,nombre ASC";

        return DB::select($sql);
    }

    public static function ventasPorSucursal($sucursalId) {
        $sql = "SELECT p.id,p.nombre,p.imagen,p.orden, IFNULL(aux.total,0) total
                FROM productos p
                LEFT JOIN (
                    SELECT vp.producto_id,SUM(cantidad) total
                    FROM ventas v
                    INNER JOIN ventas_productos vp ON vp.venta_id = v.id
                    WHERE v.sucursal_id = {$sucursalId}
                    AND v.deleted_at IS NULL 
                    GROUP BY vp.producto_id
                ) aux ON aux.producto_id = p.id
                WHERE p.deleted_at IS NULL AND p.enabled = 1 
                ORDER BY IFNULL(aux.total,0) DESC,p.orden";

        return DB::select($sql);
    }
}