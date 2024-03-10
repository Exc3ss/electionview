<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use App\Models\Section;

class PresidentProvenceStats extends BaseWidget
{
    use HasWidgetShield;
    protected static ?int $sort = 4;
    //protected int | string | array $columnSpan = '6';


    protected function getStats(): array
    {
        $marsilioSumAQ = Section::where('provincia_id', 66)->sum('marsilio');
        $damicoSumAQ = Section::where('provincia_id', 66)->sum('damico');
        if($marsilioSumAQ+$damicoSumAQ != 0 ) {
            $totalPercentageMarsilioAQ = round(($marsilioSumAQ / ($marsilioSumAQ + $damicoSumAQ)) * 100, 2);
            $totalPercentageDamicoAQ = round(($damicoSumAQ / ($marsilioSumAQ + $damicoSumAQ)) * 100, 2);
        } else {
            $totalPercentageMarsilioAQ = 0;
            $totalPercentageDamicoAQ = 0;
        }

        $marsilioSumPE = Section::where('provincia_id', 68)->sum('marsilio');
        $damicoSumPE = Section::where('provincia_id', 68)->sum('damico');
        if($marsilioSumPE+$damicoSumPE != 0) {
            $totalPercentageMarsilioPE = round(($marsilioSumPE / ($marsilioSumPE + $damicoSumPE)) * 100, 2);
            $totalPercentageDamicoPE = round(($damicoSumPE / ($marsilioSumPE + $damicoSumPE)) * 100, 2);
        } else {
            $totalPercentageMarsilioPE = 0;
            $totalPercentageDamicoPE = 0;
        }


        $marsilioSumCH = Section::where('provincia_id', 69)->sum('marsilio');
        $damicoSumCH = Section::where('provincia_id', 69)->sum('damico');

        if($marsilioSumCH+$damicoSumCH != 0){
            $totalPercentageMarsilioCH = round(($marsilioSumCH / ($marsilioSumCH + $damicoSumCH)) * 100,2);
            $totalPercentageDamicoCH = round(($damicoSumCH / ($marsilioSumCH + $damicoSumCH)) * 100,2);
        } else {
            $totalPercentageMarsilioCH = 0;
            $totalPercentageDamicoCH = 0;
        }

        $marsilioSumTE = Section::where('provincia_id', 67)->sum('marsilio');
        $damicoSumTE = Section::where('provincia_id', 67)->sum('damico');

        if($marsilioSumTE+$damicoSumTE != 0){
            $totalPercentageMarsilioTE = round(($marsilioSumTE / ($marsilioSumTE + $damicoSumTE)) * 100,2);
            $totalPercentageDamicoTE = round(($damicoSumTE / ($marsilioSumTE + $damicoSumTE)) * 100,2);
        } else {
            $totalPercentageMarsilioTE = 0;
            $totalPercentageDamicoTE = 0;
        }

        return [
            Stat::make('Percentuali D\'Amico Prov. AQ', $totalPercentageDamicoAQ . "%")
                ->description("Marsilio: " . $totalPercentageMarsilioAQ . "%")
                ->color('warning'),
            Stat::make('Percentuali D\'Amico Prov. PE', $totalPercentageDamicoPE . "%")
                ->description("Marsilio: " . $totalPercentageMarsilioPE . "%")
                ->color('warning'),
            Stat::make('Percentuali D\'Amico Prov. CH', $totalPercentageDamicoCH . "%")
                ->description("Marsilio: " . $totalPercentageMarsilioCH . "%")
                ->color('warning'),
            Stat::make('Percentuali D\'Amico Prov. TE', $totalPercentageDamicoTE . "%")
                ->description("Marsilio: " . $totalPercentageMarsilioTE . "%")
                ->color('warning'),
        ];
    }
}
