<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Document Storage Disk
    |--------------------------------------------------------------------------
    |
    | The filesystem disk where documents should be stored.
    | Options: 'local', 's3', or any other configured disk.
    |
    */

    'disk' => env('DOCUMENTS_DISK', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Storage Directory
    |--------------------------------------------------------------------------
    |
    | The base directory path where documents will be stored.
    | For S3, this will be the prefix/folder in the bucket.
    |
    */

    'directory' => env('DOCUMENTS_DIRECTORY', 'work-application-documents'),

    /*
    |--------------------------------------------------------------------------
    | File Visibility
    |--------------------------------------------------------------------------
    |
    | The visibility of uploaded documents.
    | Options: 'private', 'public'
    |
    */

    'visibility' => env('DOCUMENTS_VISIBILITY', 'private'),

    /*
    |--------------------------------------------------------------------------
    | Maximum File Size
    |--------------------------------------------------------------------------
    |
    | Maximum file size in kilobytes for a single document upload.
    |
    */

    'max_file_size' => env('DOCUMENTS_MAX_FILE_SIZE', 8192), // 8MB

    /*
    |--------------------------------------------------------------------------
    | User Storage Quota
    |--------------------------------------------------------------------------
    |
    | Maximum total storage space in megabytes allowed per user.
    |
    */

    'user_quota_mb' => env('DOCUMENTS_USER_QUOTA_MB', 100),

    /*
    |--------------------------------------------------------------------------
    | Accepted File Types
    |--------------------------------------------------------------------------
    |
    | MIME types that are allowed for document uploads.
    |
    */

    'accepted_file_types' => [
        'application/pdf',
    ],

];