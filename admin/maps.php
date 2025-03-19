<?php
session_start();
include '../sql/sql.php';
?>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Admiro admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities." />
  <meta name="keywords" content="admin template, Admiro admin template, best javascript admin, dashboard template, bootstrap admin template, responsive admin template, web app" />
  <meta name="author" content="pixelstrap" />
  <title>Maps</title>
  <!-- Favicon icon-->
  <link rel="icon" href="../assets/images/favicon.png" type="image/x-icon" />
  <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon" />
  <!-- Google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap" rel="stylesheet" />
  <!-- Flag icon css -->
  <link rel="stylesheet" href="../assets/css/vendors/flag-icon.css" />
  <!-- iconly-icon-->
  <link rel="stylesheet" href="../assets/css/iconly-icon.css" />
  <link rel="stylesheet" href="../assets/css/bulk-style.css" />
  <!-- iconly-icon-->
  <link rel="stylesheet" href="../assets/css/themify.css" />
  <!--fontawesome-->
  <link rel="stylesheet" href="../assets/css/fontawesome-min.css" />
  <!-- Whether Icon css-->
  <link rel="stylesheet" type="text/css" href="../assets/css/vendors/weather-icons/weather-icons.min.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css" />
  <!-- App css -->
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link id="color" rel="stylesheet" href="../assets/css/color-1.css" media="screen" />
  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <!-- Leaflet Draw CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />

  <style>
    #map-1 {
      height: 600px;
    }

    .d-flex {
      display: flex;
      gap: 10px;
      margin-bottom: 15px;
    }

    .form-control {
      width: 200px;
    }

    .hoverinfo {
      background: #fff;
      padding: 5px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }
  </style>
</head>

<body>
  <!-- page-wrapper Start-->
  <!-- tap on top starts-->
  <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
  <!-- tap on tap ends-->
  <!-- loader-->
  <div class="loader-wrapper">
    <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
  </div>
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <?php include 'topbar.php'; ?>
    <!-- Page Body Start-->
    <!-- Page sidebar start-->
    <?php include 'sidebar.php'; ?>
    <!-- Page sidebar end-->
    <div class="page-body-wrapper">
      <!-- Page sidebar start-->

      <!-- Page sidebar end-->
      <div class="page-body">
        <div class="container-fluid">
          <div class="page-title">
            <div class="row">
              <div class="col-sm-6 col-12">
                <h2>Data map </h2>
              </div>
              <div class="col-sm-6 col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"> <a href="index.html"> <i class="iconly-Home icli svg-color"></i></a></li>
                  <li class="breadcrumb-item">Map</li>
                  <li class="breadcrumb-item active">Data Map </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-header card-no-border pb-0">
                  <h3>Geographical Map</h3>
                  <div class="d-flex">
                    <input type="text" id="barangayName" class="form-control" placeholder="Barangay Name" />
                    <input type="text" id="latitude" class="form-control" placeholder="Latitude" />
                    <input type="text" id="longitude" class="form-control" placeholder="Longitude" />
                    <button id="addPoint" class="btn btn-primary">Locate Location</button>
                    <button id="savePolygon" class="btn btn-primary">Save Map</button>
                  </div>
                </div>

                <!-- Map Container -->
                <div class="card-body">
                  <div class="data-map" id="map-1"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- jquery-->
  <!-- jquery-->
  <script src="../assets/js/vendors/jquery/jquery.min.js"></script>
  <!-- bootstrap js-->
  <script src="../assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js" defer=""></script>
  <script src="../assets/js/vendors/bootstrap/dist/js/popper.min.js" defer=""></script>
  <!--fontawesome-->
  <script src="../assets/js/vendors/font-awesome/fontawesome-min.js"></script>
  <!-- sidebar -->
  <script src="../assets/js/sidebar.js"></script>
  <!-- config-->
  <script src="../assets/js/config.js"></script>
  <!-- Datamap js-->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <!-- Leaflet Draw JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>


  <!-- scrollbar-->
  <script src="../assets/js/scrollbar/simplebar.js"></script>
  <script src="../assets/js/scrollbar/custom.js"></script>
  <!-- slick-->
  <script src="../assets/js/slick/slick.min.js"></script>
  <script src="../assets/js/slick/slick.js"></script>
  <!-- theme_customizer-->
  <script src="../assets/js/theme-customizer/customizer.js"></script>
  <!-- custom script -->
  <script src="../assets/js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC_NLGksjRy8c0vdcVc49R_egeVineVo0&libraries=drawing,geometry"></script>
  <script src="../assets/js/vendors/datamaps/src/js/components/d3/d3.min.js"></script>
  <script>
    let map, drawingManager, currentPolygon = null;

    function initMap() {
      // Initialize Google Map
      map = new google.maps.Map(document.getElementById('map-1'), {
        center: {
          lat: 10.3157,
          lng: 123.8854
        },
        zoom: 7,
        styles: [
          {
            featureType: "all",
            elementType: "labels",
            stylers: [{ visibility: "on" }]
          },
          {
            featureType: "administrative",
            elementType: "geometry.stroke",
            stylers: [
              { color: "#ffffff" },
              { weight: 1 }
            ]
          },
          {
            featureType: "landscape",
            elementType: "geometry",
            stylers: [
              { color: "#f5f5f5" }
            ]
          },
          {
            featureType: "water",
            elementType: "geometry",
            stylers: [
              { color: "#e9e9e9" }
            ]
          }
        ]
      });

      map.setOptions({
        mapTypeControl: true,
        mapTypeControlOptions: {
          style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
          position: google.maps.ControlPosition.TOP_RIGHT,
          mapTypeIds: [
            google.maps.MapTypeId.ROADMAP,
            google.maps.MapTypeId.SATELLITE,
            google.maps.MapTypeId.HYBRID,
            google.maps.MapTypeId.TERRAIN
          ]
        }
      });

      // Geolocation: Set Current Location
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function(position) {
            const userLocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            map.setCenter(userLocation);
            map.setZoom(14);

            new google.maps.Marker({
              position: userLocation,
              map: map,
              title: "📍 You are here!"
            });
          },
          function(error) {
            console.error("Geolocation error:", error);
            alert("Failed to get current location. Using default view.");
          }
        );
      }

      // Drawing Manager for Polygons
      drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.POLYGON,
        drawingControl: true,
        drawingControlOptions: {
          position: google.maps.ControlPosition.TOP_CENTER,
          drawingModes: ['polygon']
        },
        polygonOptions: {
          fillColor: '#4B89DC',
          fillOpacity: 0.6,
          strokeColor: '#FFFFFF',
          strokeWeight: 2,
          clickable: true,
          editable: true,
          zIndex: 1
        }
      });
      drawingManager.setMap(map);

      // Capture Drawn Polygon
      google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
        if (currentPolygon) currentPolygon.setMap(null); // Remove previous polygon
        currentPolygon = event.overlay;

        // Add hover effect and popup
        google.maps.event.addListener(currentPolygon, 'mouseover', function(e) {
          const infoWindow = new google.maps.InfoWindow({
            content: `<strong>Polygon Area:</strong> ${google.maps.geometry.spherical.computeArea(currentPolygon.getPath()).toFixed(2)} m²`
          });
          infoWindow.setPosition(e.latLng);
          infoWindow.open(map);
        });

        google.maps.event.addListener(currentPolygon, 'mouseout', function() {
          map.setOptions({
            draggableCursor: null
          });
        });
      });

      // Load Existing Polygons from Database
      loadPolygons();
    }

    // Function to Load Polygons
    function loadPolygons() {
      let currentInfoWindow = null;

      $.ajax({
        url: 'get_polygons.php',
        method: 'GET',
        success: function(response) {
          let res = typeof response === "string" ? JSON.parse(response) : response;

          if (res.status === 'success' && res.data.length > 0) {
            // Create an array of colors to rotate through
            const colors = ['#4B89DC', '#E9573F', '#F6BB42'];  // Blue, Red, Orange like in the image
            
            res.data.forEach(function(poly, index) {
              const coords = JSON.parse(poly.coordinates).map(coord => ({
                lat: coord[0],
                lng: coord[1]
              }));

              // Rotate through colors
              const fillColor = colors[index % colors.length];

              const polygon = new google.maps.Polygon({
                paths: coords,
                strokeColor: '#FFFFFF',  // White borders
                strokeOpacity: 1,
                strokeWeight: 2,
                fillColor: fillColor,
                fillOpacity: 0.6,
                map: map,
                geodesic: true,
                clickable: true
              });

              // Hover effects
              google.maps.event.addListener(polygon, 'mouseover', function(e) {
                if (currentInfoWindow) {
                  currentInfoWindow.close();
                }

                polygon.setOptions({
                  fillOpacity: 0.8,
                  strokeWeight: 3
                });

                currentInfoWindow = new google.maps.InfoWindow({
                  content: `
                    <div style="padding: 10px;">
                      <div style="display: flex; justify-content: space-between; align-items: start;">
                        <h4 style="margin: 0 0 5px 0; color: ${fillColor};">
                          ${poly.barangay_name}
                        </h4>
                        <div style="display: flex; gap: 5px;">
                          <button onclick="editPolygon(${poly.id})" 
                            style="border: none; background: none; padding: 2px; cursor: pointer;">
                            <svg width="16" height="16" viewBox="0 0 24 24">
                              <use href="../assets/svg/icon-sprite.svg#edit-content"/>
                            </svg>
                          </button>
                          <button onclick="deletePolygon(${poly.id})" 
                            style="border: none; background: none; padding: 2px; cursor: pointer;">
                            <svg width="16" height="16" viewBox="0 0 24 24">
                              <use href="../assets/svg/icon-sprite.svg#trash1"/>
                            </svg>
                          </button>
                        </div>
                      </div>
                      <div style="font-size: 12px;">
                        <strong>Latitude:</strong> ${poly.latitude}<br>
                        <strong>Longitude:</strong> ${poly.longitude}<br>
                        <strong>Created:</strong> ${poly.created_at}
                      </div>
                    </div>
                  `
                });
                currentInfoWindow.setPosition(e.latLng);
                currentInfoWindow.open(map);
              });

              google.maps.event.addListener(polygon, 'mouseout', function() {
                if (currentInfoWindow) {
                  currentInfoWindow.close();
                  currentInfoWindow = null;
                }
                polygon.setOptions({
                  fillOpacity: 0.6,
                  strokeWeight: 2
                });
              });
            });
          } else {
            Swal.fire({
              icon: 'info',
              title: 'No Polygons Found',
              text: 'No existing polygons were found in the database.'
            });
          }
        },
        error: function(xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Error Loading Polygons',
            text: 'Could not load polygons from the database.',
            footer: `Error: ${error}`
          });
        }
      });
    }

    // Initialize Map on Page Load
    google.maps.event.addDomListener(window, 'load', initMap);

    // Add this code after the initMap() function
    document.getElementById('savePolygon').addEventListener('click', function() {
        const barangayName = document.getElementById('barangayName').value;
        const latitude = parseFloat(document.getElementById('latitude').value);
        const longitude = parseFloat(document.getElementById('longitude').value);

        if (!barangayName) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: 'Please enter a Barangay Name.'
            });
            return;
        }

        let coordinates;

        // Check if we're using manual polygon or coordinates
        if (currentPolygon) {
            // Get coordinates from existing polygon
            coordinates = currentPolygon.getPath().getArray().map(coord => [
                coord.lat(),
                coord.lng()
            ]);
        } else if (!isNaN(latitude) && !isNaN(longitude)) {
            // Create a square polygon around the point
            const offset = 0.001; // Roughly 100 meters
            coordinates = [
                [latitude - offset, longitude - offset],
                [latitude - offset, longitude + offset],
                [latitude + offset, longitude + offset],
                [latitude + offset, longitude - offset]
            ];

            // Create polygon on map
            currentPolygon = new google.maps.Polygon({
                paths: coordinates.map(coord => ({
                    lat: coord[0],
                    lng: coord[1]
                })),
                strokeColor: '#00FF00',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#00FF00',
                fillOpacity: 0.35,
                map: map
            });

            // Center map on the new polygon
            map.setCenter({ lat: latitude, lng: longitude });
            map.setZoom(16);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: 'Please either draw a polygon or enter valid latitude/longitude coordinates.'
            });
            return;
        }

        // Prepare form data
        const formData = new FormData();
        formData.append('barangay_name', barangayName);
        formData.append('coordinates', JSON.stringify(coordinates));
        formData.append('latitude', coordinates[0][0]);  // First point's latitude
        formData.append('longitude', coordinates[0][1]); // First point's longitude

        // Send to server
        $.ajax({
            url: 'save_polygon.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Polygon saved successfully!'
                    }).then(() => {
                        // Reload polygons after successful save
                        loadPolygons();
                        // Clear the form
                        document.getElementById('barangayName').value = '';
                        document.getElementById('latitude').value = '';
                        document.getElementById('longitude').value = '';
                        if (currentPolygon) {
                            currentPolygon.setMap(null);
                            currentPolygon = null;
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to save polygon'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to save polygon: ' + error
                });
            }
        });
    });

    // Add this new function to handle the Locate Location button
    document.getElementById('addPoint').addEventListener('click', function() {
        const latitude = parseFloat(document.getElementById('latitude').value);
        const longitude = parseFloat(document.getElementById('longitude').value);

        if (isNaN(latitude) || isNaN(longitude)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Coordinates',
                text: 'Please enter valid latitude and longitude values.'
            });
            return;
        }

        // Center map on the coordinates
        const location = { lat: latitude, lng: longitude };
        map.setCenter(location);
        map.setZoom(16);

        // Add a marker at the location
        new google.maps.Marker({
            position: location,
            map: map,
            title: "Selected Location"
        });
    });

    // Add these new functions after your existing code
    function editPolygon(id) {
        // Find the polygon data
        $.ajax({
            url: 'get_polygons.php',
            method: 'GET',
            data: { id: id },
            success: function(response) {
                let res = typeof response === "string" ? JSON.parse(response) : response;
                if (res.status === 'success' && res.data.length > 0) {
                    const poly = res.data[0];
                    
                    // Show edit modal using SweetAlert2
                    Swal.fire({
                        title: 'Edit Barangay',
                        html: `
                            <input type="text" id="edit-barangay-name" class="swal2-input" 
                                placeholder="Barangay Name" value="${poly.barangay_name}">
                            <input type="text" id="edit-latitude" class="swal2-input" 
                                placeholder="Latitude" value="${poly.latitude}">
                            <input type="text" id="edit-longitude" class="swal2-input" 
                                placeholder="Longitude" value="${poly.longitude}">
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Save Changes',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            const formData = new FormData();
                            formData.append('barangay_id', id);
                            formData.append('edit_barangay', '1');
                            formData.append('barangay_name', document.getElementById('edit-barangay-name').value);
                            formData.append('latitude', document.getElementById('edit-latitude').value);
                            formData.append('longitude', document.getElementById('edit-longitude').value);

                            return $.ajax({
                                url: 'add-barangay.php',
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false
                            });
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated Successfully',
                                text: 'Barangay information has been updated.'
                            }).then(() => {
                                loadPolygons(); // Reload the polygons
                            });
                        }
                    });
                }
            }
        });
    }

    function deletePolygon(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'add-barangay.php',
                    method: 'GET',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'Barangay has been deleted.',
                            'success'
                        ).then(() => {
                            loadPolygons(); // Reload the polygons
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'Failed to delete barangay: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    }
  </script>


</body>

</html>