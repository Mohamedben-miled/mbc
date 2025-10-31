<?php
/**
 * Traffic Tracking System for MBC Website
 */

require_once __DIR__ . '/../config/database.php';

class TrafficTracker {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Track a page visit
     */
    public function trackVisit($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO site_traffic 
                (page_url, page_title, referrer, user_agent, ip_address, session_id, visit_date, visit_time)
                VALUES (?, ?, ?, ?, ?, ?, CURDATE(), CURTIME())
            ");
            
            return $stmt->execute([
                $data['page_url'],
                $data['page_title'] ?? '',
                $data['referrer'] ?? '',
                $data['user_agent'] ?? '',
                $data['ip_address'] ?? '',
                $data['session_id'] ?? session_id()
            ]);
        } catch (PDOException $e) {
            error_log("Traffic tracking error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get daily traffic statistics
     */
    public function getDailyTraffic($days = 30) {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    visit_date as date,
                    COUNT(*) as total_visits,
                    COUNT(DISTINCT session_id) as unique_visitors,
                    COUNT(DISTINCT page_url) as pages_visited
                FROM site_traffic
                WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                GROUP BY visit_date
                ORDER BY visit_date ASC
            ");
            $stmt->execute([$days]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get daily traffic error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get most visited pages
     */
    public function getMostVisitedPages($limit = 10) {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    page_url,
                    page_title,
                    COUNT(*) as views,
                    COUNT(DISTINCT session_id) as unique_visitors
                FROM site_traffic
                WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                GROUP BY page_url, page_title
                ORDER BY views DESC
                LIMIT ?
            ");
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get most visited pages error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get traffic statistics summary
     */
    public function getTrafficSummary($days = 30) {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    COUNT(*) as total_visits,
                    COUNT(DISTINCT session_id) as unique_visitors,
                    COUNT(DISTINCT page_url) as total_pages,
                    COUNT(DISTINCT DATE(visit_datetime)) as active_days,
                    AVG(duration_seconds) as avg_duration
                FROM site_traffic
                WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
            ");
            $stmt->execute([$days]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get traffic summary error: " . $e->getMessage());
            return [
                'total_visits' => 0,
                'unique_visitors' => 0,
                'total_pages' => 0,
                'active_days' => 0,
                'avg_duration' => 0
            ];
        }
    }

    /**
     * Get hourly traffic distribution
     */
    public function getHourlyTraffic($days = 7) {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    HOUR(visit_time) as hour,
                    COUNT(*) as visits
                FROM site_traffic
                WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                GROUP BY HOUR(visit_time)
                ORDER BY hour ASC
            ");
            $stmt->execute([$days]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get hourly traffic error: " . $e->getMessage());
            return [];
        }
    }
}

// Initialize traffic tracker
$trafficTracker = new TrafficTracker();

