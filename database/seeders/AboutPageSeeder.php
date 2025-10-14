<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutPage::create([
            'banner_title' => 'About Glow Candles',
            'banner_subtitle' => 'Crafting moments of warmth and serenity through the gentle glow of our hand-poured candles',
            'section1_title' => 'Our Story',
            'section1_content' => 'Founded in 2023, Glow Candles began as a small passion project in a home kitchen. What started as a simple love for handcrafted candles has grown into a beloved brand known for quality, sustainability, and beautiful designs.',
            'mission_title' => 'Our Mission',
            'mission_content' => 'Our mission is to create sustainable, high-quality candles that enhance your living space while being kind to the environment.',
            'vision_title' => 'Our Vision',
            'vision_content' => 'To illuminate homes worldwide with our eco-friendly candles while maintaining our commitment to sustainability and craftsmanship.',
            'team_section_title' => 'Meet Our Team',
            'team_section_subtitle' => 'Passionate individuals dedicated to bringing light to your life',
            'meta_title' => 'About Us | Glow Candles',
            'meta_description' => 'Learn about Glow Candles, our story, mission, and commitment to creating sustainable, handcrafted candles.',
            'meta_keywords' => 'about us, glow candles, our story, mission, vision, team',
            'is_active' => true
        ]);
    }
}
