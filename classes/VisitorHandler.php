<?php

/**
 * Class VisitorHandler
 */
class VisitorHandler
{
    /** @var VisitorRepository */
    private $visitorRepository;

    /** @var int */
    private $ip_address;

    /** @var string */
    private $user_agent;

    /** @var string */
    private $url;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;

        $this->ip_address = $this->getVisitorIPAddress();

        $this->user_agent = $this->getVisitorUserAgent();

        $this->url = $this->getVisitorUrl();
    }

    public function handle()
    {
        $visitor_id = $this->getCurrentVisitorId();

        if ($visitor_id) {
           $this->visitorRepository->update($visitor_id);
        } else {
           $this->visitorRepository->create($this->ip_address, $this->user_agent , $this->url);
        }
    }

    /**
     * @return bool|int
     */
    public function getCurrentVisitorId()
    {
        $visitor = $this->visitorRepository->getId($this->ip_address, $this->user_agent , $this->url);

        return $visitor;
    }

    public function getVisitorIPAddress(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])){
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            throw new Exception('Can\'t detect ip address.');
        }

        return $ip;
    }

    public function getVisitorUserAgent(): string
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if (empty($user_agent)) {
            throw new Exception('Can\'t detect user-agent.');
        }

        return $user_agent;
    }

    public function getVisitorUrl(): string
    {
        $url = $_SERVER['HTTP_REFERER'];

        if (empty($url)) {
            throw new Exception('Can\'t detect user url.');
        }

        return $url;
    }
}