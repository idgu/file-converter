<?php
include '../vendor/autoload.php';

use App\Misc\FileSaver;
use App\Factories\Text\TextFactory;

if (FileSaver::issetFileToSave('source_file')) {
    $fileSaver = new FileSaver();
    $fileSaver->save('source_file', uniqid(), '../var/temp', ['application/xml', 'application/json', 'text/plain']);

    if ($fileSaver->hasErrors()) {
        $fileSaver->displayErrors();
        die();
    } else {
        $textFactory = new TextFactory();
        if($outputMaker = $textFactory->make($_POST['output_type']))
        {
            if($fileSaver->getFile()->prepareData()){
                $output = $outputMaker->output($fileSaver->file->getFileData());
                unlink($fileSaver->getFile()->getFilePath());
                $outputMaker->headers();
                print($output);
                die();
            }
        }

    }

    unlink($fileSaver->getFile()->getFilePath());

    echo 'Something is wrong...';
    die();
}

?>

<form method="POST" enctype="multipart/form-data">
    <label for="file">File:</label>
    <input type="file" name="source_file" id="file" value=""/><br>
    <label for="outputType">Convert to:</label>
    <select name="output_type" id="outputType">
        <option value="xml">XML</option>
        <option value="json">JSON</option>
    </select>
    <input type="submit" value="Convert"/>
</form>
