<?php

namespace Feature\Exporters;

use FileExporter\Exceptions\Builders\CSVExporterLogicException;
use FileExporter\Exporters\CSVExporter;
use PHPUnit\Framework\TestCase;

/**
 * Class CSVExporterTest
 *
 * Test cases for the CSVExporter class.
 */
class CSVExporterTest extends TestCase
{
    /** @var array The test data for exporting. */
    protected array $data;

    /**
     * Set up the test data.
     */
    public function setUp(): void
    {
        $this->data = [
            ['Header 1.1', 'Header 1.2', 'Header 1.3'],
            ['Value 2.1', 'Value 2.1', 'Value 2.1']
        ];
    }

    /**
     * Test exporting data without headers.
     */
    public function testExport()
    {
        $exporter = new CSVExporter($this->data);

        $file = $exporter->export();

        $this->assertTrue($file->exists());
        $this->assertTrue($file->isFile());
        $this->assertNotTrue($file->isDirectory());
    }

    /**
     * Test exporting data with headers.
     */
    public function testExportWithHeaders()
    {
        $exporter = new CSVExporter($this->data);

        $headers = array_shift($this->data);

        $file = $exporter
            ->withHeaders($headers)
            ->export();

        $openedFile = $this->getFileContentAsArray($file->getPath());

        $getHeadersFromFile = array_shift($openedFile);

        $this->assertSame($headers, $getHeadersFromFile);
    }

    /**
     * Test exporting data with index.
     */
    public function testExportWithIndex()
    {
        $exporter = new CSVExporter($this->data);

        $this->expectException(CSVExporterLogicException::class);
        $this->expectExceptionMessage("You must set the headers to use this functionality with the exporter.");

        $exporter
            ->withIndex();
    }

    /**
     * Test exporting data with both headers and index.
     *
     * @throws CSVExporterLogicException
     */
    public function testExportWithIndexAndHeaders()
    {
        $headers = array_shift($this->data);
        $exporter = new CSVExporter($this->data);

        $file = $exporter
            ->withHeaders($headers)
            ->withIndex()
            ->export();

        $openedFile = $this->getFileContentAsArray($file->getPath());

        $getHeadersFromFile = array_shift($openedFile);

        array_unshift($headers, "#");

        $this->assertSame($headers, $getHeadersFromFile);
    }

    /**
     * Get file content as an array of arrays.
     *
     * @param string $filePath The path to the file.
     * @return array The file content as an array of arrays.
     */
    private function getFileContentAsArray(string $filePath): array
    {
        return array_map(
            "str_getcsv",
            file($filePath, FILE_SKIP_EMPTY_LINES)
        );
    }
}
