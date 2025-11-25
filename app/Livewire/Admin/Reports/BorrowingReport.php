<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use App\Models\BorrowingRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class BorrowingReport extends Component
{
    // Filter Variables
    public $startDate;
    public $endDate;
    public $status = 'Semua';

    public function mount()
    {
        // Default: Tanggal awal bulan ini sampai hari ini
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }

    // Fungsi Query (Dipakai di Render & Export biar konsisten)
    public function getData()
    {
        return BorrowingRequest::with(['user', 'asset'])
            ->whereBetween('created_at', [
                $this->startDate . ' 00:00:00', 
                $this->endDate . ' 23:59:59'
            ])
            ->when($this->status !== 'Semua', function($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function downloadPdf()
    {
        $data = $this->getData();

        // Load View khusus PDF (nanti kita buat di Langkah 5)
        $pdf = Pdf::loadView('pdf.borrowing_report', [
            'data' => $data,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);

        // Download file
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Laporan-Peminjaman-' . now()->timestamp . '.pdf');
    }

    public function render()
    {
        return view('livewire.admin.reports.borrowing-report', [
            'borrowings' => $this->getData()
        ])->layout('components.admin-layout');
    }
}