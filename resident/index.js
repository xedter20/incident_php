/**
 * @license
 * Copyright 2019 Google LLC. All Rights Reserved.
 * SPDX-License-Identifier: Apache-2.0
 */
// [START maps_advanced_markers_basic_style]
const parser = new DOMParser();

async function initMap() {
  // Request needed libraries.
  const { Map } = await google.maps.importLibrary('maps');
  const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary(
    'marker'
  );

  let lat = parseFloat($('#latitude_value').val());
  let lng = parseFloat($('#longitude_value').val());

  let myLatlng = {
    lat,
    lng
  };

  const map = new Map(document.getElementById('map'), {
    center: { lat, lng },
    zoom: 14,
    mapId: '4504f8b37365c3d0'
  });

  // Each PinElement is paired with a MarkerView to demonstrate setting each parameter.
  // [START maps_advanced_markers_basic_style_title]
  // Default marker with title text (no PinElement).
  //   const markerViewWithText = new AdvancedMarkerElement({
  //     map,
  //     position: { lat: 37.419, lng: -122.03 },
  //     title: 'Title text for the marker at lat: 37.419, lng: -122.03'
  //   });
  // [END maps_advanced_markers_basic_style_title]
  // [START maps_advanced_markers_basic_style_scale]
  // Adjust the scale.
  const pinScaled = new PinElement({
    scale: 1.5
  });
  const markerViewScaled = new AdvancedMarkerElement({
    map,
    position: { lat: lat, lng: lng },
    content: pinScaled.element
  });
  // [END maps_advanced_markers_basic_style_scale]
  // [START maps_advanced_markers_basic_style_background]
  // Change the background color.
  //   const pinBackground = new PinElement({
  //     background: '#FBBC04'
  //   });
  //   const markerViewBackground = new AdvancedMarkerElement({
  //     map,
  //     position: { lat: 37.419, lng: -122.01 },
  //     content: pinBackground.element
  //   });
  //   // [END maps_advanced_markers_basic_style_background]
  //   // [START maps_advanced_markers_basic_style_border]
  //   // Change the border color.
  //   const pinBorder = new PinElement({
  //     borderColor: '#137333'
  //   });
  //   const markerViewBorder = new AdvancedMarkerElement({
  //     map,
  //     position: { lat: 37.415, lng: -122.03 },
  //     content: pinBorder.element
  //   });
  //   // [END maps_advanced_markers_basic_style_border]
  //   // [START maps_advanced_markers_basic_style_glyph]
  //   // Change the glyph color.
  //   const pinGlyph = new PinElement({
  //     glyphColor: 'white'
  //   });
  //   const markerViewGlyph = new AdvancedMarkerElement({
  //     map,
  //     position: { lat: 37.415, lng: -122.02 },
  //     content: pinGlyph.element
  //   });
  //   // [END maps_advanced_markers_basic_style_glyph]
  //   // [START maps_advanced_markers_basic_style_hide_glyph]
  //   // Hide the glyph.
  //   const pinNoGlyph = new PinElement({
  //     glyph: ''
  //   });
  //   const markerViewNoGlyph = new AdvancedMarkerElement({
  //     map,
  //     position: { lat: 37.415, lng: -122.01 },
  //     content: pinNoGlyph.element
  //   });
  // [END maps_advanced_markers_basic_style_hide_glyph]

  // Create the initial InfoWindow.
  let infoWindow = new google.maps.InfoWindow({
    content: 'Click the map to get Lat/Lng!',
    position: myLatlng
  });
  map.addListener('click', mapsMouseEvent => {
    // Close the current InfoWindow.
    infoWindow.close();
    // Create a new InfoWindow.
    infoWindow = new google.maps.InfoWindow({
      position: mapsMouseEvent.latLng
    });
    infoWindow.setContent(
      JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
    );
    infoWindow.open(map);

    let { lat, lng } = mapsMouseEvent.latLng.toJSON();

    console.log(lat);

    console.log(lng);
    $('#latitude_value').val(parseFloat(lat));
    $('#longitude_value').val(parseFloat(lng));
  });

  $('#map').css({
    height: '400px',
    'font-size': '200%',
    'over-flow': 'block'
  });
}

initMap();
// [END maps_advanced_markers_basic_style]
