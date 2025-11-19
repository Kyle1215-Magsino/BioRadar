# Replace all gradient backgrounds with solid colors
$files = Get-ChildItem -Path "c:\Users\91460\Desktop\jade\bioradar\resources\views" -Filter "*.blade.php" -Recurse

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    $modified = $false
    
    # Replace primary button gradients
    if ($content -match 'bg-gradient-to-r from-\[#40C9A2\] to-\[#1B9AAA\] text-white') {
        $content = $content -replace 'bg-gradient-to-r from-\[#40C9A2\] to-\[#1B9AAA\] text-white', 'bg-[#40C9A2] text-white'
        $modified = $true
    }
    
    if ($content -match 'bg-gradient-to-br from-\[#40C9A2\] to-\[#1B9AAA\]') {
        $content = $content -replace 'bg-gradient-to-br from-\[#40C9A2\] to-\[#1B9AAA\]', 'bg-[#40C9A2]'
        $modified = $true
    }
    
    # Replace light card gradients
    if ($content -match 'bg-gradient-to-r from-\[#D3F9D8\] to-\[#B2F2BB\]') {
        $content = $content -replace 'bg-gradient-to-r from-\[#D3F9D8\] to-\[#B2F2BB\]', 'bg-[#B2F2BB]'
        $modified = $true
    }
    
    if ($content -match 'bg-gradient-to-br from-\[#D3F9D8\] to-\[#B2F2BB\]') {
        $content = $content -replace 'bg-gradient-to-br from-\[#D3F9D8\] to-\[#B2F2BB\]', 'bg-[#D3F9D8]'
        $modified = $true
    }
    
    # Replace medium card gradients
    if ($content -match 'bg-gradient-to-r from-\[#B2F2BB\] to-\[#40C9A2\]') {
        $content = $content -replace 'bg-gradient-to-r from-\[#B2F2BB\] to-\[#40C9A2\]', 'bg-[#40C9A2]'
        $modified = $true
    }
    
    if ($content -match 'bg-gradient-to-br from-\[#B2F2BB\] to-\[#40C9A2\]') {
        $content = $content -replace 'bg-gradient-to-br from-\[#B2F2BB\] to-\[#40C9A2\]', 'bg-[#40C9A2]'
        $modified = $true
    }
    
    # Replace gradient text effects
    if ($content -match 'bg-gradient-to-r from-\[#1B9AAA\] to-\[#40C9A2\] bg-clip-text text-transparent') {
        $content = $content -replace 'bg-gradient-to-r from-\[#1B9AAA\] to-\[#40C9A2\] bg-clip-text text-transparent', 'text-[#1B9AAA]'
        $modified = $true
    }
    
    if ($content -match 'bg-gradient-to-r from-\[#40C9A2\] to-\[#1B9AAA\] bg-clip-text text-transparent') {
        $content = $content -replace 'bg-gradient-to-r from-\[#40C9A2\] to-\[#1B9AAA\] bg-clip-text text-transparent', 'text-[#40C9A2]'
        $modified = $true
    }
    
    if ($content -match 'bg-gradient-to-r from-\[#B2F2BB\] to-\[#40C9A2\] bg-clip-text text-transparent') {
        $content = $content -replace 'bg-gradient-to-r from-\[#B2F2BB\] to-\[#40C9A2\] bg-clip-text text-transparent', 'text-[#40C9A2]'
        $modified = $true
    }
    
    # Replace other gradients
    if ($content -match 'bg-gradient-to-r from-\[#D3F9D8\] to-white') {
        $content = $content -replace 'bg-gradient-to-r from-\[#D3F9D8\] to-white', 'bg-[#D3F9D8]'
        $modified = $true
    }
    
    if ($content -match 'bg-gradient-to-r from-\[#B2F2BB\] to-\[#D3F9D8\]') {
        $content = $content -replace 'bg-gradient-to-r from-\[#B2F2BB\] to-\[#D3F9D8\]', 'bg-[#B2F2BB]'
        $modified = $true
    }
    
    if ($content -match 'bg-gradient-to-br from-\[#40C9A2\] to-\[#B2F2BB\]') {
        $content = $content -replace 'bg-gradient-to-br from-\[#40C9A2\] to-\[#B2F2BB\]', 'bg-[#40C9A2]'
        $modified = $true
    }
    
    if ($modified) {
        Set-Content -Path $file.FullName -Value $content -NoNewline
        Write-Host "Updated: $($file.Name)" -ForegroundColor Green
    }
}

Write-Host "`nDone replacing gradients with solid colors!" -ForegroundColor Cyan
