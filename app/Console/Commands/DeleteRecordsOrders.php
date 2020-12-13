<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Orders;
use App\Models\OrdersPlants;
use Carbon\Carbon;

class DeleteRecordsOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeleteRecordsOrders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old completed orders';

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
        $recordsArr = Orders::where('status_id', '=', 5)->get();

        foreach ( $recordsArr as $record => $records ) {
            $id = $record->{'id'};

            $dateTemp = $records->{'updated_at'};
            $date = Carbon::create($dateTemp);

            $now = Carbon::now()->startOfDay();
            $dateTimeObject = Carbon::parse($date)->startOfDay();
            $diff =  $dateTimeObject->diffInDays($now);
            
            if ($diff > 180) {
                Orders::where('id', '=', $id)->delete();
                OrdersPlants::where('order_id', '=', $id);
            }
        }
        
        return 0;
    }
}