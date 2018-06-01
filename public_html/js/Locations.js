function LocationsMap() {


    this.controls = {
        inputs: {
            country: document.getElementById('location_country'),
            city: document.getElementById('location_city'),
            state: document.getElementById('location_state'),
            zip: document.getElementById('location_zip'),
            address: document.getElementById('location_address'),
            lat: document.getElementById('location_geo_lat'),
            lng: document.getElementById('location_geo_lng'),
            search_address: document.getElementById('search_address'),
            result_selector: document.getElementById('result_selector'),
        },
        output: {
            country: document.getElementById('decoded_country'),
            city: document.getElementById('decoded_city'),
            state: document.getElementById('decoded_state'),
            zip: document.getElementById('decoded_zip'),
            address: document.getElementById('decoded_address'),
            lat: document.getElementById('decoded_geo_lat'),
            lng: document.getElementById('decoded_geo_lng'),
        },
        blocks: {
            result_selector_group: document.getElementById('result_selector_group'),
            map_holder: document.getElementById('map_holder'),
            map_wrapper: document.getElementById('map_wrapper'),
            result_count: document.getElementById('result_count'),
            search_block: document.getElementById('search_block'),
        },
        button: document.getElementById('btn_show_map'),
        lock_address: document.getElementById('lock_address'),
        decode: document.getElementById('btn_decode'),
        modal: document.getElementById('modal_edit'),
    };
    this.map = null;
    this.marker = null;
    this.lat = 0;
    this.lng = 0;
    this._params = undefined;
    this._restrictions = {};

    this.data = Array();
}

LocationsMap.prototype.run = function (params) {
    this._params = params;
    this.getRestrictedAreas();
}

LocationsMap.prototype._run = function () {
    var params = this._params;

    this.controls.output.country.innerHTML = this.controls.inputs.country.value;
    this.controls.output.city.innerHTML = this.controls.inputs.city.value;
    this.controls.output.state.innerHTML = this.controls.inputs.state.value;
    this.controls.output.zip.innerHTML = this.controls.inputs.zip.value;
    this.controls.output.address.innerHTML = this.controls.inputs.address.value;
    this.controls.output.lat.innerHTML = this.controls.inputs.lat.value;
    this.controls.output.lng.innerHTML = this.controls.inputs.lng.value;

    this.lat = this.controls.inputs.lat.value ? this.controls.inputs.lat.value * 1 : 0;
    this.lng = this.controls.inputs.lng.value ? this.controls.inputs.lng.value * 1 : 0;


    var self = this;
    this.map = new google.maps.Map(
        this.controls.blocks.map_holder,
        {
            center: {
                lat: this.lat,
                lng: this.lng
            },
            zoom: 15
        });
    this.marker = new google.maps.Marker({
        position: {
            lat: this.lat,
            lng: this.lng
        },
        draggable: true,
        map: this.map
    });
    this.determineLockState();
    this.marker.addListener('dragend', function () {
        self.getAddress(this.position);
    });
    $(this.controls.button).click(function () {
        $(self.controls.modal).modal('show');
    });
    $(this.controls.decode).click(function () {
        self.getPosition();
    });
    $(this.controls.inputs.search_address).on('keyup', function (e) {
        if (e.keyCode === 13) {
            self.getPosition();
        }
    });
    $(this.controls.lock_address).click(function () {
        if (self.validateLocation()) {
            for (var control in self.controls.output) {
                self.controls.inputs[control].value = self.controls.output[control].innerHTML;
                $(self.controls.modal).modal('hide');
            }
        } else {
            alert('Sorry, this location is not supported yet. Please contact the site administrator.');
        }

    });
    $(this.controls.inputs.result_selector).change(function () {
        self.selectorChange();
    });
    $(self.controls.modal).on("shown.bs.modal", function () {
        google.maps.event.trigger(self.map, "resize");
        self.map.setCenter({
            lat: self.lat,
            lng: self.lng
        });

    });
    if (params) {
        this.showMap();
    }
};
LocationsMap.prototype.determineLockState = function () {
    this.controls.output.country.dataset.required = (this.controls.output.country.innerHTML.trim() !== '');
    this.controls.output.city.dataset.required = (this.controls.output.city.innerHTML.trim() !== '');
    this.controls.output.address.dataset.required = (this.controls.output.address.innerHTML.trim() !== '');
    this.controls.output.lat.dataset.required = (this.controls.output.lat.innerHTML.trim() !== '');
    this.controls.output.lng.dataset.required = (this.controls.output.lng.innerHTML.trim() !== '');
    var state = !(
        (this.controls.output.country.innerHTML.trim() != '') &&
        (this.controls.output.city.innerHTML.trim() != '') &&
        (this.controls.output.address.innerHTML.trim() != '') &&
        (this.controls.output.lat.innerHTML.trim() != '') &&
        (this.controls.output.lng.innerHTML.trim() != ''));
    this.controls.lock_address.disabled = state;
}
// Ajax
LocationsMap.prototype.selectorChange = function () {
    var id = this.controls.inputs.result_selector.value
    var data = this.data[id];
    this.controls.output.country.innerHTML = data.components.country || '';
    this.controls.output.state.innerHTML = data.components.administrative_area_level_1 || '';
    this.controls.output.city.innerHTML = data.components.locality || data.components.postal_town || '';
    this.controls.output.zip.innerHTML = data.components.postal_code || '';
    this.controls.output.address.innerHTML = (data.components.route || '') + ' ' + (data.components.street_number || '');

    this.controls.output.lat.innerHTML = data.geo.lat;
    this.controls.output.lng.innerHTML = data.geo.lng;

    this.map.setCenter({
        lat: data.geo.lat,
        lng: data.geo.lng
    });
    this.marker.setPosition({
        lat: data.geo.lat,
        lng: data.geo.lng
    });
    this.determineLockState();
}
LocationsMap.prototype.showMap = function () {
//    this.controls.blocks.result_selector_group.style.display = ((this.data.length > 1) ? 'block' : 'none');
    this.controls.blocks.map_wrapper.style.display = 'block';

    //this.controls.blocks.search_block.style.display = 'none';
    google.maps.event.trigger(this.map, "resize");
    this.map.setCenter({
        lat: this.lat,
        lng: this.lng
    });
}
LocationsMap.prototype.hideMap = function () {
    this.controls.blocks.map_wrapper.style.display = 'none';
    this.controls.blocks.search_block.style.display = 'block';
}
LocationsMap.prototype.parseResults = function (data) {
    this.data = Array();
    this.controls.inputs.search_address.value = '';
    for (var i = 0; i < data.length; i++) {
        this.data.push(this.parseGoogleMapsResult(data[i]));
    }
    this.controls.inputs.result_selector.innerHTML = '';
    for (var i in this.data) {
        var item = this.data[i];
        var option = document.createElement('option');
        option.value = i;
        option.text = item.formatted_address + ((item.partial_match == true) ? ' (partial match)' : '');
        this.controls.inputs.result_selector.options.add(option);
    }
    if (this.data.length) {
        this.controls.blocks.result_count.innerHTML = this.data.length;
        this.showMap();
        this.selectorChange();
    }
}

LocationsMap.prototype.getPosition = function () {
    var address = this.controls.inputs.search_address.value.trim();
    if (address) {
        var url = 'https://maps.google.com/maps/api/geocode/json?address=' + encodeURIComponent(address) + '&sensor=false';
        var self = this;

        $.getJSON(url, function (data) {
            if (data.status == 'OK') {
                self.parseResults(data.results);
            }
        });
    }


};
LocationsMap.prototype.getAddress = function (latlng) {
    var self = this;
    var link = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + latlng.lat() + ',' + latlng.lng() + '&sensor=false';

    $.getJSON(link,
        function (data) {
            if (data.status = 'OK') {
                self.parseResults(data.results);
            }
        });
};
LocationsMap.prototype.parseGoogleMapsResult = function (data) {
    var result = {};
    result.partial_match = data.partial_match || false;
    if (data.address_components) {
        for (var i = 0; i < data.address_components.length; i++) {
            if (!result.components) {
                result.components = {};
            }
            if (!result.geo) {
                result.geo = {};
            }
            var item = data.address_components[i];
            result['components'][item.types[0]] = item.long_name;
        }
        if (data.formatted_address) {
            result.formatted_address = data.formatted_address;
        }
        if (data.place_id) {
            result.place_id = data.place_id;
        }
        result.geo.lat = data.geometry.location.lat;
        result.geo.lng = data.geometry.location.lng;
    }
    return result;
};
LocationsMap.prototype.getRestrictedAreas = function () {
    var self = this;
    var link = window.location.origin + '/ajax/get_area_restrictions';
    $.getJSON(link, function (data) {
        self._restrictions = data;
        self._run();
    })
}
LocationsMap.prototype.validateLocation = function () {
    var country = this.controls.output.country.innerHTML;
    var city = this.controls.output.city.innerHTML;
    return ((this._restrictions[country] != undefined) && (this._restrictions[country][city] != undefined));
}