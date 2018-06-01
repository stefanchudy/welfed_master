function DonationSearcher() {
//    this.testMode = true;

    this.markers = Array();
    this.user_marker = null;
    this.circle = null;

    this.map = null;
    this.lng = 72.9384823;
    this.lat = 19.0448063;
    this.radius = null;

    this.minZoom = 15;

    this.mapWrapper = document.getElementById('map_wrapper');
    this.centerBtn = document.getElementById('center_map');
    this.searchBtn = document.getElementById('search_donation');
    this.diet = document.getElementById('preferences');

    this.controls = {};
    this.controls.radius = document.getElementById('search_radius');
    this.controls.results = document.getElementById('search_results');
}

DonationSearcher.prototype.init = function () {
    var self = this;
    $(this.centerBtn).click(function () {
        self.getMapCenter();
    });
    $(this.searchBtn).click(function () {
        self.setLatLng(self.map.getCenter());
    });
    $(this.diet).change(function () {
        self.setLatLng(self.map.getCenter());
    });
    $('input.allergy').change(function () {
        self.setLatLng(self.map.getCenter());
    });
    $('span.city').click(function () {
        self.setLatLng(new google.maps.LatLng(this.dataset.lat * 1 + 0.001, this.dataset.lng * 1 - 0.001));
    });
    this.getMapCenter();
};
DonationSearcher.prototype.setUserMarker = function () {
    var self = this;
    if (this.user_marker === null) {
        this.user_marker = new google.maps.Marker({
            position: {
                lat: this.lat,
                lng: this.lng
            },
            title: 'Your search is centered here. Drag the marker to new position, if you want to change the search center.',
            icon: 'img/user_marker.png',
            draggable: true,
            map: this.map
        });
        google.maps.event.addListener(this.user_marker, 'dragend', function () {
            self.setLatLng(this.getPosition());
            self.map.setCenter(this.getPosition());
            self.clearMarkers();
            self.getData();
        });
        this.circle = new google.maps.Circle({
            center: {
                lat: this.lat,
                lng: this.lng
            },
            radius: this.radius,
            fillColor: 'red',
            fillOpacity: 0.1,
            strokeColor: 'red',
            strokeOpacity: 0.3,
            strokeWeight: 1,
            map: this.map,
            visible: true
        });

    }
    this.user_marker.setPosition(
            {
                lat: this.lat,
                lng: this.lng
            }
    );
    this.circle.setCenter(
            {
                lat: this.lat,
                lng: this.lng
            }
    );

}
DonationSearcher.prototype.showMap = function () {
    var self = this;
    if (this.map === null) {
        this.map = new google.maps.Map(
                this.mapWrapper,
                {
                    center: {
                        lat: this.lat,
                        lng: this.lng
                    },
                    zoom: 13
                });
        this.setUserMarker();


    } else {
        this.map.setCenter({
            lat: this.lat,
            lng: this.lng
        });
        this.user_marker.setPosition(this.map.getCenter());
    }
    this.getData();
}
DonationSearcher.prototype.showMarkers = function (data) {
    var self = this;
    for (var i in data) {
        var item = data[i];
        var marker = new google.maps.Marker({
            position: {
                lat: parseFloat(item.lat),
                lng: parseFloat(item.lng)
            },
            icon: 'img/donation_marker.png',
            infoWindow: new google.maps.InfoWindow({
                content: this.getInfoWindow(item)
            }),
            map: this.map
        });
        this.markers.push(marker);
    }

    for (var i in this.markers) {
        google.maps.event.addListener(this.markers[i], 'click', function () {
            this.infoWindow.open(self.map, this);
        });
    }
    this.getBounds(data);
};
DonationSearcher.prototype.clearMarkers = function () {
    for (var i in this.markers) {
        this.markers[i].setMap(null);
    }
    this.markers = [];
}
DonationSearcher.prototype.getInfoWindow = function (data) {
    var result = '<div class="map_infowindow">';
    result += '<strong>' + data.title + '</strong>';
    result += 'in ' + data.location_title + '<br><br>';
    result += '<span class="remain"><span style="">' + data.remain + '</span>portion(s) remain </span><br>';
    result += 'distance ~' + (parseInt(data.distance / 1000)) + ' km.<br><br>';
    result += '<a class="btn btn-theme" href="donations/edit?id=' + data.id + '">Book now</a>';
    result += '</div>';
    return result;
}
DonationSearcher.prototype.getBounds = function (data) {
    var max = 0;
    var coef = 0.5;
    for (var i in data) {
        var item = data[i];

        if (Math.abs(parseFloat(item.lat) - this.lat) > max) {
            max = Math.abs(parseFloat(item.lat) - this.lat) * coef;
        }
        if (Math.abs(parseFloat(item.lng) - this.lng) > max) {
            max = Math.abs(parseFloat(item.lng) - this.lng) * coef;
        }
    }
    var sw = {
        lat: this.lat - max,
        lng: this.lng - max
    }
    var ne = {
        lat: this.lat + max,
        lng: this.lng + max
    }
    var bounds = new google.maps.LatLngBounds(sw, ne);
    this.map.fitBounds(bounds);
    if (this.map.getZoom() > this.minZoom) {
        this.map.setZoom(this.minZoom);
    }
//    this.map.setZoom(this.map.getZoom()-1);
}
DonationSearcher.prototype.getMapCenter = function () {
    var self = this;

    var secure = (window.location.protocol == 'https:');

    if (this.testMode || (secure && (navigator.geolocation))) {
        navigator.geolocation.getCurrentPosition(function (position) {

            self.lat = position.coords.latitude;
            self.lng = position.coords.longitude;
            self.centerBtn.style.display = 'block';
            self.showMap();
        });
    } else {
        self.showMap();
    }


}
DonationSearcher.prototype.getAllergies = function () {
    var list = document.querySelectorAll('.allergy:checked');
    if (list.length > 0) {
        var result_list = [];
        for (var i = 0; i < list.length; i++) {
            var item = list[i];
            result_list.push(parseInt(item.dataset.id));
        }
        return '&allergens=' + result_list.join(',');
    } else {
        return '';
    }
}
DonationSearcher.prototype.setLatLng = function (latLng) {
    this.lat = latLng.lat();
    this.lng = latLng.lng();
    this.setUserMarker();
    this.clearMarkers();
    this.getData()
}
DonationSearcher.prototype.getData = function () {
    var self = this;
    var url = window.location.protocol + '//' + window.location.host + '/ajax/search';
    var params = 'lat=' + this.lat + '&lng=' + this.lng + '&preferences=' + this.diet.value + this.getAllergies();
    params+='&timestamp='+new Date().getTime();    
    $.getJSON(url + '?' + params, function (data) {
        if (data && (data.status == 1)) {
            self.circle.setRadius(data.max_distance * 1000);
            self.showMarkers(data.items);
            if(data.count == 0 ){
                self.map.fitBounds(self.circle.getBounds());
            }
            
            self.controls.radius.innerHTML = data.max_distance;
            self.controls.results.innerHTML = data.count;
    
            
        }
    });

};

$(document).ready(function () {
    searcher = new DonationSearcher;
    searcher.init();
});