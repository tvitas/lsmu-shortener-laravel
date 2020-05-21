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
            267,228,208,189,178,163,131,
            265,227,206,188,177,162,126,
            250,218,205,181,176,142,125,
            247,217,204,186,174,139,123,
            246,216,203,185,169,138,122,
            245,215,202,184,168,137,115,
            244,214,201,183,167,136,106,
            243,213,194,182,166,135,104,
            233,212,192,180,165,134,101,
            231,211,190,179,164,133,100,
            230,210,99,229,209,98,91,
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
