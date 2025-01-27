<?php
$urlComponents = parse_url($_SERVER['REQUEST_URI']);

// Initialize query string
$queryString = '';

// Check if there are existing query parameters
if (isset($urlComponents['query'])) {
    // Convert query string into an associative array
    parse_str($urlComponents['query'], $queryParams);
    // Remove the 'paginate' parameter if it exists
    unset($queryParams['paginate']);

    // Rebuild the query string without 'paginate'
    $queryString = http_build_query($queryParams);  
}

// Determine the protocol (HTTP or HTTPS)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Reconstruct the base URL
$baseUrl = $protocol . $_SERVER['HTTP_HOST'] . $urlComponents['path'];

$website_link = $protocol . $_SERVER['HTTP_HOST'];

// Append the cleaned query string if it exists
if (!empty($queryString)) {
    $baseUrl .= '?' . $queryString;
}

define('BASE_URL', $baseUrl);
