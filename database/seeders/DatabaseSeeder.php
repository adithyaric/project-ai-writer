<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 1. Advertorial Layanan
        $advertorial = \App\Models\Layanan::create([
            'nama' => 'Advertorial',
        ]);

        \App\Models\InstruksiPrompt::create([
            'layanan_id' => $advertorial->id,
            'prompt_text' => 'Tulis sebuah advertorial mengenai {product_name} dengan tone {tone} untuk target audience {target_audience}. Fokuskan pada {key_features} dan jelaskan manfaatnya. Sertakan call to action yang menarik di akhir artikel.',
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $advertorial->id,
            'nama_field' => 'product_name',
            'tipe_field' => 'string',
            'required' => true,
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $advertorial->id,
            'nama_field' => 'tone',
            'tipe_field' => 'string',
            'required' => true,
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $advertorial->id,
            'nama_field' => 'target_audience',
            'tipe_field' => 'string',
            'required' => true,
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $advertorial->id,
            'nama_field' => 'key_features',
            'tipe_field' => 'textarea',
            'required' => true,
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $advertorial->id,
            'nama_field' => 'word_count',
            'tipe_field' => 'integer',
            'required' => true,
        ]);

        // 2. Backlink Layanan
        $backlink = \App\Models\Layanan::create([
            'nama' => 'Backlink',
        ]);

        \App\Models\InstruksiPrompt::create([
            'layanan_id' => $backlink->id,
            'prompt_text' => 'Buatkan artikel informatif tentang {topic} yang mencakup {keywords} secara natural. Artikel harus berkaitan dengan {niche} dan berisi {anchor_text} sebagai backlink ke {target_url}. Panjang artikel sekitar {word_count} kata.',
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $backlink->id,
            'nama_field' => 'topic',
            'tipe_field' => 'string',
            'required' => true,
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $backlink->id,
            'nama_field' => 'keywords',
            'tipe_field' => 'textarea',
            'required' => true,
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $backlink->id,
            'nama_field' => 'niche',
            'tipe_field' => 'string',
            'required' => true,
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $backlink->id,
            'nama_field' => 'anchor_text',
            'tipe_field' => 'string',
            'required' => true,
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $backlink->id,
            'nama_field' => 'target_url',
            'tipe_field' => 'string',
            'required' => true,
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $backlink->id,
            'nama_field' => 'word_count',
            'tipe_field' => 'integer',
            'required' => true,
        ]);

        // 3. Press Release Layanan
        $pressRelease = \App\Models\Layanan::create([
            'nama' => 'Press Release',
        ]);

        \App\Models\InstruksiPrompt::create([
            'layanan_id' => $pressRelease->id,
            'prompt_text' => 'Buatlah press release singkat untuk {company_name} tentang {announcement}. Sertakan kontak: {contact_email}.',
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $pressRelease->id,
            'nama_field' => 'company_name',
            'tipe_field' => 'string',
            'required' => true,
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $pressRelease->id,
            'nama_field' => 'announcement',
            'tipe_field' => 'textarea',
            'required' => true,
        ]);

        \App\Models\FormInputan::create([
            'layanan_id' => $pressRelease->id,
            'nama_field' => 'contact_email',
            'tipe_field' => 'string',
            'required' => true,
        ]);
    }
}
