/**
 * @license
 * Copyright 2019 Google LLC. All Rights Reserved.
 * SPDX-License-Identifier: Apache-2.0
 */
// @ts-nocheck TODO remove when fixed

let geocoder;

function initMap() {
  geocoder = new google.maps.Geocoder();
}
function geocode(request) {
  /* clear() */
  geocoder
    .geocode(request)
    .then((result) => {
      const { results } = result;

      console.log(JSON.stringify(result.results[0].geometry.location));
      console.log(result.results[0].geometry.location);
    })
    .catch((e) => {
      alert("Geocode was not successful for the following reason: " + e);
    });
}
