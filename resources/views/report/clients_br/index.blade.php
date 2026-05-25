@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0"><i class="fas fa-file-excel me-2"></i> Reporte de Clientes Nuevos y Recurrentes</h5>
        </div>
        <div class="card-body">
            
            <form action="{{ route('reports.clients.export') }}" method="POST">
                @csrf
                
                <div class="row g-3">
                    {{-- 1. Rango de Fechas (Intervalo del PDF) --}}
                    <div class="col-md-6">
                        <label for="date_range" class="form-label fw-bold">Rango de Fechas:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            <input type="text" name="date_range" id="date_range" class="form-control" placeholder="Selecciona las fechas" required autocomplete="off">
                        </div>
                    </div>

                    {{-- 2. Tipo de Cliente (Select del PDF) --}}
                    <div class="col-md-6">
                        <label for="client_type" class="form-label fw-bold">Tipo de Cliente:</label>
                        <select name="client_type" id="client_type" class="form-select" required>
                            <option value="all">Todos los Clientes Activos</option>
                            <option value="new">Clientes Nuevos (Primera orden en el rango)</option>
                            <option value="recurrent">Clientes Recurrentes (Con historial previo)</option>
                        </select>
                    </div>
                </div>

                {{-- 3. Checkboxes de Métricas del PDF --}}
                <div class="card mt-4 bg-light border-0">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3 text-secondary"><i class="fas fa-list-check me-2"></i> Columnas Adicionales del PDF:</h6>
                        
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="metrics[]" value="inc_orders_count" id="m1" checked>
                                    <label class="form-check-label" for="m1">Cantidad de órdenes de servicio</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="metrics[]" value="inc_has_devices" id="m2">
                                    <label class="form-check-label" for="m2">Saber si cuenta con dispositivos (Sí/No)</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="metrics[]" value="inc_devices_count" id="m3">
                                    <label class="form-check-label" for="m3">Cantidad total de dispositivos</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="metrics[]" value="inc_device_types" id="m4">
                                    <label class="form-check-label" for="m4">Tipos de dispositivos asignados</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="metrics[]" value="inc_pests_count" id="m5">
                                    <label class="form-check-label" for="m5">Cantidad de plagas asociadas (e)</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="metrics[]" value="inc_pest_types" id="m6">
                                    <label class="form-check-label" for="m6">Tipos de plagas detectadas (f)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                        <i class="fas fa-file-excel me-2"></i> Exportar a Excel
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection