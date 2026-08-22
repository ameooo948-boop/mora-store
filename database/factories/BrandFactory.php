<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->sentence(),
            'logo' => null,
            'status' => true,
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }

    public static function brands(): array
    {
        return [
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'description' => 'Samsung electronics and smart devices.',
            ],
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'description' => 'Apple smartphones, computers and accessories.',
            ],
            [
                'name' => 'Xiaomi',
                'slug' => 'xiaomi',
                'description' => 'Xiaomi smartphones, smart devices and accessories.',
            ],
            [
                'name' => 'Huawei',
                'slug' => 'huawei',
                'description' => 'Huawei smartphones, networking and smart devices.',
            ],
            [
                'name' => 'Oppo',
                'slug' => 'oppo',
                'description' => 'Oppo smartphones and mobile accessories.',
            ],
            [
                'name' => 'OnePlus',
                'slug' => 'oneplus',
                'description' => 'OnePlus smartphones and mobile technology.',
            ],
            [
                'name' => 'Realme',
                'slug' => 'realme',
                'description' => 'Realme smartphones and smart devices.',
            ],
            [
                'name' => 'Honor',
                'slug' => 'honor',
                'description' => 'Honor smartphones, tablets and smart devices.',
            ],
            [
                'name' => 'Google',
                'slug' => 'google',
                'description' => 'Google smartphones and smart technology.',
            ],
            [
                'name' => 'Nokia',
                'slug' => 'nokia',
                'description' => 'Nokia mobile phones and networking products.',
            ],

            // Laptops & Computers
            [
                'name' => 'Dell',
                'slug' => 'dell',
                'description' => 'Dell laptops, desktops, monitors and computer accessories.',
            ],
            [
                'name' => 'HP',
                'slug' => 'hp',
                'description' => 'HP laptops, desktops, printers and accessories.',
            ],
            [
                'name' => 'Lenovo',
                'slug' => 'lenovo',
                'description' => 'Lenovo laptops, desktops and computer accessories.',
            ],
            [
                'name' => 'ASUS',
                'slug' => 'asus',
                'description' => 'ASUS laptops, gaming computers, monitors and components.',
            ],
            [
                'name' => 'Acer',
                'slug' => 'acer',
                'description' => 'Acer laptops, monitors and gaming products.',
            ],
            [
                'name' => 'MSI',
                'slug' => 'msi',
                'description' => 'MSI gaming laptops, desktops, monitors and components.',
            ],
            [
                'name' => 'Razer',
                'slug' => 'razer',
                'description' => 'Razer gaming laptops, peripherals and gaming accessories.',
            ],
            [
                'name' => 'Microsoft',
                'slug' => 'microsoft',
                'description' => 'Microsoft computers, accessories and technology products.',
            ],

            // PC Components
            [
                'name' => 'Intel',
                'slug' => 'intel',
                'description' => 'Intel processors and computer technologies.',
            ],
            [
                'name' => 'AMD',
                'slug' => 'amd',
                'description' => 'AMD processors and graphics technologies.',
            ],
            [
                'name' => 'NVIDIA',
                'slug' => 'nvidia',
                'description' => 'NVIDIA graphics cards and GPU technologies.',
            ],
            [
                'name' => 'Gigabyte',
                'slug' => 'gigabyte',
                'description' => 'Gigabyte graphics cards, motherboards and computer hardware.',
            ],
            [
                'name' => 'ASRock',
                'slug' => 'asrock',
                'description' => 'ASRock motherboards and computer components.',
            ],
            [
                'name' => 'Corsair',
                'slug' => 'corsair',
                'description' => 'Corsair RAM, power supplies, PC cases and gaming accessories.',
            ],
            [
                'name' => 'Kingston',
                'slug' => 'kingston',
                'description' => 'Kingston memory, SSDs and storage products.',
            ],
            [
                'name' => 'Western Digital',
                'slug' => 'western-digital',
                'description' => 'Western Digital hard drives and storage solutions.',
            ],
            [
                'name' => 'Seagate',
                'slug' => 'seagate',
                'description' => 'Seagate hard drives and storage products.',
            ],

            // TVs & Home Appliances
            [
                'name' => 'LG',
                'slug' => 'lg',
                'description' => 'LG TVs, home appliances and electronic products.',
            ],
            [
                'name' => 'Sony',
                'slug' => 'sony',
                'description' => 'Sony TVs, audio products, gaming and electronics.',
            ],
            [
                'name' => 'TCL',
                'slug' => 'tcl',
                'description' => 'TCL TVs, displays and home electronics.',
            ],
            [
                'name' => 'Hisense',
                'slug' => 'hisense',
                'description' => 'Hisense TVs, refrigerators and home appliances.',
            ],
            [
                'name' => 'Panasonic',
                'slug' => 'panasonic',
                'description' => 'Panasonic TVs, appliances and electronics.',
            ],
            [
                'name' => 'Philips',
                'slug' => 'philips',
                'description' => 'Philips home appliances, electronics and personal care products.',
            ],
            [
                'name' => 'Sharp',
                'slug' => 'sharp',
                'description' => 'Sharp TVs, refrigerators and home appliances.',
            ],
            [
                'name' => 'Beko',
                'slug' => 'beko',
                'description' => 'Beko refrigerators, washing machines and home appliances.',
            ],
            [
                'name' => 'Toshiba',
                'slug' => 'toshiba',
                'description' => 'Toshiba TVs, appliances and electronics.',
            ],

            // Audio
            [
                'name' => 'JBL',
                'slug' => 'jbl',
                'description' => 'JBL headphones, earbuds and Bluetooth speakers.',
            ],
            [
                'name' => 'Bose',
                'slug' => 'bose',
                'description' => 'Bose headphones, speakers and premium audio products.',
            ],
            [
                'name' => 'Anker',
                'slug' => 'anker',
                'description' => 'Anker audio products, chargers and electronic accessories.',
            ],
            [
                'name' => 'Soundcore',
                'slug' => 'soundcore',
                'description' => 'Soundcore headphones, earbuds and Bluetooth speakers.',
            ],
            [
                'name' => 'Sennheiser',
                'slug' => 'sennheiser',
                'description' => 'Sennheiser headphones and professional audio products.',
            ],

            // Gaming
            [
                'name' => 'PlayStation',
                'slug' => 'playstation',
                'description' => 'PlayStation consoles, controllers and gaming accessories.',
            ],
            [
                'name' => 'Xbox',
                'slug' => 'xbox',
                'description' => 'Xbox consoles, controllers and gaming accessories.',
            ],
            [
                'name' => 'Nintendo',
                'slug' => 'nintendo',
                'description' => 'Nintendo consoles, games and accessories.',
            ],
        ];
    }
}
