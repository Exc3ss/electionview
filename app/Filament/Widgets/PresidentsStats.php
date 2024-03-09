<?php

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Section;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;


class PresidentsStats extends BaseWidget
{
    use HasWidgetShield;
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $elettori = Setting::where('key', 'elettori')->first();
        $votanti = Setting::where('key', 'votanti')->first();

        if ($elettori && $elettori->value != 0) {
            $elettoriMinistero = $elettori->value;
        } elseif (!($elettori->value)) {
            $elettoriMinistero = 1;
        }

        if($votanti && $votanti->value != 0){
            $votantiMinistero = $votanti->value;
        } elseif (!($votanti->value)) {
            $votantiMinistero = 1;
        }



        $totaleVoti = (Section::sum('marsilio'))+(Section::sum('damico'));
        $totalAventiDiritto = Section::sum('aventidiritto');
        $totalSchedeNulle = Section::sum('schedenulle');
        $totalSchedeBianche = Section::sum('schedebianche');
        $totalVotiMarsilio = Section::sum('marsilio');
        $totalVotiDamico = Section::sum('damico');
        $arrayMarsilioVote = $this->getDataMarsilio();
        $arrayDamicoVote = $this->getDataDAmico();
        //dd($arrayMarsilioVote,$arrayDamicoVote);

        if($totalVotiMarsilio && $totalVotiDamico) {
            return [
                Stat::make('MARSILIO (Cdx)', number_format(($totalVotiMarsilio / ($totalVotiDamico+$totalVotiMarsilio)) * 100, 2) . "%")
                    ->description("Voti Totali ottenuti: " . $totalVotiMarsilio)
                    ->chart($arrayMarsilioVote['marsilio_values'])
                    ->color('info'),
                Stat::make('D\'AMICO (Csx)', number_format(($totalVotiDamico / ($totalVotiDamico + $totalVotiMarsilio)) * 100, 2) . "%")
                    ->description("Voti Totali ottenuti: " . $totalVotiDamico)
                    ->chart($arrayDamicoVote['damico_values'])
                    ->color('danger'),
                Stat::make('Dato Affluenza (Fonte: MINT): ', round(($votantiMinistero/$elettoriMinistero)*100,2)  . "%")
                    ->description('Scrutini Inseriti: ' . $totaleVoti . " " . round (($totaleVoti / $votantiMinistero)*100,2)   . "% del totale")
                    ->color('warning'),
            ];
        } else
            return [
                Stat::make('Dato Affluenza (Fonte: MINT): ', round(($votantiMinistero/$elettoriMinistero)*100,2)  . "%")
                    ->description('Scrutini Inseriti: ' . $totaleVoti . " " . round (($totaleVoti / $votantiMinistero)*100,2)   . "% del totale")
                    ->color('warning'),
            ];
    }

    public function getDataMarsilio(): array
    {
        // Eseguiamo la query fornita
        $results = DB::table('sections')
            ->select('marsilio', 'created_at', 'updated_at')
            ->orderBy('updated_at')
            ->get();

        // Inizializziamo gli array per memorizzare i valori di marsilio e le date
        $marsilioValues = [];
        $dates = [];

        // Iteriamo sui risultati e popoliamo gli array
        foreach ($results as $result) {
            $marsilioValues[] = $result->marsilio;
            $dates[] = date('j/n H:i', strtotime($result->updated_at));
        }

        // Costruiamo l'array finale
        $formattedResults = [
            'marsilio_values' => $marsilioValues,
            'dates' => $dates
        ];

        return $formattedResults;
    }

    public function getDataDAmico(): array
    {
        // Eseguiamo la query fornita
        $results = DB::table('sections')
            ->select('damico', 'created_at','updated_at')
            ->orderBy('updated_at')
            ->get();

        // Inizializziamo gli array per memorizzare i valori di marsilio e le date
        $damicoValues = [];
        $dates = [];

        // Iteriamo sui risultati e popoliamo gli array
        foreach ($results as $result) {
            $damicoValues[] = $result->damico;
            $dates[] = date('j/n H:i', strtotime($result->updated_at));
        }

        // Costruiamo l'array finale
        $formattedResults = [
            'damico_values' => $damicoValues,
            'dates' => $dates
        ];

        return $formattedResults;
    }
}
