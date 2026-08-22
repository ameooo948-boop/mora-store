<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->sentence(),
            'image' => null,
            'parent_id' => null,
            'status' => true,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    public static function mainCategories(): array
    {
        return [
            [
                'name' => 'Mobile Phones',
                'slug' => 'mobile-phones',
                'description' => 'Smartphones and mobile phones from popular brands.',
            ],
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'description' => 'Laptops for work, study, gaming and everyday use.',
            ],
            [
                'name' => 'Desktop Computers',
                'slug' => 'desktop-computers',
                'description' => 'Desktop computers for home, office and gaming.',
            ],
            [
                'name' => 'Computer Components',
                'slug' => 'computer-components',
                'description' => 'Computer hardware and internal components.',
            ],
            [
                'name' => 'Monitors',
                'slug' => 'monitors',
                'description' => 'Computer monitors for work, entertainment and gaming.',
            ],
            [
                'name' => 'TVs',
                'slug' => 'tvs',
                'description' => 'Smart TVs and home entertainment displays.',
            ],
            [
                'name' => 'Home Appliances',
                'slug' => 'home-appliances',
                'description' => 'Electrical appliances for your home.',
            ],
            [
                'name' => 'Air Conditioners',
                'slug' => 'air-conditioners',
                'description' => 'Air conditioning systems for home and office.',
            ],
            [
                'name' => 'Audio',
                'slug' => 'audio',
                'description' => 'Headphones, earbuds, speakers and audio equipment.',
            ],
            [
                'name' => 'Mobile Accessories',
                'slug' => 'mobile-accessories',
                'description' => 'Accessories and essential products for mobile phones.',
            ],
            [
                'name' => 'Computer Accessories',
                'slug' => 'computer-accessories',
                'description' => 'Accessories and peripherals for computers.',
            ],
            [
                'name' => 'Networking',
                'slug' => 'networking',
                'description' => 'Networking devices and internet equipment.',
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Gaming consoles, controllers and accessories.',
            ],
            [
                'name' => 'Smart Devices',
                'slug' => 'smart-devices',
                'description' => 'Smart devices and wearable technology.',
            ],
            [
                'name' => 'Storage',
                'slug' => 'storage',
                'description' => 'Storage devices for computers and personal data.',
            ],
        ];
    }

    public static function subCategories(): array
    {
        return [
            'Mobile Phones' => [
                ['name' => 'Android Phones', 'slug' => 'android-phones'],
                ['name' => 'iPhones', 'slug' => 'iphones'],
                ['name' => 'Budget Phones', 'slug' => 'budget-phones'],
                ['name' => 'Mid-Range Phones', 'slug' => 'mid-range-phones'],
                ['name' => 'Flagship Phones', 'slug' => 'flagship-phones'],
            ],

            'Laptops' => [
                ['name' => 'Gaming Laptops', 'slug' => 'gaming-laptops'],
                ['name' => 'Business Laptops', 'slug' => 'business-laptops'],
                ['name' => 'Student Laptops', 'slug' => 'student-laptops'],
                ['name' => 'Ultrabooks', 'slug' => 'ultrabooks'],
                ['name' => '2-in-1 Laptops', 'slug' => '2-in-1-laptops'],
                ['name' => 'Professional Laptops', 'slug' => 'professional-laptops'],
            ],

            'Desktop Computers' => [
                ['name' => 'Gaming PCs', 'slug' => 'gaming-pcs'],
                ['name' => 'Office PCs', 'slug' => 'office-pcs'],
                ['name' => 'All-in-One PCs', 'slug' => 'all-in-one-pcs'],
                ['name' => 'Mini PCs', 'slug' => 'mini-pcs'],
            ],

            'Computer Components' => [
                ['name' => 'Graphics Cards', 'slug' => 'graphics-cards'],
                ['name' => 'Processors', 'slug' => 'processors'],
                ['name' => 'Motherboards', 'slug' => 'motherboards'],
                ['name' => 'RAM', 'slug' => 'ram'],
                ['name' => 'SSDs', 'slug' => 'ssds'],
                ['name' => 'Hard Drives', 'slug' => 'hard-drives'],
                ['name' => 'Power Supplies', 'slug' => 'power-supplies'],
                ['name' => 'PC Cases', 'slug' => 'pc-cases'],
                ['name' => 'CPU Coolers', 'slug' => 'cpu-coolers'],
            ],

            'Monitors' => [
                ['name' => 'Gaming Monitors', 'slug' => 'gaming-monitors'],
                ['name' => '4K Monitors', 'slug' => '4k-monitors'],
                ['name' => 'Curved Monitors', 'slug' => 'curved-monitors'],
                ['name' => 'Professional Monitors', 'slug' => 'professional-monitors'],
            ],

            'TVs' => [
                ['name' => 'Smart TVs', 'slug' => 'smart-tvs'],
                ['name' => 'LED TVs', 'slug' => 'led-tvs'],
                ['name' => 'OLED TVs', 'slug' => 'oled-tvs'],
                ['name' => 'QLED TVs', 'slug' => 'qled-tvs'],
                ['name' => '4K TVs', 'slug' => '4k-tvs'],
            ],

            'Home Appliances' => [
                ['name' => 'Refrigerators', 'slug' => 'refrigerators'],
                ['name' => 'Washing Machines', 'slug' => 'washing-machines'],
                ['name' => 'Dishwashers', 'slug' => 'dishwashers'],
                ['name' => 'Microwaves', 'slug' => 'microwaves'],
                ['name' => 'Electric Ovens', 'slug' => 'electric-ovens'],
                ['name' => 'Vacuum Cleaners', 'slug' => 'vacuum-cleaners'],
            ],

            'Air Conditioners' => [
                ['name' => 'Split Air Conditioners', 'slug' => 'split-air-conditioners'],
                ['name' => 'Inverter Air Conditioners', 'slug' => 'inverter-air-conditioners'],
                ['name' => 'Portable Air Conditioners', 'slug' => 'portable-air-conditioners'],
            ],

            'Audio' => [
                ['name' => 'Wireless Earbuds', 'slug' => 'wireless-earbuds'],
                ['name' => 'Headphones', 'slug' => 'headphones'],
                ['name' => 'Bluetooth Speakers', 'slug' => 'bluetooth-speakers'],
                ['name' => 'Soundbars', 'slug' => 'soundbars'],
                ['name' => 'Home Audio Systems', 'slug' => 'home-audio-systems'],
            ],

            'Mobile Accessories' => [
                ['name' => 'Chargers', 'slug' => 'chargers'],
                ['name' => 'Charging Cables', 'slug' => 'charging-cables'],
                ['name' => 'Power Banks', 'slug' => 'power-banks'],
                ['name' => 'Phone Cases', 'slug' => 'phone-cases'],
                ['name' => 'Screen Protectors', 'slug' => 'screen-protectors'],
                ['name' => 'Wireless Chargers', 'slug' => 'wireless-chargers'],
            ],

            'Computer Accessories' => [
                ['name' => 'Keyboards', 'slug' => 'keyboards'],
                ['name' => 'Gaming Keyboards', 'slug' => 'gaming-keyboards'],
                ['name' => 'Mice', 'slug' => 'mice'],
                ['name' => 'Gaming Mice', 'slug' => 'gaming-mice'],
                ['name' => 'Webcams', 'slug' => 'webcams'],
                ['name' => 'Mouse Pads', 'slug' => 'mouse-pads'],
                ['name' => 'Laptop Bags', 'slug' => 'laptop-bags'],
                ['name' => 'Laptop Stands', 'slug' => 'laptop-stands'],
            ],

            'Networking' => [
                ['name' => 'Routers', 'slug' => 'routers'],
                ['name' => 'Wi-Fi Extenders', 'slug' => 'wifi-extenders'],
                ['name' => 'Network Switches', 'slug' => 'network-switches'],
                ['name' => 'Network Adapters', 'slug' => 'network-adapters'],
                ['name' => 'Mesh Wi-Fi Systems', 'slug' => 'mesh-wifi-systems'],
            ],

            'Gaming' => [
                ['name' => 'PlayStation', 'slug' => 'playstation'],
                ['name' => 'Xbox', 'slug' => 'xbox'],
                ['name' => 'Nintendo', 'slug' => 'nintendo'],
                ['name' => 'Gaming Controllers', 'slug' => 'gaming-controllers'],
                ['name' => 'Gaming Headsets', 'slug' => 'gaming-headsets'],
                ['name' => 'Gaming Accessories', 'slug' => 'gaming-accessories'],
            ],

            'Smart Devices' => [
                ['name' => 'Smart Watches', 'slug' => 'smart-watches'],
                ['name' => 'Smart Bands', 'slug' => 'smart-bands'],
                ['name' => 'Smart Home Devices', 'slug' => 'smart-home-devices'],
                ['name' => 'Smart Cameras', 'slug' => 'smart-cameras'],
            ],

            'Storage' => [
                ['name' => 'External SSDs', 'slug' => 'external-ssds'],
                ['name' => 'External Hard Drives', 'slug' => 'external-hard-drives'],
                ['name' => 'USB Flash Drives', 'slug' => 'usb-flash-drives'],
                ['name' => 'Memory Cards', 'slug' => 'memory-cards'],
            ],
        ];
    }
}
