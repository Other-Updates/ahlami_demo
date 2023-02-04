<?php
$theme_path = $this->config->item('theme_locations') . 'scootero';
$is_logo_allowed = $this->config->item('is_logo_allowed');
$is_favicon_allowed = $this->config->item('is_favicon_allowed');
$is_user_module_allowed = $this->config->item('user_modules');
$is_user_section_allowed = $this->config->item('user_sections');
?>
<div class="row">
    <div class="col-md-9">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Map</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            </div>
            <div id="map" style="height:550px;" class="panel-body">
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">On Ride</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="custom-tit">Unlock</div>
               
                <div class="gps-tracking-list">
                    <ul class="unlock-scooter">
                    <?php 
                        if (!empty($unlocked)){
                        foreach($unlocked as $unloc){
                    ?>
                    <li><?php echo $unloc['serial_number']; ?><li>
                        <?php } ?>
                    <?php } ?>
                    </ul>
                </div>
                
                <div class="custom-tit">Lock</div>
                <div class="gps-tracking-list">
                    <ul class="lock-scooter">
                    <?php if (!empty($locked)){
                    foreach($locked as $loc){?>
                        <li><?php echo $loc['serial_number']; ?><li>
                        <?php } ?>
                <?php } ?>
                    </ul>
                </div>
                <div class="custom-tit">GPS OFF/Unpluged</div>
                <div class="gps-tracking-list">
                    <ul class="unpluged-scooter">
                    <?php if (isset($timestamp) && !empty($timestamp)){
                    foreach($timestamp as $time){?>
                        <li><?php echo $time['serial_number']; ?><li>
                        <?php } ?>
                <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwpXSYswuXaJyfDoBxXTxYeAYRwzZIjGE&callback=initMap"></script><script type="text/javascript">
  let map;
  let markers= [];
function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: new google.maps.LatLng(11.028345, 76.949513),
    zoom: 14,
  });
  var base_url = "<?php echo base_url(); ?>";
  const iconBase = base_url + "/themes/scootero/assets/images/";
  const icons = {
    unlock: {
      icon: iconBase + "ic_sc_maker_3_yellow_gif.gif",
    },
    lock: {
      icon: iconBase + "ic_sc_maker_3 _red.png",
    },
    gpsoff: {
      icon: iconBase + "ic_sc_maker_3_yellow.png",
    },
  };  
  var bounds = new google.maps.LatLngBounds();
  var bounds_inti_count=1;
  function fetchdata(){
    $.ajax({
      url: '<?php echo base_url(); ?>gps/marker/',
      type: 'GET',

      success: function(response){
        while(markers.length) { markers.pop().setMap(null); }
        var data =JSON.parse(response);
        $.each(data, function(key, value) {
          if(value.gps == 'OFF') {
            bounds.extend(new google.maps.LatLng(value.scoo_lat,value.scoo_long));
            const marker = new google.maps.Marker({
              position: new google.maps.LatLng(value.scoo_lat, value.scoo_long),
              icon: icons.gpsoff.icon,
              map: map
            });
            markers.push(marker);
          }
                    /* getting locked scooters*/
          else if(value.lock_status == 0) {
            bounds.extend(new google.maps.LatLng(value.scoo_lat,value.scoo_long));
            const marker = new google.maps.Marker({
              position: new google.maps.LatLng(value.scoo_lat, value.scoo_long),
              icon: icons.lock.icon,
              map: map
            });
            markers.push(marker);
          }
                    /* getting unlocked scooters*/
          else if(value.lock_status == 1) {
            bounds.extend(new google.maps.LatLng(value.scoo_lat,value.scoo_long));
            const marker = new google.maps.Marker({
              position: new google.maps.LatLng(value.scoo_lat, value.scoo_long),
              icon: icons.unlock.icon,
              map: map
            });
            markers.push(marker);
          }
        });
                  /* fit boundsing on map*/
        if(bounds_inti_count==1)
          map.fitBounds(bounds);
          bounds_inti_count++;
      }
    });
  }
  $(document).ready(function(){
    fetchdata();
    setInterval(fetchdata,30000);
  });
}
</script>