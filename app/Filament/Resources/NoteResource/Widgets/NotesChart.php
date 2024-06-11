<?php
namespace App\Filament\Resources\NoteResource\Widgets;

use App\Models\Note;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotesChart extends ChartWidget
{
    protected static ?string $heading = "Notas criadas.";
    protected static ?string $maxHeight = '270px';
   
    protected function getData(): array
    {
        // Use Trend para pegar os dados do banco de dados
        $trend = Trend::model(Note::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth() // Especificar a coluna 'send_date'
            ->dateColumn('send_date')
            ->count()    ;

        // Mapear os labels e os dados
        $labels = $trend->map(fn (TrendValue $value) => Carbon::parse($value->date)->shortMonthName)->all();
        $data = $trend->map(fn (TrendValue $value) => $value->aggregate)->all();

        return [
            'datasets' => [
                [
                    'label' => 'Notas criadas.',
                    'data' => $data,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getDescription(): ?string
    {
        return 'O número de notas criadas.';
    }
}
