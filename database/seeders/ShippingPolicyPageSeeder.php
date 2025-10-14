<?php

namespace Database\Seeders;

use App\Models\ShippingPolicyPage;
use Illuminate\Database\Seeder;

class ShippingPolicyPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShippingPolicyPage::create([
            'banner_title' => 'Shipping Policy',
            'banner_subtitle' => 'Information about our shipping methods, delivery times, and policies',
            'shipping_info_title' => 'Shipping Information',
            'shipping_info_content' => 'We strive to process and ship all orders within 1-2 business days of order placement. During peak seasons or promotional periods, processing times may be slightly longer.',
            'delivery_times_title' => 'Delivery Times',
            'delivery_times_content' => 'Delivery times vary depending on your location and the shipping method selected at checkout. Standard delivery times are typically 3-7 business days within India.',
            'order_tracking_title' => 'Order Tracking',
            'order_tracking_content' => 'Once your order has been shipped, you will receive a tracking number via email. You can use this number to track your package on our website or the courier service\'s website.',
            'international_shipping_title' => 'International Shipping',
            'international_shipping_content' => 'We currently only ship within India. We apologize for any inconvenience this may cause. Please check back in the future as we plan to expand our shipping options.',
            'damaged_lost_packages_title' => 'Damaged or Lost Packages',
            'damaged_lost_packages_content' => 'In the rare event that your package is lost or damaged during transit, please contact our customer service team within 7 days of receiving your order.',
            'faq_title' => 'Frequently Asked Questions',
            'faq_content' => 'Have questions about our shipping policy? Check out our FAQ section or contact our customer service team for assistance.',
            'contact_section_title' => 'Need Help?',
            'contact_section_content' => 'If you have any questions about our shipping policy or need assistance with an order, our customer service team is here to help.',
            'meta_title' => 'Shipping Policy | Glow Candles',
            'meta_description' => 'Learn about our shipping policies, delivery times, and rates. Find answers to common shipping questions.',
            'meta_keywords' => 'shipping policy, delivery times, shipping rates, order tracking, faq',
            'is_active' => true
        ]);
    }
}
