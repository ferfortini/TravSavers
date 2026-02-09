
 <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

<script>
function initMap() {
  console.log("Maps JavaScript API loaded.");

  const advancedMarkers = document.querySelectorAll(
    "#marker-click-event-example gmp-advanced-marker",
  );

  for (const advancedMarker of advancedMarkers) {
    customElements.whenDefined(advancedMarker.localName).then(async () => {
      advancedMarker.addEventListener("gmp-click", async () => {
        const infoWindow = new google.maps.InfoWindow({
          //@ts-ignore
          content: advancedMarker.title,
        });

        infoWindow.open({
          //@ts-ignore
          anchor: advancedMarker,
        });
      });
    });
  }
}

window.initMap = initMap;

</script>


    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAy1L4SogCeS9kwHHK8n_0LKVGCtcDwUs4&callback=initMap&libraries=maps,marker&v=beta">
</script>  