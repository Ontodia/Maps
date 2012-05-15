<?php

/**
 * This groupe contains all Google Maps v3 related files of the Maps extension.
 * 
 * @defgroup MapsGoogleMaps3 Google Maps v3
 * @ingroup Maps
 */

/**
 * This file holds the hook and initialization for the Google Maps v3 service. 
 *
 * @file GoogleMaps3.php
 * @ingroup MapsGoogleMaps3
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgResourceModules['ext.maps.googlemaps3'] = array(
	'dependencies' => array( 'ext.maps.common' ),
	'localBasePath' => dirname( __FILE__ ),
	'remoteBasePath' => $egMapsScriptPath .  '/includes/services/GoogleMaps3',	
	'group' => 'ext.maps',
	'scripts' => array(
		'gm3-util-library/markerclusterer.js',  //the following two js files should at one point be loaded when needed,
		'gm3-util-library/markerwithlabel.js',  //However, they are both missing a namespace so they cant be reached after
		'jquery.googlemap.js',                  //invoking resource loader on them. (look at how geoxml is referenced)
		'ext.maps.googlemaps3.js'
	),
	'styles' => array(
		'gm3-util-library/markerwithlabel.css'
	),
	'messages' => array(
		'maps-googlemaps3-incompatbrowser',
		'maps-copycoords-prompt',
		'maps-searchmarkers-text'
	)
);

$wgResourceModules['ext.maps.gm3.geoxml'] = array(
	'localBasePath' => dirname( __FILE__ ) . '/geoxml3',
	'remoteBasePath' => $egMapsScriptPath .  '/includes/services/GoogleMaps3/geoxml3',	
	'group' => 'ext.maps',
	'scripts' => array(
		'geoxml3.js',
		'ZipFile.complete.js', //kmz handling
	),
);

$wgResourceModules['ext.maps.gm3.earth'] = array(
	'localBasePath' => dirname( __FILE__ ) . '/earth',
	'remoteBasePath' => $egMapsScriptPath .  '/includes/services/GoogleMaps3/earth',	
	'group' => 'ext.maps',
	'scripts' => array(
		'googleearth.js',
	),
);

$wgHooks['MappingServiceLoad'][] = 'efMapsInitGoogleMaps3';

/**
 * Initialization function for the Google Maps v3 service. 
 * 
 * @since 0.6.3
 * @ingroup MapsGoogleMaps3
 * 
 * @return true
 */
function efMapsInitGoogleMaps3() {
	global $wgAutoloadClasses;

	$wgAutoloadClasses['MapsGoogleMaps3'] 			= dirname( __FILE__ ) . '/Maps_GoogleMaps3.php';
	$wgAutoloadClasses['MapsParamGMap3Type']		= dirname( __FILE__ ) . '/Maps_ParamGMap3Type.php';
	$wgAutoloadClasses['MapsParamGMap3Types']		= dirname( __FILE__ ) . '/Maps_ParamGMap3Types.php';
	$wgAutoloadClasses['MapsParamGMap3Typestyle']	= dirname( __FILE__ ) . '/Maps_ParamGMap3Typestyle.php';
	$wgAutoloadClasses['MapsParamGMap3Zoomstyle']	= dirname( __FILE__ ) . '/Maps_ParamGMap3Zoomstyle.php';

	MapsMappingServices::registerService( 'googlemaps3', 'MapsGoogleMaps3' );
	$googleMaps = MapsMappingServices::getServiceInstance( 'googlemaps3' );	
	$googleMaps->addFeature( 'display_map', 'MapsBaseMap' );
	$googleMaps->addFeature( 'display_point', 'MapsBasePointMap' );
	$googleMaps->addFeature( 'display_line', 'MapsBasePointLineMap' );

	return true;
}
