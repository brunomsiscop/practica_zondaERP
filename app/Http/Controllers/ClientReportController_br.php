<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomerReportService_br;
use App\Exports\CustomerReportExport_br;
use Maatwebsite\Excel\Facades\Excel;

class ClientReportController_br extends Controller
{
    
    public function index()
    {
        return view('report.clients_br.index');
    }

    public function export(Request $request)
    {
        // 1. Validamos estrictamente los datos que entran desde la vista Blade
        $filters = $request->validate([
            'date_range'  => 'required|string', 
            'client_type' => 'required|in:all,new,recurrent', 
            'metrics'     => 'nullable|array' 
        ]);

        // 2. Rompemos el string "YYYY-MM-DD - YYYY-MM-DD" para obtener las dos fechas limpias
        [$startDate, $endDate] = explode(' - ', $filters['date_range']);

        // 3. Instanciamos el servicio que trabaja por bloques independientes (indestructible)
        $reportService = new CustomerReportService_br();
        
        // 4. Obtenemos la colección de clientes procesados y clasificados desde la base de datos
        $customers = $reportService->getReportData(
            $startDate, 
            $endDate, 
            $filters['client_type'], 
            $filters['metrics'] ?? []
        );

        // 5. Descargamos el reporte pasándole la colección limpia y los checkboxes seleccionados
        return Excel::download(
            new CustomerReportExport_br($customers, $filters['metrics'] ?? []), 
            'reporte_clientes_nuevos_recurrentes_br.xlsx'
        );
    }
}