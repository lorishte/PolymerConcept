function initMap () {
	let locationSofia = {lat: 42.674149, lng: 23.243681};
	let locationPlovdiv = {lat: 42.145388, lng: 24.743449};
	let centerMap = {lat: 42.403650, lng: 23.915706};

	let zoomIndex = 7;
	const resolutionSmall = 670;

	if (window.innerWidth < resolutionSmall) zoomIndex = 6;


	let mapSofia = new google.maps.Map(document.getElementById('map-sofia'), {
		zoom: zoomIndex,
		center: centerMap
	});


	let markerSofia = new google.maps.Marker({
		position: locationSofia,
		map: mapSofia
	});

	let markerPlovdiv = new google.maps.Marker({
		position: locationPlovdiv,
		map: mapSofia
	});
}
