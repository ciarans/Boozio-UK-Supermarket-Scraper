<?php

/**
 * Boozio
 * 
 * Inspired by Finding a Good Deal at the Supermarkets
 * This Software has no affiliation with any Supermarkets.
 * 
 * @author Ciaran Synnott 
 * @package Boozio
 * @subpackage CUrl
 * 
 * Simple CUrl Class to get scrape the websites;
 * 
 */

namespace Boozio\CUrl;


class CUrl {

    const CURL_USER_AGENT = 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)';
    // Predefined User Agent for CUrl Request
    const CURL_TIMEOUT = 10;

    // Predefined TimeOut for CUrl Request 

    private $status_code;
    private $response;
    private $url;

    /**
     * Sets the CUrl Request URL
     * 
     * @param sting $url URL to perform CUrl request on
     */
    public function __construct($url) {
        $this->url = $url;
    }

    /**
     * Performs a CUrl request on the given URL to fetch the data
     * 
     * @return bool Returns true if response is 200 - false if not;
     */
    public function go_fetch() {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_USERAGENT, self::CURL_USER_AGENT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CURL_TIMEOUT);
        $this->set_response(curl_exec($ch));
        $this->set_status_code(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        if ($this->get_status_code() == 200) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Extracts cookies from cURL result
     * 
     * @return array $cookies Returns array of cookies;
     */    
    private function extract_cookies($result) {
        list($header, $body) = explode("\r\n\r\n", $result, 2);
        $end = strpos($header, 'Content-Type');
        $start = strpos($header, 'Set-Cookie');
        $parts = explode('Set-Cookie:', substr($header, $start, $end - $start));
        $cookies = array();
        foreach ($parts as $co) {
            $cd = explode(';', $co);
            if (!empty($cd[0]))
                $cookies[] = $cd[0];
        }
        return $cookies;
    }

    /**
     * Performs a CUrl request on the given URL to fetch the data - then it
     * gets the cookies and performs another curl request.
     * 
     * @return bool Returns true if response is 200 - false if not;
     */
    public function cookie_curl() {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_USERAGENT, self::CURL_USER_AGENT);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CURL_TIMEOUT);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        curl_exec($ch);

        $data = (object) array(
                    "curl_info" => (object) curl_getinfo($ch),
                    "cookies" => $this->extract_cookies(curl_exec($ch))
        );
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        if (!empty($data->cookies)) {
            curl_setopt($ch, CURLOPT_COOKIE, implode(';', $data->cookies));
        }

        $this->set_response(curl_exec($ch));
        $this->set_status_code(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        if ($this->get_status_code() == 200) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets Status Code Of CUrl request
     * 
     * @return int Status Code of stored request;
     */
    public function get_status_code() {
        return (int) $this->status_code;
    }

    /**
     * Sets Status Code Of CUrl request
     * 
     * @param int $status Status Code;
     */
    public function set_status_code($status) {
        $this->status_code = $status;
    }

    /**
     * Gets Scrapped Response
     * 
     * @return string Scrapped Response
     */
    public function get_response() {
        return $this->response;
    }

    /**
     * Sets Scrapped Response
     * 
     * @param string $response Scrapped Response
     */
    public function set_response($response) {
        $this->response = $response;
    }

    /**
     * Sets URL to CUrl
     * 
     * @param string $url url to perform CUrl
     */
    public function set_url($url) {
        $this->url = $url;
    }

    public function get_url() {
        return $this->url;
    }



}
