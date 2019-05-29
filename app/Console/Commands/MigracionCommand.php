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
        
       
        //**********************************************************************************************************************//
        //***********************************************PRIMERA DOSIFICACION***************************************************//
        //**********************************************************************************************************************//
         // $this->info("Iniciando Migracion");
        // $facturas_teleferico = DB::connection('pgsql_teleferico')->table('factura')->orderBy('id_factura','ASC')->take(2108)->get();
       
        // foreach ($facturas_teleferico as $factura) {
        //     $factura_tele = DB::table('factura')->where('numero_factura',$factura->numero_factura)
        //                 ->where('id_sucursal',$factura->id_sucursal)
        //                 ->where('id_area',$factura->id_area)
        //                 ->where('id_dosificacion',$factura->id_dosificacion)->first();
        //     if ($factura_tele) {
        //         $this->info("LA FACTURA EXISTE");
        //     }else{
               
        // $cliente = DB::connection('pgsql_teleferico')->table('cliente')->where('id_cliente','=',$factura->id_cliente)->first();
        
        // $cliente_server = DB::table('cliente')->where('nit_carnet',$cliente->nit_carnet)->first();

        // if ($cliente_server) {
        //     $this->info(json_encode($cliente_server));
        //     $cantidad_articulos = DB::connection('pgsql_teleferico')->table('cantidad_articulos_factura')
        //                         ->where('id_factura','=',$factura->id_factura)->get(); 

        //     $numero_de_conjunta = DB::table('factura')->select(DB::raw('MAX(numero_conjunta) as numero_de_conjunta'))
        //                                         ->first();
        //     $this->info(json_encode($numero_de_conjunta->numero_de_conjunta));
            
        //     $factura_server = DB::table('factura')->insert(
        //                    ['id_usuario'=>100,'id_sucursal'=>$factura->id_sucursal,'id_dosificacion'=>$factura->id_dosificacion,'id_cliente'=>$cliente_server->id_cliente,'codigo_control'=>$factura->codigo_control,'estado_factura'=>$factura->estado_factura,'numero_factura'=>$factura->numero_factura,'fecha_factura'=>$factura->fecha_factura,'fechahora_aud_factura'=>$factura->fechahora_aud_factura,'numero_conjunta'=>$numero_de_conjunta->numero_de_conjunta+1,'id_area'=>8]
        //                 );
                      
        //     $ultima_factura = DB::table('factura')->where('id_cliente',$cliente_server->id_cliente)
        //                                         ->where('numero_factura',$factura->numero_factura)->where('id_sucursal',8)
        //                                         ->orderBy('id_factura','desc')->where('id_dosificacion',$factura->id_dosificacion)->orderBy('id_factura','desc')->first();
            
        //     $this->info(json_encode($ultima_factura));
        //     foreach ($cantidad_articulos as $articulo) 
        //     {
        //         $articulo_teleferico = DB::connection('pgsql_teleferico')->table('articulo')
        //                                 ->where('id_articulo','=',$articulo->id_articulo)->first();
                
        //         $articulo_server = DB::table('articulo')->where('codigo_articulo','=',$articulo_teleferico->codigo_articulo)->first();
        //         if ($articulo_server) {
        //             $this->info(json_encode($articulo_server));
                    
        //             $precio_articulo = DB::connection('pgsql_teleferico')->table('precios_articulo')
        //                                 ->where('id_precio_articulo','=',$articulo->id_precio_articulo)
        //                                 ->where('id_sucursal','=',8)->first();
        //             $precio_articulo_exist = DB::table('precios_articulo')
        //                                         ->where('id_articulo',$articulo_server->id_articulo)
        //                                         ->where('precio_articulo',$precio_articulo->precio_articulo)
        //                                         ->where('id_sucursal',8)->first();
        //             if ($precio_articulo_exist) {
                        
        //                 $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
        //                     ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$articulo_server->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$precio_articulo_exist->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
        //                 );
        //             }else{
        //                 $this->info("No existe Precio, Registrando");
        //                 $nuevo_precio = DB::table('precios_articulo')->insert(
        //                     ['id_articulo'=>$articulo_server->id_articulo,'timestamp_registro'=>$precio_articulo->timestamp_registro,'id_usuario'=>100,'precio_articulo'=>$precio_articulo->precio_articulo,'estado_precio_articulo'=>$precio_articulo->estado_precio_articulo,'id_sucursal'=>8,'observacion'=>$precio_articulo->observacion]
        //                 );
        //                 $ultimo_nuevo_precio = DB::table('precios_articulo')->where('id_sucursal',8)->where('id_articulo',$articulo_server->id_articulo)->orderBy('id_precio_articulo','desc')->first();
                        
        //                 $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
        //                     ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$articulo_server->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$ultimo_nuevo_precio->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
        //                 );
        //             }
        //         }else{
        //             $this->info("No existe El Articulo, creando uno nuevo");
        //             $nuevo_articulo = DB::table('articulo')->insert(
        //                 ['codigo_articulo'=>$articulo_teleferico->codigo_articulo,'descripcion_articulo'=>$articulo_teleferico->descripcion_articulo,'unidad_medida'=>$articulo_teleferico->unidad_medida,'cantidad_representativa'=>$articulo_teleferico->cantidad_representativa,'unidad_representativa'=>$articulo_teleferico->unidad_representativa,'id_empresa'=>$articulo_teleferico->id_empresa,'estado_articulo'=>$articulo_teleferico->estado_articulo]
        //             );
        //             $ultimo_nuevo_articulo = DB::table('articulo')->where('codigo_articulo',$articulo_teleferico->codigo_articulo)
        //                                         ->first();
        //             $precio_articulo = DB::connection('pgsql_teleferico')->table('precios_articulo')
        //                                 ->where('id_precio_articulo','=',$articulo->id_precio_articulo)
        //                                 ->where('id_sucursal','=',8)->first();
                    
        //                 $nuevo_precio = DB::table('precios_articulo')->insert(
        //                     ['id_articulo'=>$ultimo_nuevo_articulo->id_articulo,'timestamp_registro'=>$precio_articulo->timestamp_registro,'id_usuario'=>10,'precio_articulo'=>$precio_articulo->precio_articulo,'estado_precio_articulo'=>$precio_articulo->estado_precio_articulo,'id_sucursal'=>8,'observacion'=>$precio_articulo->observacion]
        //                 );

        //                 $ultimo_nuevo_precio = DB::table('precios_articulo')->where('id_articulo',$articulo_server->id_articulo)->where('id_sucursal',8)->orderBy('id_precio_articulo','desc')->first();

        //                 $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
        //                     ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$ultimo_nuevo_articulo->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$ultimo_nuevo_precio->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
        //                 );
                    
                    
        //         }
        //     }
        // }else{
        //     $this->info("No existe cliente, creando al nuevo cliente");
        //     $nuevo_cliente = DB::table('cliente')->insert(
        //         ['nit_carnet'=>$cliente->nit_carnet,'cliente'=>$cliente->cliente]
        //     );
        //     $ultimo_nuevo_cliente = DB::table('cliente')->where('nit_carnet',$cliente->nit_carnet)->first();
        //     $numero_de_conjunta = DB::table('factura')->select(DB::raw('MAX(numero_conjunta) as numero_de_conjunta'))
        //                                         ->first();
        //     $this->info(json_encode($numero_de_conjunta->numero_de_conjunta));
           
        //     $factura_server = DB::table('factura')->insert(
        //                     ['id_usuario'=>100,'id_sucursal'=>$factura->id_sucursal,'id_dosificacion'=>$factura->id_dosificacion,'id_cliente'=>$ultimo_nuevo_cliente->id_cliente,'codigo_control'=>$factura->codigo_control,'estado_factura'=>$factura->estado_factura,'numero_factura'=>$factura->numero_factura,'fecha_factura'=>$factura->fecha_factura,'fechahora_aud_factura'=>$factura->fechahora_aud_factura,'numero_conjunta'=>$numero_de_conjunta->numero_de_conjunta+1,'id_area'=>8]
        //                 );
            
        //     $ultima_factura = DB::table('factura')->where('id_cliente',$ultimo_nuevo_cliente->id_cliente)
        //                                         ->where('numero_factura',$factura->numero_factura)->where('id_sucursal',8)->where('id_dosificacion',$factura->id_dosificacion)->orderBy('id_factura','desc')->first();
            
        //     $this->info(json_encode($ultima_factura));
            
        //     $cantidad_articulos1 = DB::connection('pgsql_teleferico')->table('cantidad_articulos_factura')
        //                             ->where('id_factura','=',$factura->id_factura)->get();        
        //     foreach ($cantidad_articulos1 as $articulo) 
        //     {
        //         $articulo_teleferico = DB::connection('pgsql_teleferico')->table('articulo')
        //                                 ->where('id_articulo','=',$articulo->id_articulo)->first();
                
        //         $articulo_server = DB::table('articulo')->where('codigo_articulo','=',$articulo_teleferico->codigo_articulo)->first();
        //         if ($articulo_server) {
        //             $this->info(json_encode($articulo_server));
                    
        //             $precio_articulo = DB::connection('pgsql_teleferico')->table('precios_articulo')
        //                                 ->where('id_precio_articulo','=',$articulo->id_precio_articulo)
        //                                 ->where('id_sucursal','=',8)->first();
        //             $precio_articulo_exist = DB::table('precios_articulo')
        //                                         ->where('id_articulo',$articulo_server->id_articulo)
        //                                         ->where('precio_articulo',$precio_articulo->precio_articulo)->first();
        //             if ($precio_articulo_exist) {
                        
        //                 $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
        //                     ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$articulo_server->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$precio_articulo_exist->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
        //                 );
        //             }else{
        //                 $nuevo_precio = DB::table('precios_articulo')->insert(
        //                     ['id_articulo'=>$articulo_server->id_articulo,'timestamp_registro'=>$precio_articulo->timestamp_registro,'id_usuario'=>100,'precio_articulo'=>$precio_articulo->precio_articulo,'estado_precio_articulo'=>$precio_articulo->estado_precio_articulo,'id_sucursal'=>8,'observacion'=>$precio_articulo->observacion]
        //                 );
        //                 $ultimo_nuevo_precio = DB::table('precios_articulo')->where('id_articulo',$articulo_server->id_articulo)->where('id_sucursal',8)->orderBy('id_precio_articulo','desc')->first();
                        
        //                 $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
        //                     ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$articulo_server->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$ultimo_nuevo_precio->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
        //                 );
        //             }
        //         }else{
        //             $this->info("No existe El Articulo, creando uno nuevo");
        //             $nuevo_articulo = DB::table('articulo')->insert(
        //                 ['codigo_articulo'=>$articulo_teleferico->codigo_articulo,'descripcion_articulo'=>$articulo_teleferico->descripcion_articulo,'unidad_medida'=>$articulo_teleferico->unidad_medida,'cantidad_representativa'=>$articulo_teleferico->cantidad_representativa,'unidad_representativa'=>$articulo_teleferico->unidad_representativa,'id_empresa'=>$articulo_teleferico->id_empresa,'estado_articulo'=>$articulo_teleferico->estado_articulo]
        //             );
        //             $ultimo_nuevo_articulo = DB::table('articulo')->where('codigo_articulo',$articulo_teleferico->codigo_articulo)
        //                                         ->first();
        //             $precio_articulo = DB::connection('pgsql_teleferico')->table('precios_articulo')
        //                                 ->where('id_precio_articulo','=',$articulo->id_precio_articulo)
        //                                 ->where('id_sucursal','=',8)->first();
                    
        //                 $nuevo_precio = DB::table('precios_articulo')->insert(
        //                     ['id_articulo'=>$ultimo_nuevo_articulo->id_articulo,'timestamp_registro'=>$precios_articulo->timestamp_registro,'id_usuario'=>10,'precio_articulo'=>$precio_articulo->precio_articulo,'estado_precio_articulo'=>$precio_articulo->estado_precio_articulo,'id_sucursal'=>8,'observacion'=>$precio_articulo->observacion]
        //                 );
                        
        //                 $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
        //                     ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$ultimo_nuevo_articulo->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$nuevo_precio->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
        //                 );
                 
                    
        //         }
        //     }
        
             
        // }
        
        // $this->info("Fin Migración");

        //     }
        // }
       

       ///***********************************************************************************///
       ///*********************SEGUNDA DOSIFICACION******************************************///
       ///***********************************************************************************///
        $this->info("Iniciando Migracion");
        
        $facturas_teleferico = DB::connection('pgsql_teleferico')->table('factura')->where('id_dosificacion',19)->get();
        foreach ($facturas_teleferico as $factura) {
            $factura_tele = DB::table('factura')->where('numero_factura',$factura->numero_factura)
                        ->where('id_sucursal',$factura->id_sucursal)
                        ->where('id_area',$factura->id_area)
                        ->where('id_dosificacion',60)->first();
            if ($factura_tele) {
                $this->info("LA FACTURA NRO: ".$factura->numero_factura.", EXISTE EN LA BASE DE DATOS");
            }else{

        $cliente = DB::connection('pgsql_teleferico')->table('cliente')->where('id_cliente','=',$factura->id_cliente)->first();

        $cliente_server = DB::table('cliente')->where('nit_carnet',$cliente->nit_carnet)->first();

        if ($cliente_server) {
            $this->info(json_encode($cliente_server));
            $cantidad_articulos = DB::connection('pgsql_teleferico')->table('cantidad_articulos_factura')
                                ->where('id_factura','=',$factura->id_factura)->get(); 

            $numero_de_conjunta = DB::table('factura')->select(DB::raw('MAX(numero_conjunta) as numero_de_conjunta'))
                                                ->first();
            $this->info(json_encode($numero_de_conjunta->numero_de_conjunta));

            $factura_server = DB::table('factura')->insert(
                           ['id_usuario'=>100,'id_sucursal'=>$factura->id_sucursal,'id_dosificacion'=>60,'id_cliente'=>$cliente_server->id_cliente,'codigo_control'=>$factura->codigo_control,'estado_factura'=>$factura->estado_factura,'numero_factura'=>$factura->numero_factura,'fecha_factura'=>$factura->fecha_factura,'fechahora_aud_factura'=>$factura->fechahora_aud_factura,'numero_conjunta'=>$numero_de_conjunta->numero_de_conjunta+1,'id_area'=>8]
                        );

            $ultima_factura = DB::table('factura')->where('id_cliente',$cliente_server->id_cliente)
                                                ->where('numero_factura',$factura->numero_factura)->where('id_sucursal',8)
                                                ->orderBy('id_factura','desc')->where('id_dosificacion',60)->orderBy('id_factura','desc')->first();
            $this->info(json_encode($ultima_factura));
            foreach ($cantidad_articulos as $articulo) 
            {
                $articulo_teleferico = DB::connection('pgsql_teleferico')->table('articulo')
                                        ->where('id_articulo','=',$articulo->id_articulo)->first();

                $articulo_server = DB::table('articulo')->where('codigo_articulo','=',$articulo_teleferico->codigo_articulo)->first();
                if ($articulo_server) {
                    $this->info(json_encode($articulo_server));

                    $precio_articulo = DB::connection('pgsql_teleferico')->table('precios_articulo')
                                        ->where('id_precio_articulo','=',$articulo->id_precio_articulo)
                                        ->where('id_sucursal','=',8)->first();
                    $precio_articulo_exist = DB::table('precios_articulo')
                                                ->where('id_articulo',$articulo_server->id_articulo)
                                                ->where('precio_articulo',$precio_articulo->precio_articulo)
                                                ->where('id_sucursal',8)->first();
                    if ($precio_articulo_exist) {
                        
                        $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                            ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$articulo_server->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$precio_articulo_exist->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                        );
                    }else{
                        $this->info("No existe Precio, Registrando");
                        $nuevo_precio = DB::table('precios_articulo')->insert(
                            ['id_articulo'=>$articulo_server->id_articulo,'timestamp_registro'=>$precio_articulo->timestamp_registro,'id_usuario'=>100,'precio_articulo'=>$precio_articulo->precio_articulo,'estado_precio_articulo'=>$precio_articulo->estado_precio_articulo,'id_sucursal'=>8,'observacion'=>$precio_articulo->observacion]
                        );
                        $ultimo_nuevo_precio = DB::table('precios_articulo')->where('id_sucursal',8)->where('id_articulo',$articulo_server->id_articulo)->orderBy('id_precio_articulo','desc')->first();
                        
                        $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                            ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$articulo_server->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$ultimo_nuevo_precio->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                        );
                    }
                }else{
                    $this->info("No existe El Articulo, creando uno nuevo");
                    $nuevo_articulo = DB::table('articulo')->insert(
                        ['codigo_articulo'=>$articulo_teleferico->codigo_articulo,'descripcion_articulo'=>$articulo_teleferico->descripcion_articulo,'unidad_medida'=>$articulo_teleferico->unidad_medida,'cantidad_representativa'=>$articulo_teleferico->cantidad_representativa,'unidad_representativa'=>$articulo_teleferico->unidad_representativa,'id_empresa'=>$articulo_teleferico->id_empresa,'estado_articulo'=>$articulo_teleferico->estado_articulo]
                    );
                    $ultimo_nuevo_articulo = DB::table('articulo')->where('codigo_articulo',$articulo_teleferico->codigo_articulo)
                                                ->first();
                    $precio_articulo = DB::connection('pgsql_teleferico')->table('precios_articulo')
                                        ->where('id_precio_articulo','=',$articulo->id_precio_articulo)
                                        ->where('id_sucursal','=',8)->first();
                    
                        $nuevo_precio = DB::table('precios_articulo')->insert(
                            ['id_articulo'=>$ultimo_nuevo_articulo->id_articulo,'timestamp_registro'=>$precio_articulo->timestamp_registro,'id_usuario'=>10,'precio_articulo'=>$precio_articulo->precio_articulo,'estado_precio_articulo'=>$precio_articulo->estado_precio_articulo,'id_sucursal'=>8,'observacion'=>$precio_articulo->observacion]
                        );

                        $ultimo_nuevo_precio = DB::table('precios_articulo')->where('id_articulo',$articulo_server->id_articulo)->where('id_sucursal',8)->orderBy('id_precio_articulo','desc')->first();

                        $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                            ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$ultimo_nuevo_articulo->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$ultimo_nuevo_precio->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                        );
                    
                }
            }
        }else{
            $this->info("No existe cliente, creando al nuevo cliente");
            $nuevo_cliente = DB::table('cliente')->insert(
                ['nit_carnet'=>$cliente->nit_carnet,'cliente'=>$cliente->cliente]
            );
            $ultimo_nuevo_cliente = DB::table('cliente')->where('nit_carnet',$cliente->nit_carnet)->first();
            $numero_de_conjunta = DB::table('factura')->select(DB::raw('MAX(numero_conjunta) as numero_de_conjunta'))
                                                ->first();
            $this->info(json_encode($numero_de_conjunta->numero_de_conjunta));

            $factura_server = DB::table('factura')->insert(
                            ['id_usuario'=>100,'id_sucursal'=>$factura->id_sucursal,'id_dosificacion'=>60,'id_cliente'=>$ultimo_nuevo_cliente->id_cliente,'codigo_control'=>$factura->codigo_control,'estado_factura'=>$factura->estado_factura,'numero_factura'=>$factura->numero_factura,'fecha_factura'=>$factura->fecha_factura,'fechahora_aud_factura'=>$factura->fechahora_aud_factura,'numero_conjunta'=>$numero_de_conjunta->numero_de_conjunta+1,'id_area'=>8]
                        );

            $ultima_factura = DB::table('factura')->where('id_cliente',$ultimo_nuevo_cliente->id_cliente)
                                                ->where('numero_factura',$factura->numero_factura)->where('id_sucursal',8)->where('id_dosificacion',60)->orderBy('id_factura','desc')->first();
            $this->info(json_encode($ultima_factura));

            $cantidad_articulos1 = DB::connection('pgsql_teleferico')->table('cantidad_articulos_factura')
                                    ->where('id_factura','=',$factura->id_factura)->get();        
            foreach ($cantidad_articulos1 as $articulo) 
            {
                $articulo_teleferico = DB::connection('pgsql_teleferico')->table('articulo')
                                        ->where('id_articulo','=',$articulo->id_articulo)->first();

                $articulo_server = DB::table('articulo')->where('codigo_articulo','=',$articulo_teleferico->codigo_articulo)->first();
                if ($articulo_server) {
                    $this->info(json_encode($articulo_server));

                    $precio_articulo = DB::connection('pgsql_teleferico')->table('precios_articulo')
                                        ->where('id_precio_articulo','=',$articulo->id_precio_articulo)
                                        ->where('id_sucursal','=',8)->first();
                    $precio_articulo_exist = DB::table('precios_articulo')
                                                ->where('id_articulo',$articulo_server->id_articulo)
                                                ->where('precio_articulo',$precio_articulo->precio_articulo)->first();
                    if ($precio_articulo_exist) {
                        
                        $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                            ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$articulo_server->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$precio_articulo_exist->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                        );
                    }else{
                        $nuevo_precio = DB::table('precios_articulo')->insert(
                            ['id_articulo'=>$articulo_server->id_articulo,'timestamp_registro'=>$precio_articulo->timestamp_registro,'id_usuario'=>100,'precio_articulo'=>$precio_articulo->precio_articulo,'estado_precio_articulo'=>$precio_articulo->estado_precio_articulo,'id_sucursal'=>8,'observacion'=>$precio_articulo->observacion]
                        );
                        $ultimo_nuevo_precio = DB::table('precios_articulo')->where('id_articulo',$articulo_server->id_articulo)->where('id_sucursal',8)->orderBy('id_precio_articulo','desc')->first();
                        
                        $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                            ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$articulo_server->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$ultimo_nuevo_precio->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                        );
                    }
                }else{
                    $this->info("No existe El Articulo, creando uno nuevo");
                    $nuevo_articulo = DB::table('articulo')->insert(
                        ['codigo_articulo'=>$articulo_teleferico->codigo_articulo,'descripcion_articulo'=>$articulo_teleferico->descripcion_articulo,'unidad_medida'=>$articulo_teleferico->unidad_medida,'cantidad_representativa'=>$articulo_teleferico->cantidad_representativa,'unidad_representativa'=>$articulo_teleferico->unidad_representativa,'id_empresa'=>$articulo_teleferico->id_empresa,'estado_articulo'=>$articulo_teleferico->estado_articulo]
                    );
                    $ultimo_nuevo_articulo = DB::table('articulo')->where('codigo_articulo',$articulo_teleferico->codigo_articulo)
                                                ->first();
                    $precio_articulo = DB::connection('pgsql_teleferico')->table('precios_articulo')
                                        ->where('id_precio_articulo','=',$articulo->id_precio_articulo)
                                        ->where('id_sucursal','=',8)->first();
                    
                        $nuevo_precio = DB::table('precios_articulo')->insert(
                            ['id_articulo'=>$ultimo_nuevo_articulo->id_articulo,'timestamp_registro'=>$precios_articulo->timestamp_registro,'id_usuario'=>10,'precio_articulo'=>$precio_articulo->precio_articulo,'estado_precio_articulo'=>$precio_articulo->estado_precio_articulo,'id_sucursal'=>8,'observacion'=>$precio_articulo->observacion]
                        );
                        
                        $cantidad_factura_server = DB::table('cantidad_articulos_factura')->insert(
                            ['id_factura'=>$ultima_factura->id_factura,'id_articulo'=>$ultimo_nuevo_articulo->id_articulo,'cantidad'=>$articulo->cantidad,'id_precio_articulo'=>$nuevo_precio->id_precio_articulo,'fecha_regi'=>$articulo->fecha_regi]
                        );

                    
                }
            }
        
             
        }
        
        $this->info("Fin Migración");

            }
        }
    
    }
}
