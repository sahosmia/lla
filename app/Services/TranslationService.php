<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Models\Language;


class TranslationService
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
        $this->translator->setOptions([
            'verify' => false,
        ]);
    }

    public function getAllTranslations() {
        $languages = [];
        $baseLangPath = base_path('lang/en');
        $modulesPath = base_path('Modules');
        $packagesPath = base_path('packages');  // Path to the packages directory
    
        // Check for translations in the base language path
        if (File::exists($baseLangPath)) {
            $languages['lang/en'] = $this->scanLangDirectory($baseLangPath);
        }
    
        // Check for translations in the modules path
        if (File::exists($modulesPath)) {
            foreach (File::directories($modulesPath) as $module) {
                $moduleName = basename($module);
                $moduleLangPath = "{$module}/resources/lang/en";
    
                if (File::exists($moduleLangPath)) {
                    $languages["Modules/{$moduleName}"] = $this->scanLangDirectory($moduleLangPath);
                }
            }
        }
    
        // Check for translations in the packages path
        if (File::exists($packagesPath)) {
            foreach (File::directories($packagesPath) as $package) {
                $packageName = basename($package);
                $packageLangPath = "{$package}/lang/en"; 
    
                if (File::exists($packageLangPath)) {
                    $languages["packages/{$packageName}"] = $this->scanLangDirectory($packageLangPath);
                }
            }
        }
    
        return $languages;
    }
    
    private function scanLangDirectory($path)
    {
        $result = [];

        foreach (File::directories($path) as $dir) {
            $dirName            = basename($dir);
            $result[$dirName]   = $this->scanLangDirectory($dir);
        }
    
        foreach (File::files($path) as $file) {
            $result[] = pathinfo($file)['filename'];
        }
    
        return $result;
    }

    public function translateFileHandler($file, $targetLang)
    {
        // Handle files not in the "Modules/" directory
        if (! str_starts_with($file, 'Modules/') && ! str_starts_with($file, 'packages/')) {
    
            $fileName       = basename($file);  
            $folderPath     = dirname($file); 
            $segments       = explode('/', $folderPath); 
            $currentLang    = $segments[1] ?? 'en';   
            $segments[1]    = $targetLang;           
            $newFolderPath  = implode('/', $segments); 
            $sourceFile     = base_path("{$file}.php"); 
            $targetFile     = base_path("{$newFolderPath}/{$fileName}.php");  
    
            if (File::exists($sourceFile)) {
                return $this->translateSelected($sourceFile, $targetFile, $targetLang);
            } else {
                \Log::warning("Admin lang file not found: {$sourceFile}");
            }
    
        // Handle files in "Modules/" directory
        } else if (str_starts_with($file, 'Modules/')) { 
    
            $parts      = explode('/', $file);
            $moduleName = $parts[1] ?? null;
            $fileName   = basename($file); 
    
            if ($moduleName) {
                $sourceFile = base_path("Modules/{$moduleName}/resources/lang/en/{$fileName}.php");
                $targetFile = base_path("Modules/{$moduleName}/resources/lang/{$targetLang}/{$fileName}.php");
    
                if (File::exists($sourceFile)) {
                    return $this->translateSelected($sourceFile, $targetFile, $targetLang);
                } else {
                    \Log::warning("Module lang file not found: {$sourceFile}");
                }
            } else {
                \Log::warning("Invalid module file structure: {$file}");
            }
    
        // Handle files in "packages/" directory
        } else if (str_starts_with($file, 'packages/')) {
            
            $parts      = explode('/', $file);
            $packageName = $parts[1] ?? null;
            $fileName   = basename($file); 
            if ($packageName) {
                // Path for the source language file in packages
                $sourceFile = base_path("packages/{$packageName}/lang/en/{$fileName}.php");
                $targetFile = base_path("packages/{$packageName}/lang/{$targetLang}/{$fileName}.php");
                if (File::exists($sourceFile)) {
                    return $this->translateSelected($sourceFile, $targetFile, $targetLang);
                } else {
                    \Log::warning("Package lang file not found: {$sourceFile}");
                }
            } else {
                \Log::warning("Invalid package file structure: {$file}");
            }
        }
    }
    
    
    public function translateSelected(string $param1, string $param2, string $param3 = 'en')
    {   
        // if (!is_writable($param1)) {
        //     return "The target language directory is not writable: {$param1}";
        // }
        if (str_contains($param1, base_path())) {
            [$sourceFile, $targetFile, $targetLang] = func_get_args();
            return $this->translateSelectedFile($sourceFile, $targetFile, $targetLang);
        } 
        else {
            [$targetLang, $selectedFile, $sourceLang] = func_get_args();
    
            $sourcePath = base_path("lang/{$sourceLang}");
            $targetPath = base_path("lang/{$targetLang}");
    
            if (!File::exists($sourcePath)) {
                throw new \Exception("Source language directory does not exist: {$sourcePath}");
            }
    
            if (!File::exists($targetPath)) {
                File::makeDirectory($targetPath, 0755, true, true);
            }
    
            $sourceFile = "{$sourcePath}/{$selectedFile}.php";
            $targetFile = "{$targetPath}/{$selectedFile}.php";
    
            if (File::exists($sourceFile)) {
                return $this->translateSelectedFile($sourceFile, $targetFile, $targetLang);
            } else {
                \Log::warning("File does not exist in source language: {$sourceFile}");
            }
        }
    }
    
    private function translateSelectedFile(string $sourcePath, string $targetPath, string $targetLang)
    {
        if (!File::exists($sourcePath)) {
            return;
        }

        if (File::isFile($sourcePath)) {
            return $this->translateFile($sourcePath, $targetPath, $targetLang);
        } elseif (File::isDirectory($sourcePath)) {
            foreach (File::allFiles($sourcePath) as $file) {
                return $this->translateFile($file->getPathname(), $targetPath, $targetLang);
            }

            foreach (File::directories($sourcePath) as $subDir) {
                $subDirName     = basename($subDir);
                $newSourcePath  = "{$sourcePath}/{$subDirName}";
                $newTargetPath  = "{$targetPath}/{$subDirName}";

                $this->translateSelectedFile($newSourcePath, $newTargetPath, $targetLang);
            }
        }
    }

    private function translateFile(string $sourceFile, string $targetPath, string $targetLang)
    {
        $content    = include $sourceFile;
        $translated = $this->translateArray($content, $targetLang);
    
        $dir = dirname($targetPath);
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true, true); 
        }
        if (!is_writable($dir)) {
           return "Check the parent directory is writable.: {$dir}.";
        }
        file_put_contents(
            $targetPath,
            "<?php\n\nreturn " . var_export($translated, true) . ";\n"
        );
    }
    
    
private function translateArray(array $array, string $targetLang)
{
    $this->translator->setTarget($targetLang);

    $flatKeys = [];
    $flatTexts = [];

    $iterator = function ($array, $prefix = '') use (&$iterator, &$flatKeys, &$flatTexts) {
        foreach ($array as $key => $value) {
            $fullKey = $prefix === '' ? $key : $prefix . '.' . $key;
            if (is_array($value)) {
                $iterator($value, $fullKey);
            } else {
                $flatKeys[] = $fullKey;
                $flatTexts[] = $value;
            }
        }
    };

    $iterator($array);

    if (empty($flatTexts)) {
        return $array;
    }

    $translatedTexts = [];

    $batchSize = 20;
    foreach (array_chunk($flatTexts, $batchSize) as $batch) {
        $joined = implode("\n", $batch);
        $translatedJoined = $this->translator
        ->preserveParameters('/(:\w+|\{\{\s*\w+\s*\}\}|\{\w+\})/')
        ->translate($joined);    
        $batchTranslated = explode("\n", $translatedJoined);
        $translatedTexts = array_merge($translatedTexts, $batchTranslated);
    }

    $translatedArray = [];

    foreach ($flatKeys as $index => $fullKey) {
        $segments = explode('.', $fullKey);
        $current = &$translatedArray;

        foreach ($segments as $segment) {
            if (!isset($current[$segment])) {
                $current[$segment] = [];
            }
            $current = &$current[$segment];
        }

        $current = $translatedTexts[$index] ?? $flatTexts[$index];
    }

    return $translatedArray;
}


}
