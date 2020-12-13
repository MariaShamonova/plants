<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Plants;
use App\Models\PlantInfo;
use App\Models\OrdersPlants;
use Carbon\Carbon;

class DeleteRecordsPlants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeleteRecordsPlants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleted old deleted plants';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $recordsArr = Plants::where('del', '=', 'true')->get();
        foreach ($recordsArr as $record => $records) {
            $id = $record->{'id'};
            $dateTemp = $records->{'updated_at'};
            $date = Carbon::create($dateTemp);

            $now = Carbon::now()->startOfDay();
            $dateTimeObject = Carbon::parse($date)->startOfDay();
            $diff =  $dateTimeObject->diffInDays($now);
            if ($diff > 180) {
                $plantsInfoAll = PlantInfo::where('plant_id', '=', $id)->get();
                foreach ($plantsInfoAll as $plant => $plants) {
                    //Проверить нет ли действующих заказов с этим растением
                    $plantId = $plants->{'id'};
                    $order = OrdersPlants::where('plant_id', '=', $plantId)->get();
                    if (!$order || ($order && (count($order) == 0))) {
                        Plants::where('id', '=', $id)->delete();
                    }
                    
                }
            }
        }
        return 0;
    }
}