<?php
// Start output buffering
ob_start();

// Set cache control headers
header('Cache-Control: public, max-age=31536000'); // 1 year
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
header('Vary: Accept-Encoding');

// Set content type
header('Content-Type: text/html; charset=utf-8');
?> 