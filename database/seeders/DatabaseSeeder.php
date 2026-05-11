<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Admin::query()->updateOrCreate(
            ['email' => 'admin@mgstore.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        Setting::set('store_phone', '+966500000000');
        Setting::set('whatsapp_number', '966500000000');
        Setting::set('address_ar', 'الرياض، المملكة العربية السعودية');
        Setting::set('address_en', 'Riyadh, Saudi Arabia');
        Setting::set('social_instagram', 'https://instagram.com');
        Setting::set('currency_code', 'ILS');
        Setting::set('currency_symbol', '₪');
        Setting::set('meta_title', 'MG Store');
        Setting::set('meta_description_ar', 'متجر فاخر: ساعات وشنط وإكسسوارات ومحافظ من ماركات عالمية.');
        Setting::set('meta_description_en', 'Luxury boutique: watches, bags, accessories, and wallets from world-class brands.');
        Setting::set('hero_slides', json_encode([
            [
                'title_ar' => 'منتجاتنا تعكس أناقتك',
                'title_en' => 'Our products reflect your elegance',
                'subtitle_ar' => 'منتجات مختارة من أرقى الماركات العالمية.',
                'subtitle_en' => 'Handpicked products from the world’s finest brands — a refined shopping experience.',
            ],
        ], JSON_UNESCAPED_UNICODE));

        $brands = [
            ['name_ar' => 'رولكس', 'name_en' => 'Rolex', 'slug' => 'rolex'],
            ['name_ar' => 'أوميغا', 'name_en' => 'Omega', 'slug' => 'omega'],
            ['name_ar' => 'تاغ هوير', 'name_en' => 'TAG Heuer', 'slug' => 'tag-heuer'],
        ];

        $brandModels = collect($brands)->map(fn ($b) => Brand::query()->updateOrCreate(
            ['slug' => $b['slug']],
            ['name_ar' => $b['name_ar'], 'name_en' => $b['name_en']]
        ));

        $categories = [
            ['name_ar' => 'كلاسيك', 'name_en' => 'Classic', 'slug' => 'classic'],
            ['name_ar' => 'رياضية', 'name_en' => 'Sport', 'slug' => 'sport'],
            ['name_ar' => 'فاخرة', 'name_en' => 'Dress', 'slug' => 'dress'],
            ['name_ar' => 'شنط', 'name_en' => 'Bags', 'slug' => 'bags'],
            ['name_ar' => 'إكسسوارات', 'name_en' => 'Accessories', 'slug' => 'accessories'],
            ['name_ar' => 'محافظ', 'name_en' => 'Wallets', 'slug' => 'wallets'],
        ];

        $categoryModels = collect($categories)->map(fn ($c) => Category::query()->updateOrCreate(
            ['slug' => $c['slug']],
            ['name_ar' => $c['name_ar'], 'name_en' => $c['name_en']]
        ));

        $products = [
            [
                'name_ar' => 'ساعة كلاسيكية أسود وذهبي',
                'name_en' => 'Noir Gold Classic',
                'slug' => 'noir-gold-classic',
                'description_ar' => 'تصميم أنيق بإطار ذهبي وهيكل أسود عميق.',
                'description_en' => 'Elegant design with gold accents on a deep black case.',
                'specifications_ar' => "الزجاج: سافير\nالمقاومة للماء: 50م",
                'specifications_en' => "Crystal: Sapphire\nWater resistance: 50m",
                'price' => 4200,
                'discount_price' => 3890,
                'stock' => 12,
                'gender' => 'men',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => true,
            ],
            [
                'name_ar' => 'ساعة رياضية كرونوغراف',
                'name_en' => 'Apex Chronograph Sport',
                'slug' => 'apex-chronograph-sport',
                'description_ar' => 'حركة كرونوغراف دقيقة مع مقياس تاكيمتر.',
                'description_en' => 'Precision chronograph movement with tachymeter scale.',
                'specifications_ar' => "الحركة: أوتوماتيك\nالقطر: 42مم",
                'specifications_en' => "Movement: Automatic\nDiameter: 42mm",
                'price' => 5100,
                'discount_price' => null,
                'stock' => 8,
                'gender' => 'men',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new_arrival' => false,
            ],
            [
                'name_ar' => 'ساعة نسائية لامعة',
                'name_en' => 'Lumière Petite',
                'slug' => 'lumiere-petite',
                'description_ar' => 'لمعة ناعمة مع سوار جلدي فاخر.',
                'description_en' => 'Soft brilliance with a refined leather strap.',
                'specifications_ar' => "القطر: 34مم\nالسوار: جلد",
                'specifications_en' => "Diameter: 34mm\nStrap: Leather",
                'price' => 3600,
                'discount_price' => 3200,
                'stock' => 15,
                'gender' => 'women',
                'is_featured' => true,
                'is_bestseller' => false,
                'is_new_arrival' => true,
            ],
            [
                'name_ar' => 'ساعة يونيسكس مينيمال',
                'name_en' => 'Mono Line Unisex',
                'slug' => 'mono-line-unisex',
                'description_ar' => 'خطوط نقية وهدوء فاخر.',
                'description_en' => 'Pure lines and quiet luxury.',
                'specifications_ar' => "القطر: 38مم\nالسوار: ستانلس",
                'specifications_en' => "Diameter: 38mm\nBracelet: Steel",
                'price' => 2950,
                'discount_price' => null,
                'stock' => 20,
                'gender' => 'unisex',
                'is_featured' => false,
                'is_bestseller' => true,
                'is_new_arrival' => true,
            ],
        ];

        foreach ($products as $idx => $p) {
            Product::query()->updateOrCreate(
                ['slug' => $p['slug']],
                [
                    ...$p,
                    'brand_id' => $brandModels[$idx % $brandModels->count()]->id,
                    'category_id' => $categoryModels[$idx % $categoryModels->count()]->id,
                ]
            );
        }

        Coupon::query()->updateOrCreate(
            ['code' => 'MG10'],
            [
                'type' => 'percent',
                'value' => 10,
                'expires_at' => now()->addMonths(3),
                'is_active' => true,
            ]
        );
    }
}
