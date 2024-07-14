<?php
/*--------------------------------------------------------------
   download.php 2021-11-08
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2021 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
 -------------------------------------------------------------*/

declare(strict_types=1);

$zipFile  = 'download.zip';
$rootPath = realpath(__DIR__ . '/vrt/latest');
$zip      = new ZipArchive;

$zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);

foreach ($files as $name => $file)
{
    if (!$file->isDir())
    {
        $filePath     = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);
        
        $zip->addFile($filePath, $relativePath);
    }
}

$zip->close();

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($zipFile));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($zipFile));
readfile($zipFile);