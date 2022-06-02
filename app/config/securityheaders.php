<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Value: 0 | 1 | 1; mode=block | 1; report=<reporting-uri>
 * 
*/
$config['xss_protection_header'] = '1; mode=block';

/**
 * Value: * | <url origin separate by space> | null | false
 * 
*/
$config['access_control_allow_origin'] = BASE_URL . ' https://www.googletagmanager.com/' . ' http://ip-api.com/';

/**
 * Value: DENY | SAMEORIGIN | false
 * 
*/
$config['x_frame_options'] = 'SAMEORIGIN';

/**
 * Value: nosniff | false
 * 
*/
$config['x_content_type_options'] = 'nosniff';

/**
 * Value: { "report_to": "name_of_reporting_group", "max_age": 12345, "include_subdomains": false, "success_fraction": 0.0, "failure_fraction": 1.0 } | false
 *
*/
$config['nel'] = '';

/**
 * Value: Expect-CT: max-age=86400, enforce, report-uri="https://foo.example/report" | false
 * 
*/
$config['expect_ct'] = '';

/**
 * Examples of features that can be controlled by Permissions Policy include:
 * 
 * 		Battery status
 * 		Client Hints
 * 		Encrypted-media decoding
 * 		Fullscreen
 * 		Geolocation
 * 		Picture-in-picture
 * 		Sensors: Accelerometer, Ambient Light Sensor, Gyroscope, Magnetometer
 *   	User media: Camera, Microphone
 *		Video Autoplay
 *		Web Payment Request
 *		WebMIDI
 *		WebUSB
 *		WebXR
 *
 * Value for each rule: * | self | url | ''
 * 
 * array(
 *		'geolocation' => '',
 *		'midi' => '',
 *		'usb' => '',
 *		'sync-xhr' => '',
 *		'microphone' => '',
 *		'camera' => '',
 *		'magnetometer' => '',
 *		'gyroscope' => '',
 *		'fullscreen' => '',
 *		'payment' => '',
 *		'battery' => '',
 *		'ambient-light-sensor' => '',
 *		'autoplay' => '',
 *		'cross-origin-isolated' => '',
 *		'display-capture' => '',
 *		'document-domain' => '',
 *		'encrypted-media' => '',
 *		'execution-while-not-rendered' => '',
 *		'execution-while-out-of-viewport' => '',
 *		'keyboard-map' => '',
 *		'navigation-override' => '',
 *		'picture-in-picture' => '',
 *		'publickey-credentials-get' => '',
 *		'screen-wake-lock' => '',
 *		'web-share' => '',
 *		'xr-spatial-tracking' => ''
 *	);
*/
$config['permissions_policy'] = array(
    'accelerometer' => 'self',
    'geolocation' => 'self "https://google.com"',
    'midi' => '',
    'usb' => '',
    'sync-xhr' => 'self',
    'microphone' => 'self',
    'camera' => 'self',
    'magnetometer' => '',
    'gyroscope' => '',
    'fullscreen' => 'self',
    'payment' => '',
    // 'battery' => '',
    // 'ambient-light-sensor' => '',
    'autoplay' => 'self',
    'cross-origin-isolated' => '',
    'display-capture' => '',
    'document-domain' => '',
    'encrypted-media' => '',
    // 'execution-while-not-rendered' => '',
    // 'execution-while-out-of-viewport' => '',
    // 'keyboard-map' => '',
    // 'navigation-override' => '',
    'picture-in-picture' => 'self',
    'publickey-credentials-get' => '',
    'screen-wake-lock' => '',
    'web-share' => '',
    'xr-spatial-tracking' => ''
);

/**
 * Cross-Origin-Embedder-Policy: unsafe-none | require-corp | require-corp; report-to='report_group' | false
 * 
*/
$config['cross_origin_embedder_policy'] = "require-corp;";

/**
 * Cross-Origin-Opener-Policy: unsafe-none | same-origin-allow-popups | same-origin | same-origin; report-to='report_group' | false
 * 
*/
$config['cross_origin_opener_policy'] = "same-origin;";

/**
 * Cross-Origin-Resource-Policy: same-site | same-origin | cross-origin | false
 * 
*/
$config['cross_origin_resource_policy'] = 'same-site';

/**
 * Referrer-Policy: no-referrer-when-downgrade | false
 * 
*/
$config['referrer_policy'] = 'no-referrer-when-downgrade';

/**
 * Strict-Transport-Security: max-age=<expire-time> | max-age=<expire-time>; includeSubDomains | max-age=<expire-time>; preload | false
 * 
*/
$config['strict_transport_security'] = '';