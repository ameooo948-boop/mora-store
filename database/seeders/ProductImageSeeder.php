<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ImageDownloader;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(ImageDownloader $downloader): void
    {
        $products = [

            /*
            |--------------------------------------------------------------------------
            | Mobile Phones
            |--------------------------------------------------------------------------
            */

            'samsung-galaxy-s25' => [
                $this->photo('1610945415295-d9bbf067e59c'),
                $this->photo('1610945265064-0e34e5519bbf'),
                $this->photo('1511707171634-5f897ff02aa9'),
            ],

            'samsung-galaxy-a56-5g' => [
                $this->photo('1598327105666-5b89351aff97'),
                $this->photo('1592899677977-9c89ca76fbaa'),
                $this->photo('1585060544812-829aeb4bbc26'),
            ],

            'xiaomi-redmi-note-14-pro' => [
                $this->photo('1512941937663-435537ca4845'),
                $this->photo('1523206489230-c012c64b2b6c'),
                $this->photo('1574944985070-8b3b3a69fd07'),
            ],

            'xiaomi-redmi-note-14' => [
                $this->photo('1546054454-aa6c8d0788cd'),
                $this->photo('1580910051074-3eb694886505'),
                $this->photo('1565849904461-04a58ad377e0'),
            ],

            'oneplus-13' => [
                $this->photo('1605236453806-6ff0755ea5b3'),
                $this->photo('1510557880182-3d4d3cba35a5'),
                $this->photo('1556656793-08538906a9f8'),
            ],

            'google-pixel-9-pro' => [
                $this->photo('1591337676887-a217a6970a8a'),
                $this->photo('1511707171634-5f897ff02aa9'),
                $this->photo('1601784551446-20c9e07cdbdb'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Apple
            |--------------------------------------------------------------------------
            */

            'apple-iphone-16-pro' => [
                $this->photo('1695048133142-1a20484d2569'),
                $this->photo('1678685888221-cda773a3dcdb'),
                $this->photo('1592750475338-74b8bac6d2f3'),
            ],

            'apple-iphone-16' => [
                $this->photo('1510557880182-3d4d3cba35a5'),
                $this->photo('1601784551446-20c9e07cdbdb'),
                $this->photo('1556656793-08538906a9f8'),
            ],

            'apple-macbook-air-m3' => [
                $this->photo('1517336714731-489689fd1ca8'),
                $this->photo('1611186871348-b75fb057ec05'),
                $this->photo('1541807084-5c52b6b3adef'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Laptops
            |--------------------------------------------------------------------------
            */

            'lenovo-ideapad-slim-3' => [
                $this->photo('1496181133206-80ce9b88a853'),
                $this->photo('1484784123557-b4760c6c22ce'),
                $this->photo('1486312338219-ce68d2c6f44d'),
            ],

            'dell-latitude-5440' => [
                $this->photo('1498050108023-c5249f4df085'),
                $this->photo('1511385342081-54773b81544c'),
                $this->photo('1588872657578-7d3cf7bd2dd4'),
            ],

            'hp-elitebook-840-g10' => [
                $this->photo('1517694712202-14dd9538aa97'),
                $this->photo('1525547719571-a2d4ac8945e2'),
                $this->photo('1486312338219-ce68d2c6f44d'),
            ],

            'asus-rog-strix-g16' => [
                $this->photo('1593642632823-8f785ba67e45'),
                $this->photo('1603302576837-33730910b0aa'),
                $this->photo('1593640408182-31c70c8268f5'),
            ],

            'msi-katana-15' => [
                $this->photo('1593642634367-d91a74349e7a'),
                $this->photo('1593642632823-8f785ba67e45'),
                $this->photo('1525547719571-a2d4ac8945e2'),
            ],

            'acer-aspire-5' => [
                $this->photo('1496181133206-80ce9b88a853'),
                $this->photo('1541807084-5c52b6b3adef'),
                $this->photo('1511385342081-54773b81544c'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Monitors
            |--------------------------------------------------------------------------
            */

            'samsung-odyssey-g5-27' => [
                $this->photo('1527443224154-c4a3942d3acf'),
                $this->photo('1593640408182-31c70c8268f5'),
                $this->photo('1614624532983-4ce03382d63d'),
            ],

            'lg-ultragear-27' => [
                $this->photo('1614624532983-4ce03382d63d'),
                $this->photo('1527443224154-c4a3942d3acf'),
                $this->photo('1593642634367-d91a74349e7a'),
            ],

            /*
            |--------------------------------------------------------------------------
            | TVs
            |--------------------------------------------------------------------------
            */

            'samsung-55-inch-qled-4k-smart-tv' => [
                $this->photo('1593359677879-a4bb92f829d1'),
                $this->photo('1461151304267-38535e780c79'),
                $this->photo('1574375927938-d7a0d8ec9f84'),
            ],

            'lg-55-inch-oled-smart-tv' => [
                $this->photo('1574375927938-d7a0d8ec9f84'),
                $this->photo('1593359677879-a4bb92f829d1'),
                $this->photo('1461151304267-38535e780c79'),
            ],

            'tcl-50-inch-4k-smart-tv' => [
                $this->photo('1461151304267-38535e780c79'),
                $this->photo('1574375927938-d7a0d8ec9f84'),
                $this->photo('1593359677879-a4bb92f829d1'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Audio
            |--------------------------------------------------------------------------
            */

            'jbl-tune-770nc' => [
                $this->photo('1505740420928-5e560c06d30e'),
                $this->photo('1546435770-a3e426bf472b'),
                $this->photo('1484704849700-f032a568e944'),
            ],

            'jbl-charge-5' => [
                $this->photo('1608043152269-423dbba4e7e1'),
                $this->photo('1545454675-3531b543be5d'),
                $this->photo('1545127398-1351406bdc40'),
            ],

            'sony-wh-1000xm5' => [
                $this->photo('1618366712010-f4ae8c184126'),
                $this->photo('1546435770-a3e426bf472b'),
                $this->photo('1572536147248-ac59a8abfa32'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Accessories
            |--------------------------------------------------------------------------
            */

            'anker-323-charger' => [
                $this->photo('1583863788434-e58a36330cf0'),
                $this->photo('1609091834311-8e3eab0be303'),
                $this->photo('1591290619762-c588f7d5b9b0'),
            ],

            'anker-powercore-20000' => [
                $this->photo('1609091834311-8e3eab0be303'),
                $this->photo('1583863788434-e58a36330cf0'),
                $this->photo('1597872200969-2b65d56bd16b'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Storage
            |--------------------------------------------------------------------------
            */

            'kingston-nv2-1tb-nvme-ssd' => [
                $this->photo('1597872200969-2b65d56bd16b'),
                $this->photo('1591488326741-bc628d4b7b29'),
                $this->photo('1518770660439-4636190af475'),
            ],

            'samsung-990-evo-1tb-ssd' => [
                $this->photo('1531492746076-161ca2bc38c3'),
                $this->photo('1597872200969-2b65d56bd16b'),
                $this->photo('1562976540-93084812fd18'),
            ],

            'western-digital-1tb-external-ssd' => [
                $this->photo('1591488326741-bc628d4b7b29'),
                $this->photo('1518770660439-4636190af475'),
                $this->photo('1531492746076-161ca2bc38c3'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Gaming
            |--------------------------------------------------------------------------
            */

            'playstation-5-slim' => [
                $this->photo('1606144042614-b2417e99c4e3'),
                $this->photo('1607853202273-797f1c22a38e'),
                $this->photo('1622297845775-5ff3fef71d13'),
            ],

            'xbox-series-x' => [
                $this->photo('1621259182978-fbf93132d53d'),
                $this->photo('1605901309584-818e25970914'),
                $this->photo('1607853202273-797f1c22a38e'),
            ],
        ];

        foreach ($products as $slug => $urls) {
            $product = Product::where('slug', $slug)->first();

            if (! $product) {
                continue;
            }

            foreach ($urls as $index => $url) {
                $path = $downloader->download(
                    url: $url,
                    directory: "products/{$slug}",
                    filename: ($index + 1).'.jpg'
                );

                if (! $path) {
                    continue;
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'sort_order' => $index,
                ]);
            }
        }
    }

    private function photo(string $id): string
    {
        return "https://images.unsplash.com/photo-{$id}?auto=format&fit=crop&w=1400&q=80";
    }
}
