<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class PresidentPercentChart extends ChartWidget
{
    use HasWidgetShield;
    protected static ?string $heading = 'Trend Percentuale Presidenti (Tutto Abruzzo)';
    protected int | string | array $columnSpan = '2';
    protected static ?string $pollingInterval = '4s';
    protected static string $color = 'warning';
    protected static ?int $sort = 3;

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
        DB::statement("SET @csum2 := 0;");

        $results = DB::select("
            SELECT id,
                   marsilio,
                   damico,
                   updated_at,
                   cumulative_sum_marsilio,
                   cumulative_sum_damico,
                   ROUND((cumulative_sum_marsilio / (cumulative_sum_marsilio + cumulative_sum_damico)) * 100, 2) AS percentage_marsilio
            FROM ( SELECT id, marsilio, damico, updated_at, (@csum := @csum + marsilio) AS cumulative_sum_marsilio, (@csum2 := @csum2 + damico) AS cumulative_sum_damico FROM sections ORDER BY updated_at ) AS subquery;
        ");

        // Inizializziamo gli array per memorizzare i valori di cumulative_sum e le date
        $cumulativeSums = [];
        $dates = [];

        // Iteriamo sui risultati e popoliamo gli array
        foreach ($results as $result) {
            $cumulativeSums[] = $result->percentage_marsilio;
            //$dates[] = $result->created_at;
            $dates[] = date('j/n H:i', strtotime($result->updated_at));
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
        DB::statement("SET @csum2 := 0;");

        $results = DB::select("
                    SELECT
                        id,
                        marsilio,
                        damico,
                        updated_at,
                        cumulative_sum_marsilio,
                        cumulative_sum_damico,
                        ROUND((cumulative_sum_damico / (cumulative_sum_marsilio + cumulative_sum_damico)) * 100, 2) AS percentage_damico
                    FROM (
                        SELECT
                            id,
                            marsilio,
                            damico,
                            updated_at,
                            (@csum := @csum + marsilio) AS cumulative_sum_marsilio,
                            (@csum2 := @csum2 + damico) AS cumulative_sum_damico
                        FROM sections
                        ORDER BY updated_at
                    ) AS subquery;
        ");

        // Inizializziamo gli array per memorizzare i valori di cumulative_sum e le date
        $cumulativeSums = [];
        $dates = [];

        // Iteriamo sui risultati e popoliamo gli array
        foreach ($results as $result) {
            $cumulativeSums[] = $result->percentage_damico;
            $dates[] = $result->updated_at;
        }

        // Costruiamo l'array finale
        $formattedResults = [
            $cumulativeSums,
            $dates
        ];

        return $formattedResults;
    }

    /*public static function canView(): bool
    {
        return true;
    }*/
}
