<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Cli extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'su:patch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Patches short_user table.';

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
     * @return mixed
     */
    public function handle()
    {
        $kcUsers = [34,38,27,42,43,26,1];
        $kcShorts = [
            91, 92, 98, 99, 100, 101, 104, 106, 115, 122,
            123, 125, 126, 131, 134, 135, 136, 137, 138, 139,
            142, 462, 163, 164, 165, 166, 167, 168, 169, 174,
            177, 178, 179, 180, 181, 182, 183, 184, 185, 186,
            188, 189, 190, 192, 194, 199, 201, 202, 203, 204,
            205, 206, 208, 209, 210, 211, 212, 213, 214, 215,
            216, 217, 218, 227, 228, 229, 230, 231, 232, 233,
            243, 244, 245, 246, 247, 250, 265, 267,
        ];
        $trcUsers = [31,36,37,1];
        $trcShorts = [
            249,248,226,225,224,223,
            222,220,219,160,159,158,
            157,156,155,154,153,152,
            151,149,148,147,146,145,
        ];

        $deletes = array_merge($trcShorts, $kcShorts);
        echo "Delete...";
        foreach ($deletes as $delete) {
            DB::table('short_user')->where('short_id', '=', $delete)->delete();
        }
        echo "Insert...KC...";
        foreach ($kcUsers as $kcUser) {
            foreach ($kcShorts as $kcShort) {
                DB::table('short_user')->insert(['user_id' => $kcUser, 'short_id' => $kcShort]);
            }
        }
        echo "TRC...";
        foreach ($trcUsers as $trcUser) {
            foreach ($trcShorts as $trcShort) {
                DB::table('short_user')->insert(['user_id' => $trcUser, 'short_id' => $trcShort]);
            }
        }
        echo "Done." . PHP_EOL;
    }
}

