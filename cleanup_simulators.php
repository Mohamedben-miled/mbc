<?php
/**
 * Script to clean up simulator modals and replace with includes
 */

$files = [
    'index.php',
    'mbc.php', 
    'services.php',
    'contact-form.php',
    'blog-dynamic.php',
    'blog-post.php',
    'simulators.php',
    'contact.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) {
        echo "File $file not found, skipping...\n";
        continue;
    }
    
    echo "Processing $file...\n";
    
    $content = file_get_contents($file);
    
    // Find the start of the simulators modal
    $modalStart = strpos($content, '<!-- Simulators Modal -->');
    if ($modalStart === false) {
        echo "No simulators modal found in $file\n";
        continue;
    }
    
    // Find the end of the modal (before Scripts section)
    $scriptsStart = strpos($content, '<!-- Scripts -->', $modalStart);
    if ($scriptsStart === false) {
        $scriptsStart = strpos($content, '<script src="script.js">', $modalStart);
    }
    
    if ($scriptsStart === false) {
        echo "No scripts section found in $file\n";
        continue;
    }
    
    // Replace the modal content with the include
    $beforeModal = substr($content, 0, $modalStart);
    $afterScripts = substr($content, $scriptsStart);
    
    $newContent = $beforeModal . 
        "    <?php include 'includes/simulators-modal.php'; ?>\n\n" . 
        $afterScripts;
    
    file_put_contents($file, $newContent);
    echo "Cleaned $file successfully\n";
}

echo "All files processed!\n";
?>
