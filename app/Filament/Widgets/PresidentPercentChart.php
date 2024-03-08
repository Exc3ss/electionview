<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class PresidentPercentChart extends ChartWidget
{
    use HasWidgetShield;
    protected static ?string $heading = 'Voti Presidenti in Percentuale (Tutto Abruzzo)';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = '2';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
