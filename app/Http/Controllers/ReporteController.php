<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;

class ReporteController extends Controller
{
    public function generatePDF($p)
    {
        $datos = DB::select("WITH cursos_filtrados AS (
            SELECT *
            FROM cursos
            WHERE prog_id IN ($p) and cursos.tipo_alter_salud = 0
        )
        SELECT 
            grupos_y_ciclos.grupo_valor,
            ciclos.ciclo_valor,
            IFNULL(count1, 0) AS num_cursos,
            CASE 
                WHEN grupos_y_ciclos.grupo_valor IN ('DIRIGIDO', 'RE') THEN IFNULL(count2 * 0.5, 0)
                ELSE IFNULL(count2, 0)
            END AS num_horas
        FROM 
            (SELECT 'A' as grupo_valor UNION ALL
            SELECT 'B' UNION ALL
            SELECT 'C' UNION ALL
            SELECT 'D' UNION ALL
            SELECT 'E' UNION ALL
            SELECT 'F' UNION ALL
            SELECT 'G' UNION ALL
            SELECT 'H' UNION ALL
            SELECT 'I' UNION ALL
            SELECT 'J' UNION ALL
            SELECT 'K' UNION ALL
            SELECT 'L' UNION ALL
            SELECT 'M' UNION ALL
            SELECT 'N' UNION ALL
            SELECT 'Ñ' UNION ALL
            SELECT 'O' UNION ALL
            SELECT 'P' UNION ALL
            SELECT 'Q' UNION ALL
            SELECT 'R' UNION ALL
            SELECT 'S' UNION ALL
            SELECT 'T' UNION ALL
            SELECT 'U' UNION ALL
            SELECT 'V' UNION ALL
            SELECT 'W' UNION ALL
            SELECT 'X' UNION ALL
            SELECT 'Y' UNION ALL
            SELECT 'Z' UNION ALL
            SELECT 'DIRIGIDO' UNION ALL
            SELECT 'RE' UNION ALL
            SELECT 'UNICO') AS grupos_y_ciclos
        CROSS JOIN
            (SELECT 1 as ciclo_valor UNION ALL
            SELECT 2 UNION ALL
            SELECT 3 UNION ALL
            SELECT 4 UNION ALL
            SELECT 5 UNION ALL
            SELECT 6 UNION ALL
            SELECT 7 UNION ALL
            SELECT 8 UNION ALL
            SELECT 9 UNION ALL
            SELECT 10 UNION ALL
            SELECT 11 UNION ALL
            SELECT 12 UNION ALL
            SELECT 13 UNION ALL
            SELECT 14) AS ciclos
        LEFT JOIN
            (SELECT 
                g.grupo AS grupo_valor,
                c.curso_ciclo AS ciclo_valor,
                COUNT(*) AS count1
            FROM 
                cursos_filtrados c
            INNER JOIN 
                grupo g ON c.curso_id=g.curso_id
            INNER JOIN 
                grupo_curso gc ON g.grupo_id=gc.cursogc_id
            INNER JOIN 
                program p ON c.prog_id = p.prog_id
            GROUP BY 
                g.grupo, c.curso_ciclo) AS count1_table 
        ON 
            grupos_y_ciclos.grupo_valor = count1_table.grupo_valor
            AND ciclos.ciclo_valor = count1_table.ciclo_valor
        LEFT JOIN
            (SELECT g.grupo AS grupo_valor,
                c.curso_ciclo AS ciclo_valor,
                SUM(c.curso_totalh) AS count2
            FROM 
                cursos_filtrados c
            INNER JOIN 
                grupo g ON c.curso_id = g.curso_id
            INNER JOIN 
                grupo_curso gc ON g.grupo_id = gc.cursogc_id
            INNER JOIN 
                program p ON c.prog_id = p.prog_id
            GROUP BY 
                g.grupo, c.curso_ciclo) AS count2_table 
        ON 
            grupos_y_ciclos.grupo_valor = count2_table.grupo_valor
            AND ciclos.ciclo_valor = count2_table.ciclo_valor
        WHERE
            count1 IS NOT NULL OR count2 IS NOT NULL
        ORDER BY ciclo_valor;");

        $data = [];
        $data_escuela = [];

        $reses = DB::select("SELECT p.prog_id, p.programa, p.facultad, p.escuela FROM program p WHERE p.prog_id = $p");
        if(count($reses) > 0 ){
            $data_escuela = $reses[0];
        }

        $num_estudiantes = DB::table('grupo_curso')->where('gc_prog_id', '=', $p)->sum('gc_alumnos');

        foreach ($datos as $dato) {
            $ciclo_valor = $dato->ciclo_valor;

            $indice = array_search($ciclo_valor, array_column($data, 'ciclo_valor'));
    
            if ($indice === false) {
                $data[] = [
                    "ciclo_valor" => $ciclo_valor,
                    "datos" => [
                        [
                            "grupo_valor" => $dato->grupo_valor,
                            "num_cursos" => $dato->num_cursos,
                            "num_horas" => $dato->num_horas
                        ]
                    ]
                ];
            } else {
                // Si el ciclo_valor ya existe, agregar datos al objeto existente
                $data[$indice]["datos"][] = [
                    "grupo_valor" => $dato->grupo_valor,
                    "num_cursos" => $dato->num_cursos,
                    "num_horas" => $dato->num_horas
                ];
            }
        }
    

        $principales = $this->getDocentes($p, 'PRIN');
        $asociados = $this->getDocentes($p, 'ASOC');
        $auxiliares = $this->getDocentes($p, 'AUX');
        $servicios = [];
        // return $data;

        // $ser = DB::select("SELECT 	
        // COUNT(DISTINCT mc.doc_dni) AS numero_de_docentes,
        // COUNT(DISTINCT mc.curso_id, mc.grupo) AS numero_de_cursos,
        // SUM(mc.hxh) AS numero_de_horas,
        // SUM(mc.curso_totalh) AS numero_de_hcurso
        // FROM   (SELECT d.doc_dni, c.curso_id, g.grupo, hxh ,c.curso_totalh, d.prog_id AS progdoc, c.prog_id AS progcurso
        //         FROM docente_curso dc
        //         INNER JOIN grupo_curso gc ON gc.gc_id = dc.cursodc_id
        //         INNER JOIN grupo g ON g.grupo_id = gc.cursogc_id 
        //         INNER JOIN cursos c ON c.curso_id = g.curso_id
        //         INNER JOIN docentes d ON d.docente_id = dc.docente_id 
        //         INNER JOIN program p ON p.prog_id = c.prog_id
        //         INNER JOIN program pd ON pd.prog_id = d.prog_id
        //         INNER JOIN (
        //             SELECT gch_id, COUNT(*) AS hxh
        //             FROM horario
        //             GROUP BY horario.gch_id
        //         ) AS hxh ON hxh.gch_id = gc.gc_id
        //         ) as mc WHERE mc.progdoc != $p AND mc.progcurso=$p");
        // if(count($ser) > 0){ $servicios = $ser[0]; }



// inicio  cuadro 2 programacion adicional //////   /////
        $ser = DB::select("SELECT 	
        COUNT(DISTINCT mc.doc_dni) AS numero_de_docentes,
        COUNT(DISTINCT mc.curso_id, mc.grupo) AS numero_de_cursos,
        COUNT(DISTINCT mc.curso_id, mc.grupo) AS numero_de_hcurso,
         SUM(
            CASE 
                WHEN mc.grupo IN ('DIRIGIDO', 'RE') THEN mc.curso_totalh * 0.5
                ELSE mc.curso_totalh
            END
        ) AS numero_de_horas
    
    FROM   (
        SELECT 
            d.doc_dni, 
            c.curso_id, 
            g.grupo, 
            c.curso_totalh, 
            d.prog_id AS progdoc, 
            c.prog_id AS progcurso,
            c.tipo_alter_salud
        FROM docente_curso dc
        INNER JOIN grupo_curso gc ON gc.gc_id = dc.cursodc_id
        INNER JOIN grupo g ON g.grupo_id = gc.cursogc_id 
        INNER JOIN cursos c ON c.curso_id = g.curso_id
        INNER JOIN docentes d ON d.docente_id = dc.docente_id 
        INNER JOIN program p ON p.prog_id = c.prog_id
        INNER JOIN program pd ON pd.prog_id = d.prog_id
    ) as mc 
    WHERE mc.progdoc != $p AND mc.progcurso = $p AND mc.tipo_alter_salud = 0");
        if(count($ser) > 0){ $servicios = $ser[0]; }
// cuadro 2 programacion adicional fin // //////////
        $plazas = DB::select("  SELECT 
               
        d.categoria,
        COUNT(DISTINCT d.docente_id) AS numero_de_docentes,
        COUNT(DISTINCT c.curso_id, g.grupo) AS numero_de_cursos,
        SUM(
            CASE 
                WHEN g.grupo IN ('DIRIGIDO', 'RE') THEN c.curso_totalh * 0.5
                ELSE c.curso_totalh
            END
        ) AS numero_de_horas
        FROM docentes d
        INNER JOIN docente_curso dc ON d.docente_id = dc.docente_id
        INNER JOIN grupo_curso gc ON dc.cursodc_id = gc.gc_id
        INNER JOIN grupo g ON gc.cursogc_id = g.grupo_id
        INNER JOIN cursos c ON g.curso_id = c.curso_id
        INNER JOIN program p ON p.prog_id = c.prog_id
        INNER JOIN program pd ON pd.prog_id = d.prog_id  
        
        WHERE  d.prog_id = $p AND d.doc_nombres NOT LIKE'CT%' AND  d.categoria IN ('A1','A2','B1','B2','B3')
        GROUP BY d.categoria 
        ORDER BY CASE WHEN d.categoria LIKE 'B%' THEN 1 ELSE 2 END, d.categoria;");

        $servicioaotros = DB::select("SELECT
        COUNT(c.curso_codigo) AS cantidad_cursos,
        COALESCE(
            SUM(
                CASE 
                    WHEN g.grupo IN ('DIRIGIDO', 'RE') THEN c.curso_totalh * 0.5
                    ELSE c.curso_totalh
                END
            ), 
            0
        ) AS total_horas
    FROM 
        docente_curso dc
    INNER JOIN 
        grupo_curso gc ON gc.gc_id = dc.cursodc_id
    INNER JOIN 
        grupo g ON g.grupo_id = gc.cursogc_id 
    INNER JOIN 
        cursos c ON c.curso_id = g.curso_id
    INNER JOIN 
        docentes d ON d.docente_id = dc.docente_id 
    INNER JOIN 
        program p ON p.prog_id = c.prog_id
    INNER JOIN 
        program pd ON pd.prog_id = d.prog_id  
    WHERE 
        d.prog_id = $p AND c.prog_id != $p;");

        $practicahospitales = DB::select(" SELECT 
        COALESCE(COUNT(c.curso_id), 0) AS cantidad_cursos,
        COALESCE(SUM(c.curso_totalh), 0) AS total_horas
    FROM 
        grupo_curso gc
    INNER JOIN 
        grupo g ON gc.cursogc_id = g.grupo_id
    INNER JOIN 
        cursos c ON g.curso_id = c.curso_id 
    WHERE 
        c.prog_id = $p AND c.tipo_alter_salud = 1;");

        // asignacion presupuestal

$apt = DB::select("SELECT         
d.categoria,
COUNT(DISTINCT d.docente_id) AS numero_de_docentes,
COUNT(DISTINCT c.curso_id, g.grupo) AS numero_de_cursos,
SUM(
            CASE 
                WHEN g.grupo IN ('DIRIGIDO', 'RE') THEN c.curso_totalh * 0.5
                ELSE c.curso_totalh
            END
        ) AS numero_de_horas
FROM docentes d
INNER JOIN docente_curso dc ON d.docente_id = dc.docente_id
INNER JOIN grupo_curso gc ON dc.cursodc_id = gc.gc_id
INNER JOIN grupo g ON gc.cursogc_id = g.grupo_id
INNER JOIN cursos c ON g.curso_id = c.curso_id
INNER JOIN program p ON p.prog_id = c.prog_id
INNER JOIN program pd ON pd.prog_id = d.prog_id  
WHERE  d.prog_id = $p AND d.doc_nombres LIKE'CT%' AND  d.categoria IN ('A1','A2','B1','B2','B3')
GROUP BY d.categoria 
ORDER BY CASE WHEN d.categoria LIKE 'B%' THEN 1 ELSE 2 END, d.categoria;");

// sin apt


        // $pdf = PDF::loadView('pdf.template', compact('data','principales','asociados','auxiliares','plazas','servicios','data_escuela','num_estudiantes','servicioaotros','practicahospitales','apt'));
        // return $pdf->stream('pdf_example.pdf');


        $pdf = PDF::loadView('pdf.template', compact('data','principales','asociados','auxiliares','plazas','servicios','data_escuela','num_estudiantes','servicioaotros','practicahospitales','apt'));
        return $pdf->stream('reporte_' . $p . '.pdf');
        

        
    }

    public function getDocentes($pro, $tipo){
    
        $respuesta = DB::select("SELECT 
        COUNT(DISTINCT dc.docente_id) AS numero_de_docentes,
        COUNT(DISTINCT c.curso_id,g.grupo) AS numero_de_cursos,
        SUM(
            CASE 
                WHEN g.grupo IN ('DIRIGIDO', 'RE') THEN c.curso_totalh * 0.5
                ELSE c.curso_totalh
            END
        ) AS numero_de_horas
    FROM docentes d
    INNER JOIN docente_curso dc ON d.docente_id = dc.docente_id
    INNER JOIN grupo_curso gc ON dc.cursodc_id = gc.gc_id
    INNER JOIN grupo g ON gc.cursogc_id = g.grupo_id
    INNER JOIN cursos c ON g.curso_id = c.curso_id
    WHERE d.prog_id = $pro
                AND d.dedicacion LIKE '".$tipo."%'");

        if(count($respuesta) > 0){
            return $respuesta[0];
        }else{
            $respuesta = [];
        }

    }


}

