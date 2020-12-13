<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DataDelivery;
use App\Models\Orders;
use Carbon\Carbon;

class DeleteRecordsAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeleteRecordsAddress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old deleted records about address delivery from db';

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
        $recordsArr = DataDelivery::where('del', '=', 'true')->get();

        foreach ($recordsArr as $record => $records) {
            $id = $record->{'id'};
            $dateTemp = $records->{'updated_at'};
            $date = Carbon::create($dateTemp);

            $now = Carbon::now()->startOfDay();
            $dateTimeObject = Carbon::parse($date)->startOfDay();
            $diff =  $dateTimeObject->diffInDays($now);
            
            if ( $diff > 180 ) {
                $countOrders = Orders::where([
                    [ 'delivery_id', '=', $id ],
                    [ 'status_id', '=', 2 || 3 || 4 || 5 ]
                ])->get();
                if ($countOrders && (count($countOrders) == 0)) {
                    DataDelivery::where('id', '=', $id)->delete();
                }
                
            }
        }
        

        return 0;
    }
}