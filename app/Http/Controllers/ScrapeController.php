<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ScrapeController extends Controller
{
    public function run()
    {
        // Artisan commandni ishga tushiramiz
        Artisan::call('scrape:zitic');

        // output olish (xohlasang chiqarib beramiz)
        $output = Artisan::output();

        return back()->with('success', 'Scraping tugadi ✅')
                     ->with('output', $output);
    }
}