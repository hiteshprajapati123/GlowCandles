<?php

namespace Database\Seeders;

use App\Models\PrivacyPolicyPage;
use Illuminate\Database\Seeder;

class PrivacyPolicyPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrivacyPolicyPage::create([
            'banner_title' => 'Privacy Policy',
            'banner_subtitle' => 'Last Updated: ' . now()->format('F j, Y'),
            'introduction_title' => 'Introduction',
            'introduction_content' => 'At Glow Candles, we are committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or make a purchase from us.',
            'information_collection_title' => 'Information We Collect',
            'information_collection_content' => 'We collect several types of information from and about users of our website, including personal information, order information, technical data, and usage data.',
            'how_we_use_title' => 'How We Use Your Information',
            'how_we_use_content' => 'We use the information we collect for various purposes, including to process and fulfill your orders, communicate with you about your orders and account, respond to your customer service requests, and improve our website and services.',
            'information_sharing_title' => 'How We Share Your Information',
            'information_sharing_content' => 'We may share your personal information with third-party vendors who perform services on our behalf, such as payment processing, order fulfillment, and marketing assistance.',
            'data_security_title' => 'Data Security',
            'data_security_content' => 'We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.',
            'your_rights_title' => 'Your Rights',
            'your_rights_content' => 'Depending on your location, you may have certain rights regarding your personal information, including the right to access, correct, or delete your personal information.',
            'cookies_title' => 'Cookies and Tracking Technologies',
            'cookies_content' => 'We use cookies and similar tracking technologies to track activity on our website and hold certain information.',
            'third_party_links_title' => 'Third-Party Links',
            'third_party_links_content' => 'Our website may contain links to third-party websites. We are not responsible for the privacy practices or the content of such websites.',
            'children_privacy_title' => 'Children\'s Privacy',
            'children_privacy_content' => 'Our website is not intended for individuals under the age of 18. We do not knowingly collect personal information from children.',
            'policy_changes_title' => 'Changes to This Privacy Policy',
            'policy_changes_content' => 'We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page.',
            'contact_us_title' => 'Contact Us',
            'contact_us_content' => 'If you have any questions about this Privacy Policy, please contact us at privacy@glowcandles.in',
            'meta_title' => 'Privacy Policy | Glow Candles',
            'meta_description' => 'Read our privacy policy to understand how we collect, use, and protect your personal information when you use our website or make a purchase.',
            'meta_keywords' => 'privacy policy, data protection, personal information, cookies, data security',
            'is_active' => true
        ]);
    }
}
