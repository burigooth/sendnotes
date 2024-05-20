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
    protected static ?string $maxHeight = '220px';
    protected static ?string $heading = "Notes Liked vs Not Liked";
    
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
            'labels' => ['Liked', 'Not Liked'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    public function getDescription(): ?string
    {
        return 'The number of notes liked x not liked.';
    }
}
