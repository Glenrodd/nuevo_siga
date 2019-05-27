<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class MigracionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roddwy:migration ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migracion de Facturas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $this->info("Iniciando Migracion");
        // FACTURA TELEFERICO
        $factura = DB::connection('pgsql_teleferico')->table('factura')->where('id_factura','=',1029)->first();
        // CLIENTE FACTURA TELEFERICO
        $cliente = DB::connection('pgsql_teleferico')->table('cliente')->where('id_cliente','=',$factura->id_cliente)->first();
        // CLIENTE FACTURA SERVER
        $cliente_server = DB::table('cliente')->where('nit_carnet',$cliente->nit_carnet)->first();

        if ($cliente_server) {
            $this->info(json_encode($cliente_server));
            $cantidad_articulos = DB::connection('pgsql_teleferico')->table('cantidad_articulos_factura')
                                ->where('id_factura','=',$factura->id_factura)->get(); 
            foreach ($cantidad_articulos as $articulo) 
            {
                $articulo_teleferico = DB::connection('pgsql_teleferico')->table('articulo')
                                        ->where('id_articulo','=',$articulo->id_articulo)->first();
                // $this->info(json_encode($articulo_teleferico));
                $articulo_server = DB::table('articulo')->where('codigo_articulo','=',$articulo_teleferico->codigo_articulo)->first();
                if ($articulo_server) {
                    $this->info(json_encode($articulo_server));
                    // CREANDO EL PRECIO DEL ARTICULO
                    $precio_articulo = DB::connection('pgsql_teleferico')->table('precios_articulo')
                                        ->where('id_precio_articulo','=',$articulo->id_precio_articulo)
                                        ->where('id_sucursal','=',8)->first();
                    $precio_articulo_exist = DB::table('precios_articulo')
                                                ->where('id_articulo',$articulo_server->id_articulo)
                                                ->where('precio_articulo',$precio_articulo->precio_articulo)
                                                ->where('id_sucursal',8)->first();
                    if ($precio_articulo_exist) {
                        $numero_de_conjunta = DB::table('factura')->select(DB::raw('MAX(numero_conjunta) as numero_de_conjunta'))
                                                ->first();
                        $this->info(json_encode($numero_de_conjunta->numero_de_conjunta));
                        $factura_server = DB::table('factura')->insert(
                            ['id_usuario'=>100,'id_sucursal'=>$factura->id_sucursal,'id_dosificacion'=>$factura->id_dosificacion,'id_cliente'=>$cliente_server->id_cliente,'codigo_control'=>$factura->codigo_control,'estado_factura'=>$factura->estado_factura,'numero_factura'=>$factura->numero_factura,'fecha_factura'=>$factura->fecha_factura,'fechahora_aud_factura'=>$factura->fechahora_aud_factura,'numero_conjunta'=>$numero_de_conjunta->numero_de_conjunta+1,'id_area'=>8]
                        );
                        
                        $ultima_factura = DB::table('factura')->where('id_cliente',$cliente_server->id_cliente)
                                                ->where('numero_factura',$factura->numero_factura)->where('id_sucursal',8)
                                                ->orderBy('id_factura','desc')->where('id_dosificacion',$factura->id_dosificacion)->orderBy('id_factura','desc')->first();
                        $this->info(json_encode($ultima_factura->id_factura));
                        // return 0;
                        $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                            ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$articulo_server->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$precio_articulo_exist->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                        );
                    }else{
                        $this->info("No existe Precio, Registrando");
                        $nuevo_precio = DB::table('precios_articulo')->insert(
                            ['id_articulo'=>$articulo_server->id_articulo,'timestamp_registro'=>$precio_articulo->timestamp_registro,'id_usuario'=>100,'precio_articulo'=>$precio_articulo->precio_articulo,'estado_precio_articulo'=>$precio_articulo->estado_precio_articulo,'id_sucursal'=>8,'observacion'=>$precio_articulo->observacion]
                        );
                        $ultimo_nuevo_precio = DB::table('precios_articulo')->where('id_sucursal',8)->where('id_articulo',$articulo_server->id_articulo)->orderBy('id_precio_articulo','desc')->first();
                        $numero_de_conjunta = DB::table('factura')->select(DB::raw('MAX(numero_conjunta) as numero_de_conjunta'))
                                                ->first();
                        $this->info(json_encode($numero_de_conjunta->numero_de_conjunta));
                        $factura_server = DB::table('factura')->insert(
                            ['id_usuario'=>100,'id_sucursal'=>$factura->id_sucursal,'id_dosificacion'=>$factura->id_dosificacion,'id_cliente'=>$cliente_server->id_cliente,'codigo_control'=>$factura->codigo_control,'estado_factura'=>$factura->estado_factura,'numero_factura'=>$factura->numero_factura,'fecha_factura'=>$factura->fecha_factura,'fechahora_aud_factura'=>$factura->fechahora_aud_factura,'numero_conjunta'=>$numero_de_conjunta->numero_de_conjunta+1,'id_area'=>8]
                        );
                        $ultima_factura = DB::table('factura')->where('id_cliente',$cliente_server->id_cliente)
                                                ->where('numero_factura',$factura->numero_factura)->where('id_sucursal',8)->where('id_dosificacion',$factura->id_dosificacion)->orderBy('id_factura','desc')->first();
                        $this->info(json_encode($ultima_factura->id_factura));
                        $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                            ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$articulo_server->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$ultimo_nuevo_precio->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                        );
                    }
                }else{
                    $this->info("No existe El Articulo, creando uno nuevo");
                    $nuevo_articulo = DB::table('articulo')->insert(
                        ['codigo_articulo'=>$articulo_teleferico->codigo_articulo,'description_articulo'=>$articulo_teleferico->description_articulo,'unidad_medida'=>$articulo_teleferico->unidad_medida,'cantidad_representativa'=>$articulo_teleferico->cantidad_representativa,'unidad_representativa'=>$articulo_teleferico->unidad_representativa,'id_empresa'=>$articulo_teleferico->id_empresa,'estado_articulo'=>$articulo_teleferico->estado_articulo]
                    );

                    $precio_articulo = DB::connection('pgsql_teleferico')->table('precios_articulo')
                                        ->where('id_precio_articulo','=',$articulo->id_precio_articulo)
                                        ->where('id_sucursal','=',8)->first();
                    // $precio_articulo_exist = DB::table('precios_articulo')
                    //                             ->where('id_articulo',$nuevo_articulo->id_articulo)
                    //                             ->where('precio_articulo',$precio_articulo->precio_articulo)->first();
                    // if ($precio_articulo_exist) {
                    //     $numero_de_conjunta = DB::table('factura')->select(DB::raw('MAX(numero_conjunta) as numero_de_conjunta'))
                    //                             ->first();
                    //     $this->info(json_encode($numero_de_conjunta->numero_de_conjunta));
                    //     $factura_server = DB::table('factura')->insert(
                    //         ['id_usuario'=>100,'id_sucursal'=>$factura->id_sucursal,'id_dosificacion'=>$factura->id_dosificacion,'id_cliente'=>$cliente_server->id_cliente,'codigo_control'=>$factura->codigo_control,'estado_factura'=>$factura->estado_factura,'numero_factura'=>$factura->numero_factura,'fecha_factura'=>$factura->fecha_factura,'fechahora_aud_factura'=>$factura->fechahora_aud_factura,'numero_conjunta'=>$numero_de_conjunta->numero_de_conjunta+1,'id_area'=>8]
                    //     );
                    //     $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                    //         ['id_factura'=>$factura_server->id_factura,'id_articulo'=>$nuevo_articulo->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$precio_articulo_exist->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                    //     );
                    // }else{
                        $nuevo_precio = DB::table('precios_articulo')->insert(
                            ['id_articulo'=>$nuevo_articulo->id_articulo,'timestamp_registro'=>$precio_articulo->timestamp_registro,'id_usuario'=>10,'precio_articulo'=>$precio_articulo->precio_articulo,'estado_precio_articulo'=>$precio_articulo->estado_precio_articulo,'id_sucursal'=>8,'observacion'=>$precio_articulo->observacion]
                        );
                        $numero_de_conjunta = DB::table('factura')->select(DB::raw('MAX(numero_conjunta) as numero_de_conjunta'))
                                                ->first();
                        $this->info(json_encode($numero_de_conjunta->numero_de_conjunta));
                        $factura_server = DB::table('factura')->insert(
                            ['id_usuario'=>100,'id_sucursal'=>$factura->id_sucursal,'id_dosificacion'=>$factura->id_dosificacion,'id_cliente'=>$cliente_server->id_cliente,'codigo_control'=>$factura->codigo_control,'estado_factura'=>$factura->estado_factura,'numero_factura'=>$factura->numero_factura,'fecha_factura'=>$factura->fecha_factura,'fechahora_aud_factura'=>$factura->fechahora_aud_factura,'numero_conjunta'=>$numero_de_conjunta->numero_de_conjunta+1,'id_area'=>8]
                        );
                        $ultima_factura = DB::table('factura')->where('id_cliente',$cliente_server->id_cliente)
                                                ->where('numero_factura',$factura->numero_factura)->where('id_dosificacion',$factura->id_dosificacion)->where('id_sucursal',8)->orderBy('id_factura','desc')->first();
                        $this->info(json_encode($ultima_factura->id_factura));
                        $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                            ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$nuevo_articulo->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$nuevo_precio->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                        );
                    // }
                    
                }
            }
        }else{
            $this->info("No existe cliente, creando al nuevo cliente");
            $nuevo_cliente = DB::table('cliente')->insert(
                ['nit_carnet'=>$cliente->nit_carnet,'cliente'=>$cliente->cliente]
            );
            $ultimo_nuevo_cliente = DB::table('cliente')->where('nit_carnet',$cliente->nit_carnet)->first();
            // ARTICULOS
            $cantidad_articulos1 = DB::connection('pgsql_teleferico')->table('cantidad_articulos_factura')
                                    ->where('id_factura','=',$factura->id_factura)->get();        
            foreach ($cantidad_articulos1 as $articulo) 
            {
                $articulo_teleferico = DB::connection('pgsql_teleferico')->table('articulo')
                                        ->where('id_articulo','=',$articulo->id_articulo)->first();
                // $this->info(json_encode($articulo_teleferico));
                $articulo_server = DB::table('articulo')->where('codigo_articulo','=',$articulo_teleferico->codigo_articulo)->first();
                if ($articulo_server) {
                    $this->info(json_encode($articulo_server));
                    // CREANDO EL PRECIO DEL ARTICULO
                    $precio_articulo = DB::connection('pgsql_teleferico')->table('precios_articulo')
                                        ->where('id_precio_articulo','=',$articulo->id_precio_articulo)
                                        ->where('id_sucursal','=',8)->first();
                    $precio_articulo_exist = DB::table('precios_articulo')
                                                ->where('id_articulo',$articulo_server->id_articulo)
                                                ->where('precio_articulo',$precio_articulo->precio_articulo)->first();
                    if ($precio_articulo_exist) {
                        $numero_de_conjunta = DB::table('factura')->select(DB::raw('MAX(numero_conjunta) as numero_de_conjunta'))
                                                ->first();
                        $this->info(json_encode($numero_de_conjunta->numero_de_conjunta));
                        $factura_server = DB::table('factura')->insert(
                            ['id_usuario'=>100,'id_sucursal'=>$factura->id_sucursal,'id_dosificacion'=>$factura->id_dosificacion,'id_cliente'=>$ultimo_nuevo_cliente->id_cliente,'codigo_control'=>$factura->codigo_control,'estado_factura'=>$factura->estado_factura,'numero_factura'=>$factura->numero_factura,'fecha_factura'=>$factura->fecha_factura,'fechahora_aud_factura'=>$factura->fechahora_aud_factura,'numero_conjunta'=>$numero_de_conjunta->numero_de_conjunta+1,'id_area'=>8]
                        );
                        $ultima_factura = DB::table('factura')->where('id_cliente',$ultimo_nuevo_cliente->id_cliente)
                                                ->where('numero_factura',$factura->numero_factura)->where('id_sucursal',8)->where('id_dosificacion',$factura->id_dosificacion)->orderBy('id_factura','desc')->first();
                        $this->info(json_encode($ultima_factura->id_factura));
                        $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                            ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$articulo_server->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$precio_articulo_exist->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                        );
                    }else{
                        $nuevo_precio = DB::table('precios_articulo')->insert(
                            ['id_articulo'=>$articulo_server->id_articulo,'timestamp_registro'=>$precio_articulo->timestamp_registro,'id_usuario'=>100,'precio_articulo'=>$precio_articulo->precio_articulo,'estado_precio_articulo'=>$precio_articulo->estado_precio_articulo,'id_sucursal'=>8,'observacion'=>$precio_articulo->observacion]
                        );
                        $ultimo_nuevo_precio = DB::table('precios_articulo')->where('id_articulo',$articulo_server->id_articulo)->where('id_sucursal',8)->orderBy('id_precio_articulo','desc')->first();
                        $numero_de_conjunta = DB::table('factura')->select(DB::raw('MAX(numero_conjunta) as numero_de_conjunta'))
                                                ->first();
                        $this->info(json_encode($numero_de_conjunta->numero_de_conjunta));
                        $factura_server = DB::table('factura')->insert(
                            ['id_usuario'=>100,'id_sucursal'=>$factura->id_sucursal,'id_dosificacion'=>$factura->id_dosificacion,'id_cliente'=>$ultimo_nuevo_cliente->id_cliente,'codigo_control'=>$factura->codigo_control,'estado_factura'=>$factura->estado_factura,'numero_factura'=>$factura->numero_factura,'fecha_factura'=>$factura->fecha_factura,'fechahora_aud_factura'=>$factura->fechahora_aud_factura,'numero_conjunta'=>$numero_de_conjunta->numero_de_conjunta+1,'id_area'=>8]
                        );
                        $ultima_factura = DB::table('factura')->where('id_cliente',$ultimo_nuevo_cliente->id_cliente)
                                                ->where('numero_factura',$factura->numero_factura)->where('id_sucursal',8)->where('id_dosificacion',$factura->id_dosificacion)->orderBy('id_factura','desc')->first();
                        $this->info(json_encode($ultima_factura->id_factura));
                        $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                            ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$articulo_server->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$ultimo_nuevo_precio->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                        );
                    }
                }else{
                    $this->info("No existe El Articulo, creando uno nuevo");
                    $nuevo_articulo = DB::table('articulo')->insert(
                        ['codigo_articulo'=>$articulo_teleferico->codigo_articulo,'description_articulo'=>$articulo_teleferico->description_articulo,'unidad_medida'=>$articulo_teleferico->unidad_medida,'cantidad_representativa'=>$articulo_teleferico->cantidad_representativa,'unidad_representativa'=>$articulo_teleferico->unidad_representativa,'id_empresa'=>$articulo_teleferico->id_empresa,'estado_articulo'=>$articulo_teleferico->estado_articulo]
                    );
                    // $ultimo_nuevo_articulo = DB::table('articulo')->
                    $precio_articulo = DB::connection('pgsql_teleferico')->table('precios_articulo')
                                        ->where('id_precio_articulo','=',$articulo->id_precio_articulo)
                                        ->where('id_sucursal','=',8)->first();
                    // $precio_articulo_exist = DB::table('precios_articulo')
                    //                             ->where('id_articulo',$nuevo_articulo->id_articulo)
                    //                             ->where('precio_articulo',$precio_articulo->precio_articulo)->first();
                    // if ($precio_articulo_exist) {
                    //     $numero_de_conjunta = DB::table('factura')->select(DB::raw('MAX(numero_conjunta) as numero_de_conjunta'))
                    //                             ->first();
                    //     $this->info(json_encode($numero_de_conjunta->numero_de_conjunta));
                    //     $factura_server = DB::table('factura')->insert(
                    //         ['id_usuario'=>100,'id_sucursal'=>$factura->id_sucursal,'id_dosificacion'=>$factura->id_dosificacion,'id_cliente'=>$ultimo_nuevo_cliente->id_cliente,'codigo_control'=>$factura->codigo_control,'estado_factura'=>$factura->estado_factura,'numero_factura'=>$factura->numero_factura,'fecha_factura'=>$factura->fecha_factura,'fechahora_aud_factura'=>$factura->fechahora_aud_factura,'numero_conjunta'=>$numero_de_conjunta->numero_de_conjunta+1,'id_area'=>8]
                    //     );
                    //     $ultima_factura = DB::table('factura')->where('id_cliente',$ultimo_nuevo_cliente->id_cliente)
                    //                             ->where('numero_factura',$factura->numero_factura)->where('id_sucursal',8)->orderBy('id_factura','desc')->first();
                    //     $this->info(json_encode($ultima_factura->id_factura));
                    //     $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                    //         ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$nuevo_articulo->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$precio_articulo_exist->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                    //     );
                    // }else{
                        $nuevo_precio = DB::table('precios_articulo')->insert(
                            ['id_articulo'=>$nuevo_articulo->id_articulo,'timestamp_registro'=>$precios_articulo->timestamp_registro,'id_usuario'=>10,'precio_articulo'=>$precio_articulo->precio_articulo,'estado_precio_articulo'=>$precio_articulo->estado_precio_articulo,'id_sucursal'=>8,'observacion'=>$precio_articulo->observacion]
                        );
                        $numero_de_conjunta = DB::table('factura')->select(DB::raw('MAX(numero_conjunta) as numero_de_conjunta'))
                                                ->first();
                        $this->info(json_encode($numero_de_conjunta->numero_de_conjunta));
                        $factura_server = DB::table('factura')->insert(
                            ['id_usuario'=>100,'id_sucursal'=>$factura->id_sucursal,'id_dosificacion'=>$factura->id_dosificacion,'id_cliente'=>$ultimo_nuevo_cliente->id_cliente,'codigo_control'=>$factura->codigo_control,'estado_factura'=>$factura->estado_factura,'numero_factura'=>$factura->numero_factura,'fecha_factura'=>$factura->fecha_factura,'fechahora_aud_factura'=>$factura->fechahora_aud_factura,'numero_conjunta'=>$numero_de_conjunta->numero_de_conjunta+1,'id_area'=>8]
                        );
                        $ultima_factura = DB::table('factura')->where('id_cliente',$ultimo_nuevo_cliente->id_cliente)
                                                ->where('numero_factura',$factura->numero_factura)->where('id_sucursal',8)->orderBy('id_factura','desc')->first();
                        $this->info(json_encode($ultima_factura->id_factura));
                        $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                            ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$nuevo_articulo->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$nuevo_precio->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                        );
                    // }
                    
                }
            }
        
             
        }
        
        $this->info("Fin Migración");
    
    }
}
