<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Section;
use Illuminate\Support\Facades\DB;


class PresidentsStats extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $totaleVoti = Section::sum('votanti');
        $totalAventiDiritto = Section::sum('aventidiritto');
        $totalSchedeNulle = Section::sum('schedenulle');
        $totalSchedeBianche = Section::sum('schedebianche');
        $totalVotiMarsilio = Section::sum('marsilio');
        $totalVotiDamico = Section::sum('damico');
        $arrayMarsilioVote = $this->getDataMarsilio();
        $arrayDamicoVote = $this->getDataDAmico();
        //dd($arrayMarsilioVote);
        if($totaleVoti && $totalAventiDiritto) {
            return [
                Stat::make('MARSILIO (Cdx)', number_format(($totalVotiMarsilio / ($totalAventiDiritto - $totalSchedeNulle - $totalSchedeBianche)) * 100, 2) . "%")
                    ->description("Voti Totali ottenuti: " . $totalVotiMarsilio)
                    ->chart($arrayMarsilioVote['marsilio_values'])
                    ->color('info'),
                Stat::make('D\'AMICO (Csx)', number_format(($totalVotiDamico / ($totalAventiDiritto - $totalSchedeNulle - $totalSchedeBianche)) * 100, 2) . "%")
                    ->description("Voti Totali ottenuti: " . $totalVotiDamico)
                    ->chart($arrayDamicoVote['damico_values'])
                    ->color('danger'),
                Stat::make('Voti Totali Inseriti', $totaleVoti)
                    ->color('warning'),
            ];
        } else
            return [];
    }

    public function getDataMarsilio(): array
    {
        // Eseguiamo la query fornita
        $results = DB::table('sections')
            ->select('marsilio', 'created_at')
            ->orderBy('id')
            ->get();

        // Inizializziamo gli array per memorizzare i valori di marsilio e le date
        $marsilioValues = [];
        $dates = [];

        // Iteriamo sui risultati e popoliamo gli array
        foreach ($results as $result) {
            $marsilioValues[] = $result->marsilio;
            $dates[] = date('j/n H:i', strtotime($result->created_at));
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
            ->select('damico', 'created_at')
            ->orderBy('id')
            ->get();

        // Inizializziamo gli array per memorizzare i valori di marsilio e le date
        $damicoValues = [];
        $dates = [];

        // Iteriamo sui risultati e popoliamo gli array
        foreach ($results as $result) {
            $damicoValues[] = $result->damico;
            $dates[] = date('j/n H:i', strtotime($result->created_at));
        }

        // Costruiamo l'array finale
        $formattedResults = [
            'damico_values' => $damicoValues,
            'dates' => $dates
        ];

        return $formattedResults;
    }
}
