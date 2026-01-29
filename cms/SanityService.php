<?php
/**
 * Sanity CMS Service
 * Handles all communication with the Sanity API
 */

class SanityService {
    private $projectId;
    private $dataset;
    private $apiVersion;
    private $readToken;
    private $writeToken;
    private $cdnUrl;

    public function __construct() {
        $config = require __DIR__ . '/sanity-config.php';
        $this->projectId = $config['project_id'];
        $this->dataset = $config['dataset'];
        $this->apiVersion = $config['api_version'];
        $this->readToken = $config['read_token'];
        $this->writeToken = $config['write_token'];
        $this->cdnUrl = $config['cdn_url'];
    }

    /**
     * Get the base API URL
     */
    private function getApiUrl($useCdn = true) {
        $host = $useCdn ? 'apicdn.sanity.io' : 'api.sanity.io';
        return "https://{$this->projectId}.{$host}/v{$this->apiVersion}/data/query/{$this->dataset}";
    }

    /**
     * Get the mutations API URL
     */
    private function getMutationsUrl() {
        return "https://{$this->projectId}.api.sanity.io/v{$this->apiVersion}/data/mutate/{$this->dataset}";
    }

    /**
     * Execute a GROQ query
     */
    public function query($groqQuery, $params = []) {
        $url = $this->getApiUrl() . '?query=' . urlencode($groqQuery);
        
        // Add parameters if any
        foreach ($params as $key => $value) {
            $url .= '&$' . $key . '=' . urlencode(json_encode($value));
        }

        $headers = ['Content-Type: application/json'];
        if ($this->readToken) {
            $headers[] = 'Authorization: Bearer ' . $this->readToken;
        }

        $response = $this->makeRequest($url, 'GET', null, $headers);
        return $response['result'] ?? [];
    }

    /**
     * Get all news items
     */
    public function getAllNews() {
        $query = '*[_type == "news"] | order(date desc) {
            _id,
            title,
            version,
            date,
            "thumb": thumb.asset->url,
            body
        }';
        
        return $this->query($query);
    }

    /**
     * Get a single news item by ID
     */
    public function getNewsById($id) {
        $query = '*[_type == "news" && _id == $id][0] {
            _id,
            title,
            version,
            date,
            "thumb": thumb.asset->url,
            body
        }';
        
        return $this->query($query, ['id' => $id]);
    }

    /**
     * Create a new news item
     */
    public function createNews($data) {
        $mutations = [
            'mutations' => [
                [
                    'create' => [
                        '_type' => 'news',
                        'title' => $data['title'],
                        'version' => $data['version'],
                        'date' => $data['date'] ?? date('Y-m-d'),
                        'thumb' => $data['thumb'] ?? null,
                        'body' => $data['body']
                    ]
                ]
            ]
        ];

        return $this->mutate($mutations);
    }

    /**
     * Update a news item
     */
    public function updateNews($id, $data) {
        $set = [];
        if (isset($data['title'])) $set['title'] = $data['title'];
        if (isset($data['version'])) $set['version'] = $data['version'];
        if (isset($data['date'])) $set['date'] = $data['date'];
        if (isset($data['thumb'])) $set['thumb'] = $data['thumb'];
        if (isset($data['body'])) $set['body'] = $data['body'];

        $mutations = [
            'mutations' => [
                [
                    'patch' => [
                        'id' => $id,
                        'set' => $set
                    ]
                ]
            ]
        ];

        return $this->mutate($mutations);
    }

    /**
     * Delete a news item
     */
    public function deleteNews($id) {
        $mutations = [
            'mutations' => [
                [
                    'delete' => [
                        'id' => $id
                    ]
                ]
            ]
        ];

        return $this->mutate($mutations);
    }

    /**
     * Execute mutations (create/update/delete)
     */
    private function mutate($mutations) {
        $url = $this->getMutationsUrl();
        
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->writeToken
        ];

        return $this->makeRequest($url, 'POST', json_encode($mutations), $headers);
    }

    /**
     * Make HTTP request using cURL
     */
    private function makeRequest($url, $method = 'GET', $body = null, $headers = []) {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($body) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            }
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception("cURL Error: " . $error);
        }

        $data = json_decode($response, true);
        
        if ($httpCode >= 400) {
            $errorMessage = $data['error']['description'] ?? 'Unknown error';
            throw new Exception("Sanity API Error: " . $errorMessage);
        }

        return $data;
    }

    /**
     * Verify admin key
     */
    public function verifyAdminKey($key) {
        $config = require __DIR__ . '/sanity-config.php';
        return hash_equals($config['admin_key'], $key);
    }
}
