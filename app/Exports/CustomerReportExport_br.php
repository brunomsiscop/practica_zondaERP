<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class CustomerReportExport_br implements FromCollection, WithHeadings, WithMapping
{
    protected $customers;
    protected $metrics;

    public function __construct($customers, array $metrics)
    {
        $this->customers = $customers;
        $this->metrics   = $metrics;
    }

    public function collection()
    {
        return $this->customers;
    }

    public function headings(): array
    {
        $headers = [
            'ID del cliente.',
            'Código del cliente.',
            'Nombre comercial.',
            'Razón social.',
            'Teléfono.',
            'Correo.',
            'Fecha de alta.',
            'Fecha de primera orden.',
            'Fecha de última orden.',
            'Tipo de cliente: nuevo o recurrente.'
        ];

        if (in_array('inc_orders_count', $this->metrics)) { $headers[] = 'Cantidad de órdenes en el rango.'; }
        if (in_array('inc_has_devices', $this->metrics)) { $headers[] = 'Cuenta con dispositivos: sí/no.'; }
        if (in_array('inc_devices_count', $this->metrics)) { $headers[] = 'Cantidad de dispositivos.'; }
        if (in_array('inc_device_types', $this->metrics)) { $headers[] = 'Tipos de dispositivos.'; }
        if (in_array('inc_pests_count', $this->metrics)) { $headers[] = 'Cantidad de plagas asociadas.'; } // Checkbox e.
        if (in_array('inc_pest_types', $this->metrics)) { $headers[] = 'Plagas detectadas.'; } // Checkbox f.

        return $headers;
    }

    // Mapeo dinámico fila por fila
    public function map($customer): array
    {
        $row = [
            $customer->id,
            $customer->code,
            $customer->name,
            $customer->businessname ?? $customer->tax_name ?? 'N/A',
            $customer->tel ?? $customer->phone ?? 'N/A',
            $customer->email,
            Carbon::parse($customer->created_at)->format('Y-m-d'),
            $customer->first_order ? Carbon::parse($customer->first_order)->format('Y-m-d') : 'N/A',
            $customer->last_order ? Carbon::parse($customer->last_order)->format('Y-m-d') : 'N/A',
            $customer->calculated_type === 'new' ? 'Nuevo' : 'Recurrente'
        ];

        if (in_array('inc_orders_count', $this->metrics)) { $row[] = $customer->total_orders_in_range; }
        if (in_array('inc_has_devices', $this->metrics)) { $row[] = ($customer->devices_count > 0) ? 'Sí' : 'No'; }
        if (in_array('inc_devices_count', $this->metrics)) { $row[] = $customer->devices_count; }
        if (in_array('inc_device_types', $this->metrics)) { $row[] = $customer->device_types; }
        if (in_array('inc_pests_count', $this->metrics)) { $row[] = $customer->pests_count; } // Muestra el total numérico de plagas
        if (in_array('inc_pest_types', $this->metrics)) { $row[] = $customer->pest_types; }   // Muestra la cadena con los nombres

        return $row;
    }
}