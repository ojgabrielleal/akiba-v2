<?php

$controllersDir = __DIR__ . '/app/Http/Controllers/Private';
$requestsDir = __DIR__ . '/app/Http/Requests';

function getRequestName($controllerName, $methodName) {
    $namespace = str_replace('Controller', '', $controllerName);
    $reqClass = '';
    
    if (strpos($methodName, 'create') === 0) {
        $reqClass = 'Store' . substr($methodName, 6) . 'Request';
    } elseif (strpos($methodName, 'update') === 0) {
        if ($methodName === 'updateUserAccess') {
            $reqClass = 'UpdateUserAccessRequest';
        } else {
            $reqClass = 'Update' . substr($methodName, 6) . 'Request';
        }
    } elseif ($methodName === 'login') {
        $namespace = 'Auth';
        $reqClass = 'AuthLoginRequest';
    } elseif ($methodName === 'startLocution') {
        $namespace = 'Locution';
        $reqClass = 'StartLocutionRequest';
    }
    
    return [$namespace, $reqClass];
}

$files = scandir($controllersDir);

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') continue;
    
    $path = $controllersDir . '/' . $file;
    $content = file_get_contents($path);
    $controllerName = basename($file, '.php');
    
    // identify methods with $request->validate([...])
    $pattern = '/public function (\w+)\(Request \$request[^\)]*\)\s*\{(.*?)\$request->validate\(\[(.*?)\]\);/s';
    
    if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
        $importStatements = [];
        
        foreach ($matches as $match) {
            $fullMatch = $match[0];
            $methodName = $match[1];
            $beforeValidate = $match[2];
            $rules = $match[3];
            
            list($namespace, $reqClass) = getRequestName($controllerName, $methodName);
            if (!$reqClass) continue;
            
            // update controller method signature
            $sigPattern = '/public function ' . $methodName . '\(Request \$request(.*?)\)/';
            $content = preg_replace($sigPattern, 'public function ' . $methodName . '(' . $reqClass . ' $request$1)', $content);
            
            // remove validate block
            $validateBlockStr = '$request->validate([' . $rules . ']);';
            $content = str_replace($validateBlockStr, '', $content);
            
            $importStatements[] = "use App\Http\Requests\\{$namespace}\\{$reqClass};";
            
            // update the Request class file
            $reqPath = $requestsDir . '/' . $namespace . '/' . $reqClass . '.php';
            if (file_exists($reqPath)) {
                $reqContent = file_get_contents($reqPath);
                $reqContent = str_replace('return false;', 'return true;', $reqContent);
                
                $formattedRules = trim($rules);
                $rulesPattern = '/public function rules\(\): array\s*\{\s*return \[\s*\/\/[\s\r\n]*\];\s*\}/';
                $replacement = "public function rules(): array\n    {\n        return [\n            $formattedRules\n        ];\n    }";
                $reqContent = preg_replace($rulesPattern, $replacement, $reqContent);
                
                file_put_contents($reqPath, $reqContent);
            }
        }
        
        if (!empty($importStatements)) {
            $importStatements = array_unique($importStatements);
            $importBlock = implode("\n", $importStatements) . "\n";
            $content = str_replace("use Illuminate\\Http\\Request;", "use Illuminate\\Http\\Request;\n" . $importBlock, $content);
        }
        
        file_put_contents($path, $content);
        echo "Updated $file\n";
    }
}

echo "Done.\n";
