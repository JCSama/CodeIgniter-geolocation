<?php
/**
 * Geolocation Class
 *
 * This content is released under the MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    Libraries
 * @author     Mohamed ES-SAHLI
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       https://github.com/JCSama/CodeIgniter-geolocation
 * @since      Version 1.0
 */
defined('BASEPATH') or die('No direct script access.');

class Geolocation
{

    /**
     * Library Version
     */
    const VERSION = '1.0';

    /**
     * Errors
     *
     * @var string
     */
    private $error = '';

    /**
     * API URL
     *
     * @var string
     */
    private $api = '';

    /**
     * API Version
     *
     * @var string
     */
    private $api_version = '';

    /**
     * API KEY for the webservice
     *
     * @var string
     */
    private $api_key = '';

    /**
     * IP Address to locate
     *
     * @var string
     */
    private $ip_address = '';

    /**
     * Returned format, Leave it blank to return a PHP Array
     *
     * @var string
     */
    private $format = '';

    /**
     * Initialize the Geolocation library
     *
     * @param array $params
     */
    public function __construct($params = array())
    {

        if (count($params) > 0) {
            $this->initialize($params);
        }

        log_message('debug', "Geolocation Class Initialized");
    }

    /**
     * Initialize the Geolocation preferences
     *
     * Accepts an associative array as input, containing Geolocation preferences
     *
     * @param array $params
     *
     * @return Geolocation library
     */
    public function initialize($params = array())
    {
        if (count($params) > 0) {
            foreach ($params as $key => $val) {
                if (isset($this->{$key}))
                    $this->{$key} = $val;
            }
        }

        return $this;
    }

    /**
     * Set the API KEY
     *
     * @param $api_key string
     *
     * @return Geolocation library
     */
    public function set_api_key($api_key)
    {
        $this->api_key = $api_key;

        return $this;
    }

    /**
     * Set the IP Address to locate
     *
     * @param $ip_address string
     *
     * @return Geolocation library
     */
    public function set_ip_address($ip_address)
    {
        $this->ip_address = $ip_address;

        return $this;
    }


    /**
     * Set the format for the returned data
     *
     * @param $format
     *
     * @return Geolocation library
     */
    public function set_format($format)
    {
        $this->format = empty($format) ? $this->format : $format;

        return $this;
    }

    /**
     * Get triggered error
     *
     * @return string
     */
    public function get_error()
    {
        return $this->error;
    }

    /**
     * Get the located country
     *
     * @return bool|mixed|string
     */
    public function get_country()
    {
        return $this->locate('ip-country');
    }

    /**
     * Get the located City
     *
     * @return bool|mixed|string
     */
    public function get_city()
    {
        return $this->locate('ip-city');
    }

    /**
     * Get the location data
     *
     * @param $type string
     *
     * @return bool|mixed|string
     */
    private function locate($type)
    {
        if (@inet_pton($this->ip_address) === false){
            $this->error = 'Invalid IP Address : ' . $this->ip_address;
            log_message('error', 'Geolocation => ' . $this->error);

            return false;
        }

        $as_array = empty($this->format);
        $this->format = $as_array ? 'json' : $this->format;

        $url = $this->api
            . $this->api_version . '/'
            . $type . '/'
            . '?key=' . $this->api_key
            . '&ip=' . $this->ip_address
            . '&format=' . $this->format;

        return $this->get_result($url, $as_array);
    }

    /**
     * Locate the IP Address and return the data
     *
     * @param $url string
     * @param bool $as_array
     *
     * @return bool|string
     */
    private function get_result($url, $as_array = FALSE){
        $data = @file_get_contents($url);

        switch($this->format){
            case 'json':
                $result = json_decode($data);
                break;

            case 'xml':
                $result = simplexml_load_string($data);
                $result = json_decode(json_encode((array) $result));
                break;

            default:
                $result = explode(';', $data);
        }

        if ((isset($result->statusCode) && $result->statusCode == 'ERROR')
            || (is_array($result) && $result[0] == 'ERROR')) {

            $this->error = isset($result->statusMessage) ? $result->statusMessage : $result[1];
            log_message('error', 'Geolocation => ' . $this->error);

            return FALSE;
        }

        return $as_array ? (array) $result : $data;
    }
}

// END Geolocation Class