<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function actingAsAdmin()
    {
        return parent::actingAs(App\User::admin()->first());
    }


    public function assertHTTPExceptionStatus($expectedStatusCode, Closure $codeThatShouldThrow)
    {
        try
        {
            $codeThatShouldThrow($this);

            $this->assertFalse(true, "An HttpException should have been thrown by the provided Closure.");
        }
        catch (HttpException $e)
        {
            // assertResponseStatus() won't work because the response object is null
            $this->assertEquals(
                $expectedStatusCode,
                $e->getStatusCode(),
                sprintf("Expected an HTTP status of %d but got %d.", $expectedStatusCode, $e->getStatusCode())
            );
        }
    }

    public function prepareFileUpload($path)
    {
        $this->assertFileExists($path);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $mime = finfo_file($finfo, $path);

        return new \Symfony\Component\HttpFoundation\File\UploadedFile ($path, null, $mime, null, null, true);
    }
}
