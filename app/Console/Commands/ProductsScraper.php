<?php

namespace App\Console\Commands;

use App\Models\Market;
use App\Traits\ValidatesCommandInputs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class ProductsScraper extends Command
{
    use ValidatesCommandInputs;

    protected $signature = 'app:products-scraper {market} {--skip-scraper} {--skip-save}';
    protected $description = 'Scrape products from all stores and save them to the database';


    public function handle(): void
    {
        $this->validateInputs();
        $this->scrapeProducts();
        $this->saveProducts();
    }

    private function validateInputs(): void
    {
        $this->validate(
            argumentRules: ['market' => ['required', 'in:bistek,supermercado-koch']],
            optionRules: [
                'skip-scraper' => ['nullable', 'boolean'],
                'skip-save' => ['nullable', 'boolean'],
            ]);

    }

    private function scrapeProducts(): void
    {
        if ($this->option('skip-scraper')) {
            $this->info('Skipping scraper');
            return;
        }

        $this->info('Running scraper');

        $market = $this->argument('market');
        $processResult = Process::forever()->run("npm run scraper:$market");

        if ($processResult->successful()) {
            $this->info('Scraper finished successfully');
        } else {
            $message = "Scraper failed: " . $processResult->output();
            $this->error($message);
            throw new \DomainException();
        }

        $this->info('Scraper finished');
    }

    private function saveProducts(): void
    {
        if ($this->option('skip-save')) {
            $this->info('Skipping saving products');
            return;
        }

        $saveHandler = match ($this->argument('market')) {
            'bistek' => fn() => $this->saveBistekProducts(),
            'supermercado-koch' => fn() => $this->saveSupermercadoKochProducts(),
        };

        $saveHandler();
    }

    private function saveSupermercadoKochProducts(): void
    {
        $rawJson = Storage::get('scraper/supermercado_koch_products.json');
        $allProducts = json_decode($rawJson, true, flags: JSON_THROW_ON_ERROR);

        foreach ($allProducts as $storeCode => $products) {
            $market = Market::query()->where('code', $storeCode)->firstOrFail();

            $this->info("Saving " . count($products) . " products for store $market->name");

            foreach ($products as $product) {
                $now = now();

                $pictureUrl = $product['picture'];
                $pictureUrl = $pictureUrl ? explode("?", $pictureUrl)[0] : null;

                $product['picture'] = $pictureUrl;
                $product['created_at'] = $now;
                $product['updated_at'] = $now;
                $product['market_id'] = $market->id;

                $market->products()->updateOrCreate(
                    ['sku' => $product['sku'], 'market_id' => $market->id],
                    $product
                );
            }
        }

        $this->info('Products saved!');
    }

    private function saveBistekProducts(): void
    {
        $files = Storage::disk('local')->files('scraper/bistek');

        foreach ($files as $file) {
            $marketCode = explode('scraper/bistek/', $file)[1];
            $marketCode = explode('-', $marketCode)[0];

            $market = Market::query()->where('code', $marketCode)->firstOrFail();

            $raw = Storage::disk('local')->get($file);
            $products = json_decode($raw, true, flags: JSON_THROW_ON_ERROR);

            $this->info("Saving " . count($products) . " products for store $market->name from $file");

            foreach ($products as $product) {
                $now = now();

                $pictureUrl = $product['picture'];
                $pictureUrl = $pictureUrl ? explode("?", $pictureUrl)[0] : null;

                $product['picture'] = $pictureUrl;
                $product['created_at'] = $now;
                $product['updated_at'] = $now;
                $product['market_id'] = $market->id;

                $market->products()->updateOrCreate(
                    ['sku' => $product['sku'], 'market_id' => $market->id],
                    $product
                );
            }
        }
    }
}
