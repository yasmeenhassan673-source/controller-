<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    public function test_upload_page_can_be_rendered(): void
    {
        $response = $this->get('/upload');
        $response->assertStatus(200);
        $response->assertSee('Upload File');
    }

    public function test_file_upload_requires_a_file(): void
    {
        $response = $this->post('/upload', []);
        $response->assertSessionHasErrors(['file']);
    }

    public function test_file_can_be_uploaded_successfully(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.html', 50, 'text/html');

        $response = $this->post('/upload', [
            'file' => $file,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');

        // Check file was stored on the public disk inside uploads directory
        $files = Storage::disk('public')->files('uploads');
        $this->assertCount(1, $files);
    }
}

