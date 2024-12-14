<?php

namespace smn\routing;

use stdClass;

/**
 * Represents and processes HTTP request details.
 *
 * <p>This class provides methods to construct and retrieve components of HTTP requests,
 * including the URL, headers, method, and other details. The class utilizes static
 * properties and methods to manage and extract data from the request environment.</p>
 */
class Request
{


    /**
     * Represents a URL as a string.
     * This variable is intended to hold a URL value.
     */
    protected static string $url = "";


    /**
     * An array to hold header values.
     */
    protected static array $headers = [];

    /**
     * A string variable to store the HTTP method value.
     */
    protected static string $method = "";

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
     * Retrieves the HTTP method associated with the constructed URL.
     *
     * <p>This method accesses the HTTP method (e.g., "GET", "POST") that has been set
     * for the constructed URL after invoking the <code>buildUrl</code> method.</p>
     *
     * @return string The HTTP method associated with the URL.
     */
    public static function getMethod() : string
    {
        self::buildUrl();
        return self::$method;
    }


    /**
     * Retrieves the headers associated with the constructed URL.
     *
     * <p>This method returns an array of headers that have been set or associated
     * with the URL constructed by the <code>buildUrl</code> method.</p>
     *
     * @return array An associative array of headers, where each key represents a header name and each value represents the corresponding header value.
     */
    public static function getHeaders() : array
    {
        self::buildUrl();
        return self::$headers;
    }


    /**
     * Retrieves detailed information about the current HTTP request.
     *
     * <p>This method gathers various components related to the HTTP request, including the scheme,
     * host, port, request URI, query string, fragment, and headers.</p>
     *
     * @return array An associative array containing the following keys:
     *               <ul>
     *                   <li><code>scheme</code>: The scheme of the request URL (e.g., "http" or "https").</li>
     *                   <li><code>host</code>: The hostname of the request.</li>
     *                   <li><code>port</code>: The port number used for the request.</li>
     *                   <li><code>requestUri</code>: The URI path of the request.</li>
     *                   <li><code>queryString</code>: The query string appended to the request URL.</li>
     *                   <li><code>fragment</code>: The fragment identifier of the request URL, if any.</li>
     *                   <li><code>headers</code>: An array of headers included with the request.</li>
     *               </ul>
     */
    public static function getInfoRequest() : array
    {
        return [
            'scheme' => self::getScheme(),
            'host' => self::getHost(),
            'port' => self::getPort(),
            'requestUri' => self::getRequestUri(),
            'queryString' => self::getQueryString(),
            'fragment' => self::getFragment(),
            'method' => self::getMethod(),
            'headers' => self::getHeaders()
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
     * Constructs the full URL of the current request and populates HTTP headers.
     *
     * <p>This method builds the full URL by combining the protocol (HTTP/HTTPS), host, and request URI
     * from the server environment. Additionally, it parses and stores HTTP headers provided in the
     * <code>$_SERVER</code> superglobal into a structured array.</p>
     *
     * <p>The resulting URL and headers are stored internally and can be used by other methods
     * within the class.</p>
     *
     * @return void This method does not return a value. The constructed URL and headers are stored
     * internally in static properties.
     */
    public static function buildUrl() : void
    {
        if (empty(self::$url))
        {
            $protocol       = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $host           = $_SERVER['HTTP_HOST'];
            $requestUri     = $_SERVER['REQUEST_URI'];
            self::$url      = $protocol . $host . $requestUri;
            self::$method   = strtoupper($_SERVER['REQUEST_METHOD']);

            $headers = [];

            foreach ($_SERVER as $key => $value)
            {
                if (str_starts_with($key, 'HTTP_'))
                {
                    $headerName = str_replace('_', '-', substr($key, 5));
                    $headerName = strtolower($headerName);
                    $headers[$headerName] = $value;
                }
            }
            if (isset($_SERVER['CONTENT_TYPE']))
            {
                $headers['content-type'] = $_SERVER['CONTENT_TYPE'];
            }
            if (isset($_SERVER['CONTENT_LENGTH']))
            {
                $headers['content-length'] = $_SERVER['CONTENT_LENGTH'];
            }
            self::$headers = $headers;
        }
    }

}