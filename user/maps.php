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
    let map;

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

      // Load Existing Polygons from Database (View Only)
      loadPolygons();
    }

    // Modified loadPolygons function (View Only)
    function loadPolygons() {
      let currentInfoWindow = null;

      $.ajax({
        url: 'get_polygons.php',
        method: 'GET',
        success: function(response) {
          let res = typeof response === "string" ? JSON.parse(response) : response;

          if (res.status === 'success' && res.data.length > 0) {
            const colors = ['#4B89DC', '#E9573F', '#F6BB42'];

            res.data.forEach(function(poly, index) {
              const coords = JSON.parse(poly.coordinates).map(coord => ({
                lat: coord[0],
                lng: coord[1]
              }));

              const fillColor = colors[index % colors.length];

              const polygon = new google.maps.Polygon({
                paths: coords,
                strokeColor: '#FFFFFF',
                strokeOpacity: 1,
                strokeWeight: 2,
                fillColor: fillColor,
                fillOpacity: 0.6,
                map: map,
                geodesic: true,
                clickable: true
              });

              // Modified hover effect (View Only)
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
                      <div style="margin-bottom: 5px;">
                        <h4 style="margin: 0; color: ${fillColor};">
                          ${poly.barangay_name}
                        </h4>
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
          }
        }
      });
    }

    // Initialize Map on Page Load
    google.maps.event.addDomListener(window, 'load', initMap);
  </script>


</body>

</html>