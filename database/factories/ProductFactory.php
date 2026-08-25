<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $products = self::products();

        $product = fake()->randomElement($products);

        return [
            'name' => $product['name'],
            'slug' => $product['slug'],
            'description' => $product['description'],
            'sku' => $product['sku'],
            'price' => $product['price'],
            'sale_price' => $product['sale_price'] ?? null,
            'quantity' => $product['quantity'] ?? fake()->numberBetween(5, 50),
            'status' => true,
            'featured' => $product['featured'] ?? false,
            'sort_order' => $product['sort_order'] ?? 0,

            'category_id' => Category::where(
                'slug',
                $product['category']
            )->value('id'),

            'brand_id' => Brand::where(
                'slug',
                $product['brand']
            )->value('id'),
        ];
    }

    public static function products(): array
    {
        return [

            // =========================
            // MOBILE PHONES
            // =========================

            [
                'name' => 'Samsung Galaxy S25',
                'slug' => 'samsung-galaxy-s25',
                'sku' => 'SAM-S25-128',
                'brand' => 'samsung',
                'category' => 'android-phones',
                'description' => 'Samsung Galaxy S25 with a powerful processor, advanced camera system and vibrant AMOLED display.',
                'price' => 39999,
                'sale_price' => 37999,
                'quantity' => 25,
                'featured' => true,
            ],

            [
                'name' => 'Samsung Galaxy A56 5G',
                'slug' => 'samsung-galaxy-a56-5g',
                'sku' => 'SAM-A56-256',
                'brand' => 'samsung',
                'category' => 'mid-range-phones',
                'description' => 'Samsung Galaxy A56 5G featuring a high quality AMOLED display, capable cameras and long battery life.',
                'price' => 23999,
                'sale_price' => 22499,
                'quantity' => 40,
                'featured' => true,
            ],

            [
                'name' => 'Apple iPhone 16 Pro',
                'slug' => 'apple-iphone-16-pro',
                'sku' => 'APP-IP16P-128',
                'brand' => 'apple',
                'category' => 'iphones',
                'description' => 'iPhone 16 Pro with a titanium design, Pro camera system and powerful Apple silicon.',
                'price' => 59999,
                'sale_price' => 57499,
                'quantity' => 15,
                'featured' => true,
            ],

            [
                'name' => 'Apple iPhone 16',
                'slug' => 'apple-iphone-16',
                'sku' => 'APP-IP16-128',
                'brand' => 'apple',
                'category' => 'iphones',
                'description' => 'iPhone 16 with a modern design, advanced camera system and excellent performance.',
                'price' => 46999,
                'sale_price' => null,
                'quantity' => 20,
                'featured' => true,
            ],

            [
                'name' => 'Xiaomi Redmi Note 14 Pro',
                'slug' => 'xiaomi-redmi-note-14-pro',
                'sku' => 'XIA-RN14P-256',
                'brand' => 'xiaomi',
                'category' => 'mid-range-phones',
                'description' => 'Redmi Note 14 Pro with a high resolution display, powerful performance and advanced camera system.',
                'price' => 15999,
                'sale_price' => 14999,
                'quantity' => 35,
            ],

            [
                'name' => 'Xiaomi Redmi Note 14',
                'slug' => 'xiaomi-redmi-note-14',
                'sku' => 'XIA-RN14-128',
                'brand' => 'xiaomi',
                'category' => 'budget-phones',
                'description' => 'Redmi Note 14 offering reliable performance, a large display and long battery life.',
                'price' => 10999,
                'sale_price' => 9999,
                'quantity' => 50,
            ],

            [
                'name' => 'OnePlus 13',
                'slug' => 'oneplus-13',
                'sku' => 'ONE-13-256',
                'brand' => 'oneplus',
                'category' => 'flagship-phones',
                'description' => 'OnePlus 13 flagship smartphone with high performance hardware and a premium display.',
                'price' => 42999,
                'sale_price' => 40999,
                'quantity' => 18,
                'featured' => true,
            ],

            [
                'name' => 'Google Pixel 9 Pro',
                'slug' => 'google-pixel-9-pro',
                'sku' => 'GOO-P9P-256',
                'brand' => 'google',
                'category' => 'flagship-phones',
                'description' => 'Google Pixel 9 Pro with advanced AI features, professional camera capabilities and a premium display.',
                'price' => 49999,
                'sale_price' => null,
                'quantity' => 12,
            ],

            // =========================
            // LAPTOPS
            // =========================

            [
                'name' => 'Lenovo IdeaPad Slim 3',
                'slug' => 'lenovo-ideapad-slim-3',
                'sku' => 'LEN-IPS3-I5',
                'brand' => 'lenovo',
                'category' => 'student-laptops',
                'description' => 'Lenovo IdeaPad Slim 3 designed for students and everyday productivity.',
                'price' => 28999,
                'sale_price' => 27499,
                'quantity' => 20,
            ],

            [
                'name' => 'Dell Latitude 5440',
                'slug' => 'dell-latitude-5440',
                'sku' => 'DEL-L5440-I5',
                'brand' => 'dell',
                'category' => 'business-laptops',
                'description' => 'Dell Latitude 5440 business laptop designed for productivity and professional workloads.',
                'price' => 34999,
                'sale_price' => null,
                'quantity' => 15,
                'featured' => true,
            ],

            [
                'name' => 'HP EliteBook 840 G10',
                'slug' => 'hp-elitebook-840-g10',
                'sku' => 'HP-EB840-G10',
                'brand' => 'hp',
                'category' => 'business-laptops',
                'description' => 'HP EliteBook 840 G10 designed for business users with strong performance and premium build quality.',
                'price' => 42999,
                'sale_price' => 40999,
                'quantity' => 10,
            ],

            [
                'name' => 'ASUS ROG Strix G16',
                'slug' => 'asus-rog-strix-g16',
                'sku' => 'ASU-ROG-G16',
                'brand' => 'asus',
                'category' => 'gaming-laptops',
                'description' => 'ASUS ROG Strix G16 gaming laptop built for demanding games and high performance workloads.',
                'price' => 69999,
                'sale_price' => 67499,
                'quantity' => 8,
                'featured' => true,
            ],

            [
                'name' => 'MSI Katana 15',
                'slug' => 'msi-katana-15',
                'sku' => 'MSI-KAT15',
                'brand' => 'msi',
                'category' => 'gaming-laptops',
                'description' => 'MSI Katana 15 gaming laptop designed for modern games and demanding applications.',
                'price' => 54999,
                'sale_price' => 52999,
                'quantity' => 10,
            ],

            [
                'name' => 'Acer Aspire 5',
                'slug' => 'acer-aspire-5',
                'sku' => 'ACE-AS5-I5',
                'brand' => 'acer',
                'category' => 'student-laptops',
                'description' => 'Acer Aspire 5 laptop suitable for studying, office work and everyday computing.',
                'price' => 26999,
                'sale_price' => 25499,
                'quantity' => 25,
            ],

            [
                'name' => 'Apple MacBook Air M3',
                'slug' => 'apple-macbook-air-m3',
                'sku' => 'APP-MBA-M3',
                'brand' => 'apple',
                'category' => 'professional-laptops',
                'description' => 'MacBook Air powered by Apple M3 chip with a lightweight design and excellent battery life.',
                'price' => 59999,
                'sale_price' => 57999,
                'quantity' => 12,
                'featured' => true,
            ],

            // =========================
            // MONITORS
            // =========================

            [
                'name' => 'Samsung Odyssey G5 27"',
                'slug' => 'samsung-odyssey-g5-27',
                'sku' => 'SAM-ODG5-27',
                'brand' => 'samsung',
                'category' => 'gaming-monitors',
                'description' => 'Samsung Odyssey G5 gaming monitor with a curved display and high refresh rate.',
                'price' => 18999,
                'sale_price' => 17499,
                'quantity' => 14,
                'featured' => true,
            ],

            [
                'name' => 'LG UltraGear 27"',
                'slug' => 'lg-ultragear-27',
                'sku' => 'LG-UG-27',
                'brand' => 'lg',
                'category' => 'gaming-monitors',
                'description' => 'LG UltraGear gaming monitor designed for smooth gameplay and fast response times.',
                'price' => 16999,
                'sale_price' => null,
                'quantity' => 18,
            ],

            // =========================
            // TVs
            // =========================

            [
                'name' => 'Samsung 55 Inch QLED 4K Smart TV',
                'slug' => 'samsung-55-inch-qled-4k-smart-tv',
                'sku' => 'SAM-TV55-QLED',
                'brand' => 'samsung',
                'category' => 'qled-tvs',
                'description' => 'Samsung 55-inch QLED 4K Smart TV with vivid colors and smart entertainment features.',
                'price' => 45999,
                'sale_price' => 42999,
                'quantity' => 7,
                'featured' => true,
            ],

            [
                'name' => 'LG 55 Inch OLED Smart TV',
                'slug' => 'lg-55-inch-oled-smart-tv',
                'sku' => 'LG-TV55-OLED',
                'brand' => 'lg',
                'category' => 'oled-tvs',
                'description' => 'LG 55-inch OLED Smart TV delivering deep blacks, rich colors and premium picture quality.',
                'price' => 54999,
                'sale_price' => 51999,
                'quantity' => 6,
                'featured' => true,
            ],

            [
                'name' => 'TCL 50 Inch 4K Smart TV',
                'slug' => 'tcl-50-inch-4k-smart-tv',
                'sku' => 'TCL-TV50-4K',
                'brand' => 'tcl',
                'category' => '4k-tvs',
                'description' => 'TCL 50-inch 4K Smart TV with smart entertainment features and high resolution picture quality.',
                'price' => 23999,
                'sale_price' => 22499,
                'quantity' => 15,
            ],

            // =========================
            // AUDIO
            // =========================

            [
                'name' => 'JBL Tune 770NC',
                'slug' => 'jbl-tune-770nc',
                'sku' => 'JBL-T770NC',
                'brand' => 'jbl',
                'category' => 'headphones',
                'description' => 'JBL Tune 770NC wireless headphones with active noise cancellation and long battery life.',
                'price' => 6999,
                'sale_price' => 6499,
                'quantity' => 30,
                'featured' => true,
            ],

            [
                'name' => 'JBL Charge 5',
                'slug' => 'jbl-charge-5',
                'sku' => 'JBL-CHG5',
                'brand' => 'jbl',
                'category' => 'bluetooth-speakers',
                'description' => 'JBL Charge 5 portable Bluetooth speaker with powerful sound and long battery life.',
                'price' => 6999,
                'sale_price' => 6499,
                'quantity' => 25,
            ],

            [
                'name' => 'Sony WH-1000XM5',
                'slug' => 'sony-wh-1000xm5',
                'sku' => 'SONY-WH1000XM5',
                'brand' => 'sony',
                'category' => 'headphones',
                'description' => 'Sony WH-1000XM5 premium wireless headphones with advanced noise cancellation.',
                'price' => 18999,
                'sale_price' => 17499,
                'quantity' => 10,
                'featured' => true,
            ],

            // =========================
            // MOBILE ACCESSORIES
            // =========================

            [
                'name' => 'Anker 323 Charger',
                'slug' => 'anker-323-charger',
                'sku' => 'ANK-323-CH',
                'brand' => 'anker',
                'category' => 'chargers',
                'description' => 'Anker 323 fast charger designed for smartphones and other compatible devices.',
                'price' => 999,
                'sale_price' => 899,
                'quantity' => 60,
            ],

            [
                'name' => 'Anker PowerCore 20000',
                'slug' => 'anker-powercore-20000',
                'sku' => 'ANK-PC20K',
                'brand' => 'anker',
                'category' => 'power-banks',
                'description' => 'Anker PowerCore 20000mAh portable power bank for charging mobile devices on the go.',
                'price' => 2499,
                'sale_price' => 2299,
                'quantity' => 40,
            ],

            // =========================
            // STORAGE
            // =========================

            [
                'name' => 'Kingston NV2 1TB NVMe SSD',
                'slug' => 'kingston-nv2-1tb-nvme-ssd',
                'sku' => 'KIN-NV2-1TB',
                'brand' => 'kingston',
                'category' => 'ssds',
                'description' => 'Kingston NV2 1TB NVMe SSD providing fast storage performance for desktops and laptops.',
                'price' => 4999,
                'sale_price' => 4499,
                'quantity' => 35,
                'featured' => true,
            ],

            [
                'name' => 'Samsung 990 EVO 1TB SSD',
                'slug' => 'samsung-990-evo-1tb-ssd',
                'sku' => 'SAM-990EVO-1TB',
                'brand' => 'samsung',
                'category' => 'ssds',
                'description' => 'Samsung 990 EVO 1TB SSD designed for high performance storage and demanding applications.',
                'price' => 6999,
                'sale_price' => 6499,
                'quantity' => 20,
            ],

            [
                'name' => 'Western Digital 1TB External SSD',
                'slug' => 'western-digital-1tb-external-ssd',
                'sku' => 'WD-EXT-SSD-1TB',
                'brand' => 'western-digital',
                'category' => 'external-ssds',
                'description' => 'Western Digital 1TB portable SSD for fast and reliable external storage.',
                'price' => 6999,
                'sale_price' => null,
                'quantity' => 15,
            ],

            // =========================
            // GAMING
            // =========================

            [
                'name' => 'PlayStation 5 Slim',
                'slug' => 'playstation-5-slim',
                'sku' => 'PS5-SLIM',
                'brand' => 'playstation',
                'category' => 'playstation',
                'description' => 'PlayStation 5 Slim gaming console with high performance hardware and fast SSD storage.',
                'price' => 29999,
                'sale_price' => 28999,
                'quantity' => 10,
                'featured' => true,
            ],

            [
                'name' => 'Xbox Series X',
                'slug' => 'xbox-series-x',
                'sku' => 'XBX-SERIES-X',
                'brand' => 'xbox',
                'category' => 'xbox',
                'description' => 'Xbox Series X high performance gaming console designed for next generation gaming.',
                'price' => 31999,
                'sale_price' => null,
                'quantity' => 8,
                'featured' => true,
            ],
        ];
    }

    public function withRelations(): static
    {
        return $this->state(function (array $attributes) {
            $selected = collect(self::products())
                ->firstWhere('slug', $attributes['slug']);

            if (! $selected) {
                return [];
            }

            return [
                'category_id' => Category::firstOrCreate(
                    ['slug' => $selected['category']],
                    [
                        'name' => str($selected['category'])
                            ->replace('-', ' ')
                            ->title()
                            ->toString(),
                        'status' => true,
                        'sort_order' => 0,
                    ]
                )->id,

                'brand_id' => Brand::firstOrCreate(
                    ['slug' => $selected['brand']],
                    [
                        'name' => str($selected['brand'])
                            ->replace('-', ' ')
                            ->title()
                            ->toString(),
                        'status' => true,
                        'sort_order' => 0,
                    ]
                )->id,

                'slug' => $attributes['slug'].'-'.fake()->unique()->numberBetween(1, 999999),

                'sku' => $attributes['sku'].'-'.fake()->unique()->numberBetween(1, 999999),
            ];
        });
    }

    public function onSale(): static
    {
        return $this->state(function (array $attributes) {
            $price = $attributes['price'];

            return [
                'sale_price' => round($price * 0.9, 2),
            ];
        });
    }

    public function featured(): static
    {
        return $this->state([
            'featured' => true,
        ]);
    }

    public function outOfStock(): static
    {
        return $this->state([
            'quantity' => 0,
        ]);
    }

    public function inactive(): static
    {
        return $this->state([
            'status' => false,
        ]);
    }
}
