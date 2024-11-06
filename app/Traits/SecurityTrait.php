<?php

// namespace App\Traits;

// use CodeIgniter\HTTP\RequestInterface;
// use CodeIgniter\Exceptions\PageNotFoundException;

// trait SecurityTrait
// {
//     /**
//      * Validates a slug against injection and traversal attempts
//      */
//     protected function validateSlug(string $slug): bool
//     {
//         return preg_match('/^[a-z0-9-]+$/', $slug) === 1;
//     }

//     /**
//      * Safely resolves a file path preventing directory traversal
//      */
//     protected function getSecurePath(string $basePath, string $filename): string
//     {
//         // Clean the base path
//         $basePath = rtrim($basePath, '/\\');
        
//         // Clean the filename
//         $filename = basename($filename);
        
//         // Create and validate the full path
//         $fullPath = realpath($basePath) . DIRECTORY_SEPARATOR . $filename;
        
//         // Verify the path is within the base directory
//         if (!$fullPath || strpos($fullPath, realpath($basePath)) !== 0) {
//             throw new PageNotFoundException('Invalid file path');
//         }
        
//         return $fullPath;
//     }

//     /**
//      * Validates file upload
//      */
//     protected function validateFileUpload($file, array $allowedTypes = [], int $maxSize = 5242880): bool
//     {
//         if (!$file->isValid()) {
//             throw new \RuntimeException('Invalid file upload');
//         }

//         // Default allowed types if none specified
//         $allowedTypes = $allowedTypes ?: ['image/jpeg', 'image/png', 'image/gif'];

//         // Validate file type
//         if (!in_array($file->getMimeType(), $allowedTypes)) {
//             throw new \RuntimeException('Invalid file type. Allowed types: ' . implode(', ', $allowedTypes));
//         }

//         // Validate file size (default 5MB)
//         if ($file->getSize() > $maxSize) {
//             throw new \RuntimeException('File size exceeds limit');
//         }

//         return true;
//     }

//     /**
//      * Handles file uploads securely
//      */
//     protected function handleSecureFileUpload($file, string $uploadPath, ?string $oldFile = null): string
//     {
//         try {
//             // Validate upload
//             $this->validateFileUpload($file);

//             // Create upload directory if it doesn't exist
//             if (!is_dir($uploadPath)) {
//                 mkdir($uploadPath, 0755, true);
//             }

//             // Generate secure filename
//             $newName = $file->getRandomName();

//             // Move file
//             $file->move($uploadPath, $newName);

//             // Clean up old file if exists
//             if ($oldFile && file_exists($oldFile)) {
//                 unlink($oldFile);
//             }

//             return $newName;

//         } catch (\Exception $e) {
//             log_message('error', 'File upload failed: ' . $e->getMessage());
//             throw new \RuntimeException('File upload failed');
//         }
//     }

//     /**
//      * Validates and sanitizes input data
//      */
//     protected function sanitizeInput(array $data, array $rules = []): array
//     {
//         $sanitized = [];
        
//         foreach ($data as $key => $value) {
//             // Apply specific rules if they exist
//             if (isset($rules[$key])) {
//                 $value = $this->applySanitizationRules($value, $rules[$key]);
//             }
            
//             // Default sanitization
//             if (is_string($value)) {
//                 $value = strip_tags($value);
//                 $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
//             }
            
//             $sanitized[$key] = $value;
//         }
        
//         return $sanitized;
//     }

//     /**
//      * Applies specific sanitization rules
//      */
//     private function applySanitizationRules($value, array $rules)
//     {
//         foreach ($rules as $rule) {
//             switch ($rule) {
//                 case 'trim':
//                     $value = trim($value);
//                     break;
//                 case 'lowercase':
//                     $value = strtolower($value);
//                     break;
//                 case 'uppercase':
//                     $value = strtoupper($value);
//                     break;
//                 case 'numeric':
//                     $value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, 
//                         FILTER_FLAG_ALLOW_FRACTION);
//                     break;
//                 case 'email':
//                     $value = filter_var($value, FILTER_SANITIZE_EMAIL);
//                     break;
//                 case 'url':
//                     $value = filter_var($value, FILTER_SANITIZE_URL);
//                     break;
//             }
//         }
        
//         return $value;
//     }
// }