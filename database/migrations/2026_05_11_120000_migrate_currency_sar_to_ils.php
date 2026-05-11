<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $updatedCode = DB::table('settings')
            ->where('key', 'currency_code')
            ->where('value', 'SAR')
            ->update(['value' => 'ILS', 'updated_at' => now()]);

        $updatedSymbol = DB::table('settings')
            ->where('key', 'currency_symbol')
            ->whereIn('value', ['ر.س', 'SAR'])
            ->update(['value' => '₪', 'updated_at' => now()]);

        if ($updatedCode || $updatedSymbol) {
            Cache::forget('setting.currency_code');
            Cache::forget('setting.currency_symbol');
        }
    }

    public function down(): void
    {
        DB::table('settings')
            ->where('key', 'currency_code')
            ->where('value', 'ILS')
            ->update(['value' => 'SAR', 'updated_at' => now()]);

        DB::table('settings')
            ->where('key', 'currency_symbol')
            ->where('value', '₪')
            ->update(['value' => 'ر.س', 'updated_at' => now()]);

        Cache::forget('setting.currency_code');
        Cache::forget('setting.currency_symbol');
    }
};
