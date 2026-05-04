<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\Chrome\ChromeOptions;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Auto;

class ScrapeZitic extends Command
{
    protected $signature = 'scrape:zitic';
    protected $description = 'Scrape zitic.ru and save to Excel';

    public function handle()
    {
        $this->info("🚀 Seleniumga ulanmoqda...");

        $host = 'http://localhost:4444';

        // 🔥 Chrome options (CRASH FIX)
        $options = new ChromeOptions();
        $options->addArguments([
            '--start-maximized',
            '--disable-dev-shm-usage',
            '--no-sandbox',
            '--disable-gpu',
            '--disable-extensions',
        ]);

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        $driver = RemoteWebDriver::create($host, $capabilities);

        try {
            // ==== OPEN SITE ====
            $driver->get('https://zitic.ru/eo/vl/');
            $this->info("🌐 Sayt ochildi");

            $wait = new WebDriverWait($driver, 30);

            // 🔥 TABLE yuklanishini kutamiz
            $wait->until(
                WebDriverExpectedCondition::presenceOfElementLocated(
                    WebDriverBy::cssSelector('tbody tr')
                )
            );

            // 🔥 KO‘PROQ ROW kelishini kutish
            $wait->until(function () use ($driver) {
                return count($driver->findElements(WebDriverBy::cssSelector('tbody tr'))) > 50;
            });

            // ==== GET ROWS ====
            $rows = $driver->findElements(WebDriverBy::cssSelector('tbody tr'));
            $this->info("📊 Topildi: " . count($rows) . " ta row");

            // ==== EXCEL ====
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->fromArray(
                ['Plate', 'Queue', 'Date', 'Status', 'Note','Company'],
                null,
                'A1'
            );

            $rowIndex = 2;

            foreach ($rows as $row) {
                try {

                    // 🔥 SAFE SELECTORS
                    $plateEl = $row->findElements(WebDriverBy::cssSelector('.plate-number'));
                    $queueEl = $row->findElements(WebDriverBy::cssSelector('.queue-number'));
                    $dateEl = $row->findElements(WebDriverBy::cssSelector('.registration-date'));
                    $statusEl = $row->findElements(WebDriverBy::cssSelector('.status-badge'));

                    // 🔥 TEXT olish (error bermaydi)
                    $plate = isset($plateEl[0]) ? trim($plateEl[0]->getText()) : '';
                    $plate = preg_replace('/\s+/', '', $plate);
                    $queue = isset($queueEl[0]) ? trim($queueEl[0]->getText()) : '';
                    $date = isset($dateEl[0]) ? trim($dateEl[0]->getText()) : '';
                    $status = isset($statusEl[0]) ? trim($statusEl[0]->getText()) : '';

                    $auto = Auto::where('state_number', $plate)->first();
                    $company = $auto ? $auto->company_name : '';
                    // 🔥 NOTE (td orqali olish)
                    $tds = $row->findElements(WebDriverBy::tagName('td'));
                    $note = isset($tds[4]) ? trim($tds[4]->getText()) : '';

                    // 🔥 EMPTY row skip
                    if (!$plate && !$queue) {
                        continue;
                    }
                    
                    if (!preg_match('/^\d{2}(\d{3}[a-z]{3}|[a-z]\d{3}[a-z]{2})$/u', $plate)) {
                        continue;
                    }

                    // ==== WRITE ====
                    $sheet->setCellValue("A$rowIndex", $plate);
                    $sheet->setCellValue("B$rowIndex", $queue);
                    $sheet->setCellValue("C$rowIndex", $date);
                    $sheet->setCellValue("D$rowIndex", $status);
                    $sheet->setCellValue("E$rowIndex", $note);
                    $sheet->setCellValue("F$rowIndex", $company);
                    $this->line("[$rowIndex] 🚗 $plate | 🔢 $queue | 📅 $date | 📌 $status |📝 $note |🏢 $company");

                    $rowIndex++;

                    // 🔥 crash oldini oladi
                    usleep(20000);

                } catch (\Exception $e) {
                    $this->error("⚠️ Row skip: " . $e->getMessage());
                    continue;
                }
            }

            // ==== SAVE ====
            $filePath = storage_path('app/zitic.xlsx');

            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);

            $this->info("✅ Excel yozildi: " . $filePath);

        } catch (\Exception $e) {
            $this->error("❌ Xatolik: " . $e->getMessage());
        } finally {
            $driver->quit();
        }

        return Command::SUCCESS;
    }
}