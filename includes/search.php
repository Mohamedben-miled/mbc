<?php
/**
 * Advanced Site Search System
 * Searches across all public pages (non-admin)
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/blog.php';

class SiteSearch {
    private $db;
    private $blog;

    // Pages to search (excluding admin)
    private $searchablePages = [
        'index.php' => ['title' => 'Accueil', 'sections' => ['hero', 'services', 'about', 'testimonials']],
        'mbc.php' => ['title' => 'MBC', 'sections' => ['hero', 'expertise', 'values', 'team']],
        'about-us.php' => ['title' => 'À propos', 'sections' => ['hero', 'atouts', 'logiciels', 'prestations']],
        'services.php' => ['title' => 'Services', 'sections' => ['hero', 'services-list', 'simulators']],
        'blog-dynamic.php' => ['title' => 'Ressources et documentation', 'sections' => ['hero', 'articles']],
        'contact-form.php' => ['title' => 'Contact', 'sections' => ['hero', 'contact-info', 'form']]
    ];

    public function __construct() {
        $this->db = Database::getInstance();
        $this->blog = new Blog();
    }

    /**
     * Search across all pages
     */
    public function search($query, $limit = 20) {
        if (empty($query) || strlen($query) < 2) {
            return [];
        }

        $results = [];
        $searchTerm = '%' . $query . '%';

        // Search in blog posts
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    id,
                    title,
                    content,
                    excerpt,
                    'blog' as type,
                    CONCAT('blog-post.php?id=', id) as url,
                    'article' as section
                FROM blog_posts
                WHERE status = 'published'
                AND (title LIKE ? OR content LIKE ? OR excerpt LIKE ?)
                LIMIT ?
            ");
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $limit]);
            $blogResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($blogResults as $post) {
                $results[] = [
                    'title' => $post['title'],
                    'content' => $this->extractSnippet($post['content'] . ' ' . $post['excerpt'], $query),
                    'url' => 'blog-post.php?id=' . $post['id'],
                    'type' => 'blog',
                    'section' => 'Article de blog',
                    'page_title' => 'Ressources et documentation'
                ];
            }
        } catch (PDOException $e) {
            error_log("Search error: " . $e->getMessage());
        }

        // Search in static pages (we'll search file contents)
        $results = array_merge($results, $this->searchStaticPages($query, $limit));

        return $results;
    }

    /**
     * Search in static pages by reading file contents
     */
    private function searchStaticPages($query, $limit) {
        $results = [];
        $basePath = __DIR__ . '/../';

        foreach ($this->searchablePages as $file => $pageInfo) {
            $filePath = $basePath . $file;
            if (!file_exists($filePath)) continue;

            $content = file_get_contents($filePath);
            $lowerQuery = strtolower($query);
            $lowerContent = strtolower($content);

            // Search in title and content
            if (strpos($lowerContent, $lowerQuery) !== false) {
                // Extract relevant sections
                $sections = $this->findSectionsInContent($content, $query);
                
                foreach ($sections as $section) {
                    $results[] = [
                        'title' => $pageInfo['title'],
                        'content' => $section['snippet'],
                        'url' => $file . $section['anchor'],
                        'type' => 'page',
                        'section' => $section['name'],
                        'page_title' => $pageInfo['title']
                    ];

                    if (count($results) >= $limit) break;
                }
            }
        }

        return array_slice($results, 0, $limit);
    }

    /**
     * Find relevant sections in page content
     */
    private function findSectionsInContent($content, $query) {
        $sections = [];
        $lowerQuery = strtolower($query);

        // Search for headings and nearby content
        preg_match_all('/<h[1-6][^>]*>(.*?)<\/h[1-6]>.*?<p[^>]*>(.*?)<\/p>/is', $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $heading = strip_tags($match[1]);
            $paragraph = strip_tags($match[2]);
            
            if (stripos($paragraph, $query) !== false || stripos($heading, $query) !== false) {
                $anchor = $this->generateAnchor($heading);
                $sections[] = [
                    'name' => $heading,
                    'snippet' => $this->extractSnippet($paragraph, $query),
                    'anchor' => '#' . $anchor
                ];
            }
        }

        return $sections;
    }

    /**
     * Extract snippet with context around search term
     */
    private function extractSnippet($text, $query, $length = 150) {
        $text = strip_tags($text);
        $lowerText = strtolower($text);
        $lowerQuery = strtolower($query);
        
        $pos = strpos($lowerText, $lowerQuery);
        if ($pos === false) {
            return substr($text, 0, $length) . '...';
        }

        $start = max(0, $pos - 50);
        $snippet = substr($text, $start, $length);
        
        if ($start > 0) $snippet = '...' . $snippet;
        if (strlen($text) > $start + $length) $snippet .= '...';

        return $snippet;
    }

    /**
     * Generate anchor from heading
     */
    private function generateAnchor($text) {
        $anchor = strtolower($text);
        $anchor = preg_replace('/[^a-z0-9]+/', '-', $anchor);
        $anchor = trim($anchor, '-');
        return $anchor;
    }
}

