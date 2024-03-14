@extends('app.layout')
@section('title','Dashboard | Asset Management')
@section('vendor-style')
<style>
    #map
    {
        position: fixed !important; 
        height: 100% !important;
        width: 100% !important;
    }
</style>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
@endsection
@section('content')
    <div id="map"></div>
@endsection
@section('page-script')
<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
    ({key: "{{env('GOOGLE_MAP_KEY')}}", v: "weekly"});</script>
<script>
    async function initMap() {
  // Request needed libraries.
  const { Map } = await google.maps.importLibrary("maps");
  const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
  const map = new Map(document.getElementById("map"), {
    center: { lat: 20.593684, lng: 78.96288 },
    zoom: 5,
    mapId: "4504f8b37365c3d0",
  });
  @foreach($employee_current_location as $current_location)
    new AdvancedMarkerElement({
        map,
        position: { lat: {{$current_location['lat']}}, lng: {{$current_location['lang']}} },
        title:'{{$current_location['Name'] }} ({{$current_location['location_time']}})',
    });  
  @endforeach
}

initMap();
</script>
@endsection


