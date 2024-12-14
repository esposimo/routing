<?php

namespace smn\routing;

use stdClass;

/**
 * Handles and parses the current HTTP request, providing access to various URL components such as scheme, host, port,
 * path, query string, and fragment. Also offers utility methods to retrieve request information in structured formats.
 */
class Request
{


    /**
     * Represents a URL as a string.
     * This variable is intended to hold a URL value.
     */
    protected static string $url = "";

    /**
     * Retrieves the scheme component of the constructed URL.
     *
     * <p>This method parses the scheme (e.g., "http" or "https") from the URL constructed
     * by the <code>buildUrl</code> method.</p>
     *
     * @return string The scheme part of the URL, or an empty string if no scheme is found.
     */
    public static function getScheme() : string
    {
        self::buildUrl();
        return parse_url(self::$url, PHP_URL_SCHEME);
    }

    /**
     * Retrieves the host component of the constructed URL.
     *
     * <p>This method extracts the host (e.g., "example.com") from the URL created
     * by the <code>buildUrl</code> method.</p>
     *
     * @return string The host part of the URL, or an empty string if no host is present.
     */
    public static function getHost() : string
    {
        self::buildUrl();
        return parse_url(self::$url, PHP_URL_HOST);
    }


    /**
     * Retrieves the port component of the constructed URL.
     *
     * <p>This method determines the port from the URL constructed by the
     * <code>buildUrl</code> method. If the port is not explicitly defined in
     * the URL, it defaults to 443 for HTTPS and 80 for HTTP.</p>
     *
     * @return int The port number of the URL, or the default port based on the scheme if not specified.
     */
    public static function getPort() : int
    {
        self::buildUrl();
        $port = parse_url(self::$url, PHP_URL_PORT);
        if (empty($port))
        {
            return (self::getScheme() === 'https') ? 443 : 80;
        }
        return $port;
    }

    /**
     * Retrieves the path component of the constructed URL.
     *
     * <p>This method extracts the request URI portion (e.g., "/example/path") from the URL
     * created by the <code>buildUrl</code> method.</p>
     *
     * @return string The path part of the URL, or an empty string if no path is found.
     */
    public static function getRequestUri() : string
    {
        self::buildUrl();
        return parse_url(self::$url, PHP_URL_PATH);
    }


    /**
     * Retrieves the query string parameters from the constructed URL as an associative array.
     *
     * <p>This method processes the query component of the URL, extracting the parameters and their values
     * into an associative array. If the URL contains no query string, an empty array is returned.</p>
     *
     * @return array An associative array of query parameters, where keys are parameter names
     *               and values are parameter values, or an empty array if the query string is not present.
     */
    public static function getQueryString() : array
    {
        self::buildUrl();
        $qs = parse_url(self::$url, PHP_URL_QUERY);
        if (empty($qs))
        {
            return [];
        }
        $queryParams = [];
        parse_str($qs, $queryParams);
        return $queryParams;
    }


    /**
     * Retrieves the fragment component of the constructed URL.
     *
     * <p>This method extracts the fragment (also known as the "hash" or the portion of the URL
     * following the <code>#</code> symbol) from the URL constructed by the <code>buildUrl</code> method.</p>
     *
     * @return string|null The fragment part of the URL, or <code>null</code> if no fragment is present.
     */
    public static function getFragment() : string|null
    {
        self::buildUrl();
        return parse_url(self::$url, PHP_URL_FRAGMENT);
    }


    /**
     * Retrieves detailed information about the current request's URL components.
     *
     * <p>This method returns an associative array containing the specific parts of the URL,
     * including the scheme, host, port, request URI, query string, and fragment identifier.</p>
     *
     * @return array An associative array with the following keys:
     * <ul>
     *   <li><code>scheme</code>: The scheme part of the URL (e.g., "http" or "https").</li>
     *   <li><code>host</code>: The hostname of the URL.</li>
     *   <li><code>port</code>: The port number of the URL.</li>
     *   <li><code>requestUri</code>: The full URI of the request.</li>
     *   <li><code>queryString</code>: The query string of the URL (if any).</li>
     *   <li><code>fragment</code>: The fragment identifier of the URL (if any).</li>
     * </ul>
     */
    public static function getInfoRequest() : array
    {
        return [
            'scheme' => self::getScheme(),
            'host' => self::getHost(),
            'port' => self::getPort(),
            'requestUri' => self::getRequestUri(),
            'queryString' => self::getQueryString(),
            'fragment' => self::getFragment()
        ];
    }


    /**
     * Converts the response of the <code>getInfoRequest</code> method into an object.
     *
     * <p>This method takes the result returned by <code>getInfoRequest</code> and casts it to an instance of <code>stdClass</code>.</p>
     *
     * @return stdClass An object representation of the data returned by <code>getInfoRequest</code>.
     */
    public static function getInfoRequestAsObject() : stdClass
    {
        return (object) self::getInfoRequest();
    }

    /**
     * Constructs and stores the full URL based on the current server environment.
     *
     * <p>This method builds the URL by using the protocol (HTTP or HTTPS), the host name,
     * and the request URI retrieved from the server's global variables. It ensures that the
     * URL is initialized only once and stored in the class property for subsequent use.</p>
     *
     * @return void This method does not return a value; it sets the constructed URL internally.
     */
    public static function buildUrl() : void
    {
        if (empty(self::$url))
        {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];
            $requestUri = $_SERVER['REQUEST_URI'];
            self::$url = $protocol . $host . $requestUri;
        }
    }

}