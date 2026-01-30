<?php

namespace App\Enums;

enum UploadStatus: string
{
    case PENDING = 'pending';
    case IMAGE_PROCESSING = 'image_processing';
    case FINAL_PROCESSING = 'final_processing';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}
