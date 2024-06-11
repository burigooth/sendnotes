<?php

namespace App\Filament\Resources\NoteResource\Widgets;

use App\Models\Note;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LikedNotes extends ChartWidget
{
    protected static ?string $maxHeight = '270px';
    protected static ?string $heading = "Notas curtidas x notas não curtidas";
    
    protected function getData(): array
    {
        // Obter contagem de notas curtidas e não curtidas
        $likedCount = Note::where('heart_count', '>', 0)
            ->whereBetween('send_date', [now()->startOfYear(), now()->endOfYear()])
            ->count();

        $notLikedCount = Note::where('heart_count', '<=', 0)
            ->whereBetween('send_date', [now()->startOfYear(), now()->endOfYear()])
            ->count();

        // Calcular porcentagens
        $totalNotes = $likedCount + $notLikedCount;
        $likedPercentage = ($totalNotes > 0) ? ($likedCount / $totalNotes) * 100 : 0;
        $notLikedPercentage = ($totalNotes > 0) ? ($notLikedCount / $totalNotes) * 100 : 0;

        return [
            'datasets' => [
                [
                    'data' => [$likedPercentage, $notLikedPercentage],
                    'backgroundColor' => ['#E91F1F', '#333333'],
                    'borderColor' => '#333333',
                ],
            ],
            'labels' => ['Curtida', 'Não curtida'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    public function getDescription(): ?string
    {
        return 'O número de notas curtidas por não curtidas.';
    }
}
