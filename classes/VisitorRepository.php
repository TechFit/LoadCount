<?php


class VisitorRepository
{
    /** @var Database */
    private $db;

    public function __construct(Database $db)
    {
        $this->setDb($db);
    }

    /**
     * @return Database
     */
    public function getDb(): Database
    {
        return $this->db;
    }

    /**
     * @param Database $db
     */
    public function setDb(Database $db): void
    {
        $this->db = $db;
    }

    /**
     * @param string $ip_address
     *
     * @param string $user_agent
     *
     * @param string $url
     *
     * @return int|bool
     */
    public function getId(string $ip_address, string $user_agent, string $url)
    {
        return $this->db->single("SELECT id FROM visitor WHERE ip_address = :ip_address AND user_agent = :user_agent AND page_url = :page_url", [
            'ip_address' => ip2long($ip_address),
            'user_agent' => $user_agent,
            'page_url' => $url,
        ]);
    }

    public function update(int $id): bool
    {
        return $this->db->query("UPDATE visitor SET views_count = views_count + 1, view_date = :now WHERE Id = :id", [
            'now' => date('Y-m-d H:i:s'),
            'id' => $id,
        ]);
    }

    public function create(string $ip_address, string $user_agent, string $url): bool
    {
        return $this->db->query("INSERT INTO visitor (ip_address, user_agent, view_date, page_url, views_count) VALUES (:ip_address, :user_agent, :view_date, :page_url, :views_count)", [
            'ip_address' => ip2long($ip_address),
            'user_agent' => $user_agent,
            'view_date' => date('Y-m-d H:i:s'),
            'page_url' => $url,
            'views_count' => 1,
        ]);
    }
}

//UPDATE visitor SET ip_address = 3715897129, user_agent = 'Mozilla/5.0 (Linux; Android 6.0.1; SM-G935S Build/MMB29K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/55.0.2883.91 Mobile Safari/537.36', view_update = ' 2019-06-26 14:31:00'