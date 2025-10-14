<?php

namespace Database\Seeders;

use App\Models\ContactPage;
use Illuminate\Database\Seeder;

class ContactPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactPage::create([
            'banner_title' => 'Contact Us',
            'banner_subtitle' => 'We\'d love to hear from you! Reach out to our team with any questions or feedback.',
            'contact_form_title' => 'Send Us a Message',
            'contact_form_subtitle' => 'Have questions about our products or need assistance with an order? Fill out the form below and we\'ll get back to you as soon as possible.',
            'contact_info_title' => 'Get In Touch',
            'contact_info_subtitle' => 'We\'re here to help and answer any questions you might have. We look forward to hearing from you!',
            'email' => 'info@glowcandles.in',
            'phone' => '+91 98765 43210',
            'address' => '123 Candle Street, Mumbai, Maharashtra 400001, India',
            'business_hours_title' => 'Business Hours',
            'business_hours_content' => 'Monday - Friday: 9:00 AM - 6:00 PM\nSaturday: 10:00 AM - 4:00 PM\nSunday: Closed',
            'social_media_title' => 'Follow Us',
            'social_media_subtitle' => 'Stay connected with us on social media for the latest updates, promotions, and more!',
            'instagram_url' => 'https://instagram.com/glowcandles',
            'facebook_url' => 'https://facebook.com/glowcandles',
            'pinterest_url' => 'https://pinterest.com/glowcandles',
            'map_embed_code' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3771.263293169541!2d72.87792091537786!3d19.07598368710218!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c8f6a6f1e1b1%3A0x1b51d1c3e3e3e3e3!2sMumbai%2C%20Maharashtra%20400001!5e0!3m2!1sen!2sin!4v1620000000000!5m2!1sen!2sin" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'faq_section_title' => 'Frequently Asked Questions',
            'faq_section_subtitle' => 'Find answers to common questions about our products, shipping, and more.',
            'cta_section_title' => 'Ready to Light Up Your Space?',
            'cta_section_content' => 'Explore our collection of handcrafted candles and find the perfect scent for your home.',
            'cta_button_text' => 'Shop Now',
            'cta_button_link' => '/shop',
            'meta_title' => 'Contact Us | Glow Candles',
            'meta_description' => 'Get in touch with Glow Candles. We\'re here to answer your questions and help you find the perfect candle for your home.',
            'meta_keywords' => 'contact us, customer service, get in touch, faq, business hours',
            'is_active' => true
        ]);
    }
}
