<!DOCTYPE html>
<head>
<style>
    *{
        font-family: 'helvetica';
        font-style: normal;
        font-weight: normal;
        src: url('https://fonts.gstatic.com/s/opensans/v18/mem8YaGs126MiZpBA-UFWJ0bbck.woff2') format('woff2');
    }
    .tabla-c1 {
    border-collapse: collapse;
    width: 100%;
    }

    .tabla-c1 th, .tabla-c1 td {
        border: 1px solid #626262;
        padding: 3px; 
        text-align: left;
    }

    .tabla-c1 tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .tabla-c1 tr:hover {
        background-color: #dddddd;
    }
</style>
</head>

<body>
    <div style="width: 100%; text-align:left; font-size:9pt;">
        <div>UNIVERSIDAD NACIONAL DEL ALTIPLANO</div>
        <div>VICERRECTORADO ACADÉMICO</div>
    </div>
    <div style="width: 100%; text-align:left; text-align:center; margin-top:0px;">
        <div><strong style="font-size: 11pt; font-weight:700;">EVALUACIÓN DE LA DISTRIBUCIÓN DE CARGA</strong></div>
    </div>

    <div style="margin-left: -3px;">
        <table style="width: 100%; font-size:9pt; margin-top:0px;">
            <tr>
                <td colspan="2">FACULTAD: {{ $data_escuela->facultad }} </td>
            </tr>
            <tr>
                <td>ESCUELA PROFESIONAL: {{ $data_escuela->escuela }}  </td>
                <td>PROGRAMA DE ESTUDIOS: {{ $data_escuela->programa }} </td>
            </tr>
            <tr>
                <td>AÑO Y SEMESTRE ACADÉMICO: 2024-I</td>
                <td>N° DE ESTUDIANTES MATRICULADOS: {{ $num_estudiantes }} </td>
            </tr>
        </table>
    </div>

    <div style="width: 100%; text-align:left; text-align:left; margin-top:8px; margin-bottom:8px;">
        <div><strong style="font-size: 10pt; font-weight:700;">a) CARGA ACADÉMICA DEL PROGRAMA DE ESTUDIOS</strong></div>
    </div>

    <div style="font-size: 9pt; margin-top:5px;"> <strong style="font-weight: bold;">PROGRAMACIÓN PARA CUMPLIR CON EL PLAN DE ESTUDIOS DEL PROGRAMA </strong></div>

    <table class="tabla-c1" style="width: 100%; font-size:8pt; margin-top:px;">

        <tr>
            <th style="border: 1px solid grey;" rowspan="2"><div style="font-weight: bold; text-align: center;">Ciclo </div></th>
            <th style="border: 1px solid grey;" colspan="2"><div style="font-weight: bold; text-align: center;">Grupo A </div></th>
            <th style="border: 1px solid grey;" colspan="2"><div style="font-weight: bold; text-align: center;">Grupo B </div></th>
            <th style="border: 1px solid grey;" colspan="2"><div style="font-weight: bold; text-align: center;">Grupo Unico (U) </div></th>
            <th style="border: 1px solid grey;" colspan="2"><div style="font-weight: bold; text-align: center;">Grupo C/D/E </div></th>
            <th style="border: 1px solid grey;" colspan="2"><div style="font-weight: bold; text-align: center;">Grupo Dirigido / R.E. </div></th>
        </tr>
        <tr>
            <th style="border: 1px solid grey; font-weight: bold;">N° Cursos</th>
            <th style="border: 1px solid grey; font-weight: bold;">N° Horas</th>
            <th style="border: 1px solid grey; font-weight: bold;">N° Cursos</th>
            <th style="border: 1px solid grey; font-weight: bold;">N° Horas</th>
            <th style="border: 1px solid grey; font-weight: bold;">N° Cursos</th>
            <th style="border: 1px solid grey; font-weight: bold;">N° Horas</th>
            <th style="border: 1px solid grey; font-weight: bold;">N° Cursos</th>
            <th style="border: 1px solid grey; font-weight: bold;">N° Horas</th>
            <th style="border: 1px solid grey; font-weight: bold;">N° Cursos</th>
            <th style="border: 1px solid grey; font-weight: bold;">N° Horas</th>
        </tr>

        @php
            $a_cursos = 0;
            $a_horas = 0;
            $b_cursos = 0;
            $b_horas = 0;
            $unico_cursos = 0;
            $unico_horas = 0;
            $otros_cursos = 0;
            $otros_horas = 0;
            $dirigido_cursos = 0;
            $dirigido_horas = 0;
            $tempC = 0;
            $totalcursos = 0;
            $totalhoras = 0;
        @endphp

        @foreach($data as $dato)


        <tr>
            @php
                $datoss = range(1, 10);
            @endphp
            <td><div style="text-align: center">{{ convertirARomano($dato['ciclo_valor']) }}</div></td>

            @foreach($datoss as $key=>$item)
                @if($key == 0)
                    @if(buscarLetraA( $dato['datos'], 'A') == 99 )
                        <td></td>
                    @else
                        <td><div style="text-align: center"> {{ $dato['datos'][buscarLetraA( $dato['datos'], 'A')]['num_cursos'] }} </div></td>
                        @php  $a_cursos += $dato['datos'][buscarLetraA( $dato['datos'], 'A')]['num_cursos']; @endphp
                    @endif
                @endif
                @if($key == 1)
                    @if(buscarLetraA( $dato['datos'], 'A') == 99 )
                        <td></td>
                    @else
                        <td> <div style="text-align: center"> {{ $dato['datos'][buscarLetraA( $dato['datos'], 'A')]['num_horas'] }} </div></td>
                        @php  $a_horas += $dato['datos'][buscarLetraA( $dato['datos'], 'A')]['num_horas']; @endphp
                    @endif
                @endif
                @if($key == 2)
                    @if(buscarLetraA( $dato['datos'], 'B') == 99 )
                        <td></td>
                    @else
                        <td> <div style="text-align: center"> {{ $dato['datos'][buscarLetraA( $dato['datos'], 'B')]['num_cursos'] }} </div></td>
                        @php  $b_cursos += $dato['datos'][buscarLetraA( $dato['datos'], 'B')]['num_cursos']; @endphp
                    @endif
                @endif
                @if($key == 3)
                    @if(buscarLetraA( $dato['datos'], 'B') == 99 )
                        <td></td>
                    @else
                        <td><div style="text-align: center"> {{ $dato['datos'][buscarLetraA( $dato['datos'], 'B')]['num_horas'] }} </div></td>
                        @php  $b_horas += $dato['datos'][buscarLetraA( $dato['datos'], 'B')]['num_horas']; @endphp
                    @endif
                @endif
                @if($key == 4)
                    @if(buscarLetraA( $dato['datos'], 'UNICO') == 99 )
                        <td></td>
                    @else
                        <td><div style="text-align: center"> {{ $dato['datos'][buscarLetraA( $dato['datos'], 'UNICO')]['num_cursos'] }} </div></td>
                        @php  $unico_cursos += $dato['datos'][buscarLetraA( $dato['datos'], 'UNICO')]['num_cursos']; @endphp

                    @endif
                @endif
                @if($key == 5)
                    @if(buscarLetraA( $dato['datos'], 'UNICO') == 99 )
                        <td></td>
                    @else
                        <td><div style="text-align: center"> {{ $dato['datos'][buscarLetraA( $dato['datos'], 'UNICO')]['num_horas'] }} </div></td>
                        @php  $unico_horas += $dato['datos'][buscarLetraA( $dato['datos'], 'UNICO')]['num_horas']; @endphp
                    @endif
                @endif

                @if($key == 6)
                @php
                    $letras = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                    $suma_total_cursos = 0;
                @endphp
                
                <td>
                    <div style="text-align: center">
                        @foreach($letras as $letra)
                            @php
                                $buscarLetra = buscarLetraA($dato['datos'], $letra);
                            @endphp
                
                            @if ($buscarLetra != 99)
                                @php $suma_total_cursos += $dato['datos'][$buscarLetra]['num_cursos']; @endphp
                            @endif
                        @endforeach
                        @php $otros_cursos += $suma_total_cursos; @endphp
                        {{ $suma_total_cursos }}
                    </div>
                </td>
                           

                @endif


                @if($key == 7)
                    @php
                        $letrash = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N','Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                        $suma_total_horas = 0;
                    @endphp
                    <td>
                        <div style="text-align: center">
                            @foreach($letrash as $letra)
                                @php
                                    $buscarLetra = buscarLetraA($dato['datos'], $letra);
                                @endphp
                    
                                @if ($buscarLetra != 99)
                                    @php $suma_total_horas += $dato['datos'][$buscarLetra]['num_horas']; @endphp
                                @endif
                            @endforeach
                            @php $otros_horas += $suma_total_horas; @endphp
                            {{ $suma_total_horas }}
                        </div>
                    </td>


                @endif

                    

                @if($key == 8)
                    @php
                        $buscarDIRIGIDO = buscarLetraA($dato['datos'], 'DIRIGIDO') == 99;
                        $buscarRE = buscarLetraA($dato['datos'], 'RE') == 99;
                    @endphp

                    @if($buscarDIRIGIDO != 99)
                        <td><div style="text-align: center"> {{ $dato['datos'][buscarLetraA( $dato['datos'], 'DIRIGIDO')]['num_cursos'] }} </div></td>
                        @php  $dirigido_cursos += $dato['datos'][buscarLetraA( $dato['datos'], 'DIRIGIDO')]['num_cursos']; @endphp
                    @else
                        @if($buscarRE != 99)
                            <td><div style="text-align: center"> {{ $dato['datos'][buscarLetraA( $dato['datos'], 'RE')]['num_cursos'] }} </div></td>
                            @php  $dirigido_cursos += $dato['datos'][buscarLetraA( $dato['datos'], 'RE')]['num_cursos']; @endphp
                        @else
                            <td></td>
                        @endif
                    @endif
                @endif

                @if($key == 9)
                @php
                    $buscarDIRIGIDO = buscarLetraA($dato['datos'], 'DIRIGIDO') == 99;
                    $buscarRE = buscarLetraA($dato['datos'], 'RE') == 99;
                @endphp

                @if($buscarDIRIGIDO != 99)
                    <td><div style="text-align: center"> {{ $dato['datos'][buscarLetraA( $dato['datos'], 'DIRIGIDO')]['num_horas'] }} </div></td>
                    @php  $dirigido_horas += $dato['datos'][buscarLetraA( $dato['datos'], 'DIRIGIDO')]['num_horas']; @endphp
                @else
                    @if($buscarRE != 99)
                        <td><div style="text-align: center"> {{ $dato['datos'][buscarLetraA( $dato['datos'], 'RE')]['num_horas'] }} </div></td>
                        @php  $dirigido_horas += $dato['datos'][buscarLetraA( $dato['datos'], 'RE')]['num_horas']; @endphp
                    @else
                        <td></td>
                    @endif
                @endif
            @endif


            @endforeach
        </tr>
    @endforeach

    <tr style="background: yellow;">
        <td><div style="font-weight: bold; text-align: center; ">Total</div></td>
        <td><div style="font-weight: bold; text-align: center; ">{{$a_cursos }} </div></td>
        <td><div style="font-weight: bold; text-align: center; ">{{$a_horas }} </div></td>
        <td><div style="font-weight: bold; text-align: center; ">{{$b_cursos }} </div></td>
        <td><div style="font-weight: bold; text-align: center; ">{{$b_horas }} </div></td>
        <td><div style="font-weight: bold; text-align: center; ">{{$unico_cursos }} </div></td>
        <td><div style="font-weight: bold; text-align: center; ">{{$unico_horas }} </div></td>
        <td><div style="font-weight: bold; text-align: center; ">{{$otros_cursos }} </div></td>
        <td><div style="font-weight: bold; text-align: center; ">{{$otros_horas }} </div></td>
        <td><div style="font-weight: bold; text-align: center; ">{{$dirigido_cursos }} </div></td>
        <td><div style="font-weight: bold; text-align: center; ">{{$dirigido_horas }} </div></td>
    </tr>

    </table>



    <table class="tabla-c1" style="width: 500px; font-size:8pt; margin-top:20px;">
        @php
            $totalcursos = $a_cursos + $b_cursos + $otros_cursos + $dirigido_cursos + $unico_cursos;
            $totalhoras = $a_horas + $b_horas + $otros_horas + $dirigido_horas + $unico_horas;
        @endphp

        <!-- <tr>
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">Resumen </div></th>
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">N° Cursos </div></th>
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">N° Horas</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">% Cursos</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">% Horas</div></th>
        </tr> -->


        <!-- <tr>
            <td style="border: 1px solid grey;">Cursos con un solo grupo</td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $unico_cursos }} </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $unico_horas }} </div></td>
            @if($totalcursos != 0)
                <td style="border: 1px solid grey;"> <div style="text-align: center;"> {{ round(($unico_cursos / $totalcursos) * 100, 2) }}% </div> </td>
            @else
                <td><div style="text-align: center;">0% </div></td>
            @endif
            @if($totalhoras != 0)
            <td style="border: 1px solid grey;"> <div style="text-align: center;"> {{ round(($unico_horas / $totalhoras) * 100, 2) }}% </div></td>
            @else
            <td style="border: 1px solid grey;"><div style="text-align: center;"> 0% </div></td>
            @endif
        </tr>
        <tr>
            <td style="border: 1px solid grey;">Cursos con dos grupos</td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $a_cursos + $b_cursos }} </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $a_horas + $b_horas }} </div></td>
            @if($totalcursos != 0)
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ round(( ($a_cursos + $b_cursos) / $totalcursos) * 100, 2) }}% </div></td>
            @else
            <td style="border: 1px solid grey;"><div style="text-align: center;">0%</div></td>
            @endif
            @if($totalhoras != 0)
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ round(( ($a_horas + $b_horas) / $totalhoras) * 100, 2) }}% </div></td>
            @else
            <td style="border: 1px solid grey;"><div style="text-align: center;">0%</div></td>
            @endif
        </tr>
        <tr>
            <td style="border: 1px solid grey;">Cursos con más de dos grupos</td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $otros_cursos }} </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $otros_horas }} </div></td>
            @if($totalcursos != 0)
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ round(($otros_cursos / $totalcursos) * 100, 2) }}% </div></td>
            @else
            <td style="border: 1px solid grey;"><div style="text-align: center;">0%</div></td>
            @endif
            @if($totalhoras != 0)
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ round(($otros_horas / $totalhoras) * 100, 2) }}% </div></td>
            @else
            <td style="border: 1px solid grey;"><div style="text-align: center;">0%</div></td>
            @endif
        </tr>
        <tr>
            <td style="border: 1px solid grey;">Cursos dirigdos o R.E.</td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $dirigido_cursos }} </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $dirigido_horas }} </div></td>
            @if($totalcursos != 0)
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ round(($dirigido_cursos / $totalcursos) * 100, 2) }}% </div></td>
            @else
            <td style="border: 1px solid grey;"><div style="text-align: center;">0%</div></td>
            @endif
            @if($totalhoras != 0)
            <td style="border: 1px solid grey;"> <div style="text-align: center;">{{ round(($dirigido_horas / $totalhoras) * 100, 2) }}% </div></td>
            @else
            <td style="border: 1px solid grey;"><div style="text-align: center;">0%</div></td>
            @endif
        </tr>


        <tr style="background:">
            <td style="border: 1px solid grey; font-weight: bold;">Total</td>
            <td style="border: 1px solid grey; font-weight: bold; background: yellow;"><div style="font-weight: bold; text-align: center;"> {{ $totalcursos }}</div> </td>
            <td style="border: 1px solid grey; font-weight: bold; background: yellow;"><div style="font-weight: bold; text-align: center;"> {{ $totalhoras }} </div> </td>
            <td style="border: 1px solid grey; font-weight: bold;"></td>
            <td style="border: 1px solid grey; font-weight: bold;"></td>
        </tr> -->
    </table>




    <table class="tabla-c1" style="width: 357px; font-size:8pt; margin-top:20px;">
        @php
            $totalcursosadicional = '';
            $totalhorasadicional = '';
        @endphp

        <tr>
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">PROGRAMACIÓN ADICIONAL </div></th>
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">N° Cursos </div></th>
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">N° Horas</div></th> 
        </tr>

        <tr>
            <td style="border: 1px solid grey;">Servicio a otros PE</td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $servicioaotros[0]->cantidad_cursos }} </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $servicioaotros[0]->total_horas }} </div></td>
        </tr>
        <tr>
            <td style="border: 1px solid grey;">Prácticas en hospitales</td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $practicahospitales[0]->cantidad_cursos }} </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $practicahospitales[0]->total_horas }} </div></td>
        </tr>

        <tr style="background:">
            <td style="border: 1px solid grey; font-weight: bold;">Total</td>
            <!-- <td style="border: 1px solid grey; font-weight: bold; background: yellow;"><div style="font-weight: bold; text-align: center;"> {{ $totalcursosadicional = $servicioaotros[0]->cantidad_cursos + $practicahospitales[0]->cantidad_cursos }}</div> </td> -->
            <td style="border: 1px solid grey; font-weight: bold; background: yellow;"><div style="font-weight: bold; text-align: center;"> {{ $totalcursosadicional = $servicioaotros[0]->cantidad_cursos + $practicahospitales[0]->cantidad_cursos }}</div> </td>
            <td style="border: 1px solid grey; font-weight: bold; background: yellow;"><div style="font-weight: bold; text-align: center;"> {{ $totalhorasadicional = $servicioaotros[0]->total_horas + $practicahospitales[0]->total_horas }} </div> </td>
        </tr>
    </table>




    <table class="tabla-c1" style="width: 357px; font-size:8pt; margin-top:20px;">

        <tr>
            <th style="border: 1px solid grey; width:203px;" rowspan="2"><div style="font-weight: bold; text-align: center;">TOTAL</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">N° Cursos </div></th>
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">N° Horas</div></th> 
        </tr>

        <tr style="background:">
            <td style="border: 1px solid grey; font-weight: bold; background: yellow;"><div style="font-weight: bold; text-align: center;"> {{ $totalcursos + $totalcursosadicional}}</div> </td>
            <td style="border: 1px solid grey; font-weight: bold; background: yellow;"><div style="font-weight: bold; text-align: center;"> {{ $totalhoras + $totalhorasadicional}} </div> </td>
        </tr>
    </table>


    <div style="width: 100%; text-align:left; text-align:left; margin-top:8px; margin-bottom:8px;">
        <div><strong style="font-size: 10pt; font-weight:700;">b) DISTRIBUCIÓN DE CARGA ACADÉMICA</strong></div>
    </div>

    <div style="width: 100%; text-align:left; text-align:left; margin-top:1.5rem; margin-bottom:8px;">
        <div><strong style="font-size: 9pt; font-weight:700;">i) DOCENTES ORDINARIOS</strong></div>
    </div>
    

    <div style="font-size: 8pt; margin-top:15px;">CATEGORIA PRINCIPALES</div>
    <table class="tabla-c1" style="width: 580px; font-size:8pt; ">

        <tr>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">N° Docentes </div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">Decano</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">Autoridades</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">Inv. Renacyt</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">N° Cursos</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">N° Horas</div></th>
            <th style="border: 1px solid grey;" colspan="2"><div style="font-weight:bold; text-align: center;">Promedio</div></th>
        </tr>
        <tr>
            <td style="border: 1px solid grey;">
                <div style="text-align: center;"> {{ $principales->numero_de_docentes }} </div>
            </td>
            <td style="border: 1px solid grey;"><div style=" text-align: center;"> - </div></td>
            <td style="border: 1px solid grey;"><div style=" text-align: center;"> - </div></td>
            <td style="border: 1px solid grey;"><div style=" text-align: center;"> - </div></td>
            <td style="border: 1px solid grey;"><div style=" text-align: center;"> {{ $principales->numero_de_cursos }} </div></td>
            <td style="border: 1px solid grey;"><div style=" text-align: center;"> {{ $principales->numero_de_horas }} </div></td>
            @if($principales->numero_de_docentes != 0)
                <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ round($principales->numero_de_horas / $principales->numero_de_docentes, 2) }} </div></td>
            @else
                <td>0</td>
            @endif
            <td style="border: 1px solid grey;"><div style="text-align: center;"> horas/docente </div></td>
        </tr>
    </table>


    <div style="font-size: 8pt; margin-top:15px;">CATEGORIA ASOCIADOS</div>
    <table class="tabla-c1" style="width: 580px; font-size:8pt; ">

        <tr>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">N° Docentes </div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">Decano</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">Autoridades</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">Inv. Renacyt</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">N° Cursos</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">N° Horas</div></th>
            <th style="border: 1px solid grey;" colspan="2"><div style="font-weight:bold; text-align: center;">Promedio</div></th>
        </tr>
        <tr>
            <td style="border: 1px solid grey;">
                <div style="text-align: center;"> {{ $asociados->numero_de_docentes }} </div>
            </td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> - </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> - </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> - </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $asociados->numero_de_cursos }} </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $asociados->numero_de_horas }} </div></td>
            @if ( $asociados->numero_de_docentes > 0 )
                <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ round($asociados->numero_de_horas / $asociados->numero_de_docentes,2) }} </div></td>
            @else
                <td>0</td>            
            @endif            
            
            <td style="border: 1px solid grey;"><div style="text-align: center;"> horas/docente </div></td>
        </tr>
    </table>


    <div style="font-size: 8pt; margin-top:15px;">CATEGORIA AUXILIARES</div>
    <table class="tabla-c1" style="width: 580px; font-size:8pt; ">

        <tr>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">N° Docentes </div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">Decano</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">Autoridades</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">Inv. Renacyt</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">N° Cursos</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight:bold; text-align: center;">N° Horas</div></th>
            <th style="border: 1px solid grey;" colspan="2"><div style="font-weight:bold; text-align: center;">Promedio</div></th>
        </tr>
        <tr>
            <td style="border: 1px solid grey;">
                <div style="text-align: center;"> {{ $auxiliares->numero_de_docentes }} </div>
            </td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> - </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> - </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> - </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $auxiliares->numero_de_cursos }} </div></td>
            <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ $auxiliares->numero_de_horas }} </div></td>
            @if ($auxiliares->numero_de_docentes != 0 )
                <td style="border: 1px solid grey;"><div style="text-align: center;"> {{ round($auxiliares->numero_de_horas / $auxiliares->numero_de_docentes,2) }} </div></td>
            @else
                <td>0</td>
            @endif
            <th style="border: 1px solid grey;"><div style="text-align: center;"> horas/docente </div></th>
        </tr>
    </table>



    <table class="tabla-c1" style="width: 357px; font-size:8pt; margin-top:20px;">
        @php
            $totalcursos = $a_cursos + $b_cursos + $otros_cursos + $dirigido_cursos + $unico_cursos;
            $totalhoras = $a_horas + $b_horas + $otros_horas + $dirigido_horas + $unico_horas;
        @endphp

        <tr>
            <th style="border: 1px solid grey; width:133px;" rowspan="2"><div style="font-weight: bold; text-align: center;">TOTAL</div></th>
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">N° Docentes</div></th> 
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">N° Cursos </div></th>
            <th style="border: 1px solid grey;"><div style="font-weight: bold; text-align: center;">N° Horas</div></th> 
        </tr>

        <tr style="background:">
            <td style="border: 1px solid grey; font-weight: bold; background: yellow;"><div style="font-weight: bold; text-align: center;"> 
                    {{ $principales->numero_de_docentes + $asociados->numero_de_docentes + $auxiliares->numero_de_docentes  }}
                </div>
            </td>
            <td style="border: 1px solid grey; font-weight: bold; background: yellow;"><div style="font-weight: bold; text-align: center;"> 
                {{ $principales->numero_de_cursos + $asociados->numero_de_cursos + $auxiliares->numero_de_cursos }}</div> </td>
            <td style="border: 1px solid grey; font-weight: bold; background: yellow;"><div style="font-weight: bold; text-align: center;">
                {{ $principales->numero_de_horas + $asociados->numero_de_horas + $auxiliares->numero_de_horas }}</div> </td>
            </div></td>
        </tr>
    </table>





    <div style="font-size: 8pt; margin-top:15px;">PLAZAS DE CONTRATO</div>
    <table class="tabla-c1" style="width: 440px;; font-size:8pt; ">
        @php
            $tccontrato = 0;
            $tdcontrato = 0;
            $thcontrato = 0;
        @endphp
        <tr>
            <th style="border: 1px solid grey;"><div style="text-align: center;">Contrato</div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;">N° Docentes </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;">N° Cursos</div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;">N° Horas</div></th>
            <th style="border: 1px solid grey;" colspan="2"><div style="text-align: center;">Promedio</div></th>
        </tr>
        @foreach ($plazas as $plaza )
        <tr>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> {{ $plaza->categoria }} </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> {{ $plaza->numero_de_docentes }} </div></th>  
            <th style="border: 1px solid grey;"><div style="text-align: center;"> {{ $plaza->numero_de_cursos }} </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> {{ $plaza->numero_de_horas }} </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> {{ round($plaza->numero_de_horas/$plaza->numero_de_docentes, 2) }}  </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> horas/docente </div></th>
        </tr>            
        <div style="display: none;">
            {{  $tccontrato += $plaza->numero_de_cursos; }}
            {{  $tdcontrato += $plaza->numero_de_docentes; }}
            {{  $thcontrato += $plaza->numero_de_horas; }}
        </div>
        @endforeach
        <tr>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> Total </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> {{ $tdcontrato }} </div></th>  
            <th style="border: 1px solid grey;"><div style="text-align: center;"> {{ $tccontrato }} </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> {{ $thcontrato }} </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> </div></th>
        </tr>            

    </table>


    <div style="font-size: 8pt; margin-top:15px;">DOCENTES SERVICIO</div>
    <table class="tabla-c1" style="width: 350px; font-size:8pt; ">
        <tr>
            <th style="border: 1px solid grey;"><div style="text-align: center;">N° Docentes </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;">N° Cursos</div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;">Horas por horario</div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;">Horas por curso</div></th>
        </tr>
        <tr>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> {{ $servicios->numero_de_docentes }} </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> {{ $servicios->numero_de_cursos }} </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> {{ $servicios->numero_de_horas }} </div></th>
            <th style="border: 1px solid grey;"><div style="text-align: center;"> {{ $servicios->numero_de_hcurso }} </div></th>
        </tr>
    </table>


    <table style="margin-left: -3px;  margin-top:10px;">
        <tr>
            <td style="width: 350px">
                <div style="font-size: 8pt;">DISTRIBUCION REALIZADA</div>
                <table class="tabla-c1" style="width: 280px; font-size:8pt; ">
                    <tr>
                        <th style="border: 1px solid grey;"><div style="text-align: center;">N° Cursos</div></th>
                        <th style="border: 1px solid grey;"><div style="text-align: center;">N° Horas </div></th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid grey;">
                            <div style="text-align: center;">
                                {{ $principales->numero_de_cursos + $asociados->numero_de_cursos + $auxiliares->numero_de_cursos + $tccontrato + $servicios->numero_de_cursos }}
                            </div>
                        </td>
                        <td style="border: 1px solid grey;">
                            <div style="text-align: center;">
                                {{ $principales->numero_de_horas + $asociados->numero_de_horas + $auxiliares->numero_de_horas + $thcontrato + $servicios->numero_de_horas }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 350px;">
                <div style="font-size: 8pt;">DEFICIT DE DOCENTES</div>
                <table class="tabla-c1" style="width: 280px; font-size:8pt; ">
                    <tr>
                        <th style="border: 1px solid grey;"><div style="text-align: center;">N° Cursos</div></th>
                        <th style="border: 1px solid grey;"><div style="text-align: center;">N° Horas </div></th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid grey;">
                            <div style="text-align: center;">
                                <!-- {{  $principales->numero_de_cursos + $asociados->numero_de_cursos + $auxiliares->numero_de_cursos + $tccontrato + $servicios->numero_de_cursos  }} -->
                                {{  ($totalcursos + $totalcursosadicional) - ($principales->numero_de_cursos + $asociados->numero_de_cursos + $auxiliares->numero_de_cursos + $tccontrato + $servicios->numero_de_cursos)  }}

                            </div>
                        </td>
                        <td style="border: 1px solid grey;">
                            <div style="text-align: center;">
                                <!-- {{ $totalhoras - ($principales->numero_de_horas + $asociados->numero_de_horas + $auxiliares->numero_de_horas + $thcontrato + $servicios->numero_de_horas) }} -->
                                 {{ ($totalhoras + $totalhorasadicional) - ($principales->numero_de_horas + $asociados->numero_de_horas + $auxiliares->numero_de_horas + $thcontrato + $servicios->numero_de_horas) }}
                            </div>
                        </td>
                    </tr>
                </table>

            </td>

        </tr>



    </table>



    @php
        function convertirARomano($numero)
        {
            $romanos = [
                1 => 'I',
                2 => 'II',
                3 => 'III',
                4 => 'IV',
                5 => 'V',
                6 => 'VI',
                7 => 'VII',
                8 => 'VIII',
                9 => 'IX',
                10 => 'X',
                11 => 'XI',
                12 => 'XII',
                13 => 'XII',
                14 => 'XIV'
            ];

            return $romanos[$numero];
        }


        function buscarLetraA($array, $valor_buscado)
        {
            foreach($array as $k=>$item2){
                if($item2['grupo_valor'] === $valor_buscado){
                    return $k;
                }
            }
            return 99;

        }
    @endphp


</body>