<?php

namespace FileExporter\Helpers;

use FileExporter\Contracts\FileContract;

/**
 * Class File
 *
 * Helper class for file-related operations.
 */
class File implements FileContract
{
    /** @var string $file_path The path to the file. */
    private string $file_path;

    /**
     * Constructor.
     *
     * @param string $file_path The path to the file.
     */
    public function __construct(string $file_path) {
        $this->file_path = $file_path;
    }

    /**
     * Get the MIME type of the file.
     *
     * @return string The MIME type.
     */
    public function getMimeType(): string
    {
        $mime_type = mime_content_type($this->file_path);
        return $mime_type !== false ? $mime_type : 'unknown';
    }

    /**
     * Get the extension of the file.
     *
     * @return string The file extension.
     */
    public function getExtension(): string
    {
        $extension = pathinfo($this->file_path, PATHINFO_EXTENSION);
        return $extension !== '' ? $extension : 'unknown';
    }

    /**
     * Get the filename of the file.
     *
     * @return string The filename.
     */
    public function getFileName(): string
    {
        return pathinfo($this->file_path, PATHINFO_FILENAME);
    }

    /**
     * Get the base path of the file.
     *
     * @return string The base path.
     */
    public function getBasePath(): string
    {
        return pathinfo($this->file_path, PATHINFO_DIRNAME);
    }

    /**
     * Get the path of the file.
     *
     * @return string The base path.
     */
    public function getPath(): string
    {
        return $this->file_path;
    }

    /**
     * Get the size of the file.
     *
     * @return int The file size in bytes.
     */
    public function getFileSize(): int
    {
        return filesize($this->file_path);
    }

    /**
     * Check if the file exists.
     *
     * @return bool True if the file exists, false otherwise.
     */
    public function exists(): bool
    {
        return file_exists($this->file_path);
    }

    /**
     * Check if the path is a file.
     *
     * @return bool True if the path is a file, false otherwise.
     */
    public function isFile(): bool
    {
        return is_file($this->file_path);
    }

    /**
     * Check if the path is a directory.
     *
     * @return bool True if the path is a directory, false otherwise.
     */
    public function isDirectory(): bool
    {
        return is_dir($this->file_path);
    }

    /**
     * Get the creation time of the file.
     *
     * @return false|int The creation time as a Unix timestamp, or false on failure.
     */
    public function getCreationTime()
    {
        return filectime($this->file_path);
    }

    /**
     * Get the last modification time of the file.
     *
     * @return false|int The last modification time as a Unix timestamp, or false on failure.
     */
    public function getModificationTime()
    {
        return filemtime($this->file_path);
    }

    /**
     * Get the contents of the file.
     *
     * @return false|string The file contents as a string, or false on failure.
     */
    public function getContent(): string
    {
        return file_get_contents($this->file_path);
    }
}