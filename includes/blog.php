<?php
/**
 * Blog Management System for MBC Website
 */

require_once __DIR__ . '/../config/database.php';

class Blog {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get all blog posts with pagination
     */
    public function getPosts($page = 1, $limit = 10, $status = 'published') {
        try {
            $offset = ($page - 1) * $limit;
            $whereClause = $status ? "WHERE status = ?" : "";
            $params = $status ? [$status] : [];
            
            $sql = "SELECT bp.*, u.full_name as author_name 
                    FROM blog_posts bp 
                    JOIN users u ON bp.author_id = u.id 
                    $whereClause 
                    ORDER BY bp.created_at DESC 
                    LIMIT ? OFFSET ?";
            
            $params[] = $limit;
            $params[] = $offset;
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get posts error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all blog posts (alias for getPosts)
     */
    public function getAllPosts($page = 1, $limit = 10) {
        return $this->getPosts($page, $limit, 'published');
    }

    /**
     * Get single blog post by ID
     */
    public function getPost($id) {
        try {
            $stmt = $this->db->prepare("
                SELECT bp.*, u.full_name as author_name 
                FROM blog_posts bp 
                JOIN users u ON bp.author_id = u.id 
                WHERE bp.id = ?
            ");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Get post error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create new blog post
     */
    public function createPost($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO blog_posts (title, content, excerpt, cover_image, content_file, read_time, author_id, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            return $stmt->execute([
                $data['title'],
                $data['content'],
                $data['excerpt'] ?? '',
                $data['cover_image'] ?? '',
                $data['content_file'] ?? '',
                $data['read_time'],
                $data['author_id'],
                $data['status'] ?? 'draft'
            ]);
        } catch (PDOException $e) {
            error_log("Create post error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update blog post
     */
    public function updatePost($id, $data) {
        try {
            $fields = [];
            $values = [];

            if (isset($data['title'])) {
                $fields[] = "title = ?";
                $values[] = $data['title'];
            }

            if (isset($data['content'])) {
                $fields[] = "content = ?";
                $values[] = $data['content'];
            }

            if (isset($data['excerpt'])) {
                $fields[] = "excerpt = ?";
                $values[] = $data['excerpt'];
            }

            if (isset($data['cover_image'])) {
                $fields[] = "cover_image = ?";
                $values[] = $data['cover_image'];
            }

            if (isset($data['content_file'])) {
                $fields[] = "content_file = ?";
                $values[] = $data['content_file'];
            }

            if (isset($data['read_time'])) {
                $fields[] = "read_time = ?";
                $values[] = $data['read_time'];
            }

            if (isset($data['status'])) {
                $fields[] = "status = ?";
                $values[] = $data['status'];
            }

            if (empty($fields)) {
                return false;
            }

            $values[] = $id;
            $sql = "UPDATE blog_posts SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute($values);
        } catch (PDOException $e) {
            error_log("Update post error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete blog post
     */
    public function deletePost($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM blog_posts WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete post error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get blog categories
     */
    public function getCategories() {
        try {
            $stmt = $this->db->query("SELECT * FROM blog_categories ORDER BY name");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get categories error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get posts by category
     */
    public function getPostsByCategory($categoryId, $page = 1, $limit = 10) {
        try {
            $offset = ($page - 1) * $limit;
            $stmt = $this->db->prepare("
                SELECT bp.*, u.full_name as author_name 
                FROM blog_posts bp 
                JOIN users u ON bp.author_id = u.id 
                JOIN blog_post_categories bpc ON bp.id = bpc.post_id
                WHERE bpc.category_id = ? AND bp.status = 'published'
                ORDER BY bp.created_at DESC 
                LIMIT ? OFFSET ?
            ");
            $stmt->execute([$categoryId, $limit, $offset]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get posts by category error: " . $e->getMessage());
            return [];
        }
    }


    /**
     * Upload file
     */
    public function uploadFile($file, $type = 'image') {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $allowedTypes = $type === 'image' ? ALLOWED_IMAGE_TYPES : ALLOWED_DOCUMENT_TYPES;
        $uploadDir = $type === 'image' ? UPLOAD_PATH . 'images/' : UPLOAD_PATH . 'documents/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($extension, $allowedTypes)) {
            return false;
        }

        if ($file['size'] > MAX_FILE_SIZE) {
            return false;
        }

        $filename = uniqid() . '.' . $extension;
        $filepath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return $filename;
        }

        return false;
    }

    /**
     * Generate excerpt from content
     */
    public function generateExcerpt($content, $length = 150) {
        $excerpt = strip_tags($content);
        if (strlen($excerpt) > $length) {
            $excerpt = substr($excerpt, 0, $length) . '...';
        }
        return $excerpt;
    }

    /**
     * Estimate reading time
     */
    public function estimateReadingTime($content) {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / 200); // Average reading speed: 200 words per minute
        return max(1, $minutes);
    }

    /**
     * Search posts
     */
    public function searchPosts($search, $page = 1, $limit = 10) {
        try {
            $offset = ($page - 1) * $limit;
            $searchTerm = "%$search%";
            
            $sql = "SELECT bp.*, u.full_name as author_name 
                    FROM blog_posts bp 
                    JOIN users u ON bp.author_id = u.id 
                    WHERE bp.status = 'published' 
                    AND (bp.title LIKE ? OR bp.content LIKE ?)
                    ORDER BY bp.created_at DESC 
                    LIMIT ? OFFSET ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$searchTerm, $searchTerm, $limit, $offset]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Search posts error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Count search results
     */
    public function countSearchPosts($search) {
        try {
            $searchTerm = "%$search%";
            $stmt = $this->db->prepare("
                SELECT COUNT(*) 
                FROM blog_posts bp 
                WHERE bp.status = 'published' 
                AND (bp.title LIKE ? OR bp.content LIKE ?)
            ");
            $stmt->execute([$searchTerm, $searchTerm]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Count search posts error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get recent posts
     */
    public function getRecentPosts($limit = 5) {
        try {
            $sql = "SELECT bp.*, u.full_name as author_name 
                    FROM blog_posts bp 
                    JOIN users u ON bp.author_id = u.id 
                    WHERE bp.status = 'published'
                    ORDER BY bp.created_at DESC 
                    LIMIT ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limit]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get recent posts error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Count all posts
     */
    public function countAllPosts() {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) 
                FROM blog_posts bp 
                WHERE bp.status = 'published'
            ");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Count all posts error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get all categories
     */
    public function getAllCategories() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM blog_categories ORDER BY name");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get categories error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Count posts by category
     */
    public function countPostsByCategory($categoryId) {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) 
                FROM blog_posts bp 
                JOIN blog_post_categories bpc ON bp.id = bpc.post_id
                WHERE bp.status = 'published' 
                AND bpc.category_id = ?
            ");
            $stmt->execute([$categoryId]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Count posts by category error: " . $e->getMessage());
            return 0;
        }
    }

}

// Initialize blog instance
$blog = new Blog();
?>
