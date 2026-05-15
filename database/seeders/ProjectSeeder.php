<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Facades\Log;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $xmlPath = public_path('modules-1/2849388066.xml');
        
        if (!file_exists($xmlPath)) {
            $this->command->warn('Sitejet XML not found. Creating placeholder projects.');
            
            $placeholders = [
                ['name' => 'Photography', 'hours_tag' => '8hrs', 'price_tag' => '$499'],
                ['name' => 'Data Science', 'hours_tag' => '12hrs', 'price_tag' => '$899'],
                ['name' => 'Finances', 'hours_tag' => '10hrs', 'price_tag' => '$799'],
                ['name' => 'Public Speaking', 'hours_tag' => '6hrs', 'price_tag' => '$399'],
                ['name' => 'Coding', 'hours_tag' => '24hrs', 'price_tag' => '$1499'],
            ];

            foreach ($placeholders as $index => $p) {
                Project::create([
                    'name' => $p['name'],
                    'hours_tag' => $p['hours_tag'],
                    'price_tag' => $p['price_tag'],
                    'order' => $index + 1,
                ]);
            }

            return;
        }

        $xml = simplexml_load_file($xmlPath);
        if (!$xml) {
            $this->command->error('Failed to parse Sitejet XML');
            return;
        }

        $items = (array) $xml->channel->item;
        $order = 1;

        foreach ($items as $item) {
            $name = (string) $item->title;
            $image = (string) $item->enclosure['url'];
            $link = (string) $item->link;
            
            Project::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => strip_tags((string) $item->description),
                    'image' => $image,
                    'image_alt' => $name,
                    'project_url' => $link,
                    'hours_tag' => null,
                    'price_tag' => null,
                    'order' => $order++,
                    'is_active' => true,
                ]
            );

            $this->command->line("  ✓ Imported: $name");
        }
    }
}
