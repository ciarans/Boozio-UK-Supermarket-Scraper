<?php

/**
 * Boozio
 * 
 * Inspired by Finding a Good Deal at the Supermarkets
 * This Software has no affiliation with any Supermarkets.
 * 
 * @author Ciaran Synnott 
 * @package Boozio
 * @subpackage Basket
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
    public function go_fetch($cookies = array()) {
        $ch = curl_init();

        if (!empty($cookies)) {
            $_cookie_jar = array();
            foreach ($cookies as $c) {
                $_cookie_jar[] = "Cookie:" . $c;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $_cookie_jar);            
        }
        
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_USERAGENT, self::CURL_USER_AGENT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CURL_TIMEOUT);
        $this->set_response(curl_exec($ch));
        $this->set_status_code(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        if ($this->get_status_code() == 200) {
            return true;
        } else {
            return false;
        }
    }

    public function cookie_fetch() {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_USERAGENT, self::CURL_USER_AGENT);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CURL_TIMEOUT);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $header = curl_exec($ch);
        $cookies = array();
        preg_match_all('/Set-Cookie:(?<cookie>\s{0,}.*)$/im', $header, $cookies);

        return $cookies['cookie'];
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

    /**
     * Get set Url to CUrl
     * 
     * @return string Url that has been set for CUrl
     */
    public function get_url() {
        return $this->url;
    }

}
