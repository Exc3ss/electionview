<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class PresidentChart extends ChartWidget
{
    protected bool $enabled = false;
    protected static ?string $heading = 'Voti Presidenti (Tutto Abruzzo)';
    protected static ?string $pollingInterval = '4s';
    protected static string $color = 'warning';
    //protected int | string | array $columnSpan = 'full';


    protected function getData(): array
    {

        $dataMarsilio = $this->getDataMarsilio();
        $dataDAmico = $this->getDataDAmico();
        //dd($data2);

        return [
            'datasets' => [
                [
                    'label' => 'Marsilio',
                    'data' => $dataMarsilio[0], // [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'backgroundColor' => 'rgba(54, 162, 235, 1)', // Blu/azzurro
                    'borderColor' => 'rgba(54, 162, 235, 1)', // Blu/azzurro
                ],
                [
                    'label' => 'D\'Amico',
                    'data' => $dataDAmico[0], // [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'backgroundColor' => 'rgba(255, 0, 0, 1)', // Giallo
                    'borderColor' => 'rgba(255, 0, 0, 1)', // Giallo
                ],

            ],
            'labels' => $dataMarsilio[1], //['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getDataMarsilio(): array
    {
        // Eseguiamo la query fornita
        DB::statement("SET @csum := 0;");

        $results = DB::select("
            SELECT id, marsilio AS count, created_at, (@csum := @csum + marsilio) AS cumulative_sum
            FROM sections
            ORDER BY id;
        ");

        // Inizializziamo gli array per memorizzare i valori di cumulative_sum e le date
        $cumulativeSums = [];
        $dates = [];

        // Iteriamo sui risultati e popoliamo gli array
        foreach ($results as $result) {
            $cumulativeSums[] = $result->cumulative_sum;
            //$dates[] = $result->created_at;
            $dates[] = date('j/n H:i', strtotime($result->created_at));
        }

        // Costruiamo l'array finale
        $formattedResults = [
            $cumulativeSums,
            $dates
        ];

        return $formattedResults;
    }


    public function getDataDAmico(): array
    {
        // Eseguiamo la query fornita
        DB::statement("SET @csum := 0;");

        $results = DB::select("
                SELECT id, damico AS count, created_at, (@csum := @csum + damico) AS cumulative_sum
                FROM sections
                ORDER BY id;
            ");

        // Inizializziamo gli array per memorizzare i valori di cumulative_sum e le date
        $cumulativeSums = [];
        $dates = [];

        // Iteriamo sui risultati e popoliamo gli array
        foreach ($results as $result) {
            $cumulativeSums[] = $result->cumulative_sum;
            $dates[] = $result->created_at;
        }

        // Costruiamo l'array finale
        $formattedResults = [
            $cumulativeSums,
            $dates
        ];

        return $formattedResults;
    }

    public static function canView(): bool
    {
        return true;
    }
}
