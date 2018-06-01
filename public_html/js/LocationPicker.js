function LocationPicker() {
    this.locations = Array();
    this.locations_data = Array();

    this.selector_country = document.getElementById('location_country');
    this.selector_state = document.getElementById('location_state');
    this.selector_city = document.getElementById('location_city');
    this.selector_locations = document.getElementById('location_id');
    this.display_block = document.getElementById('location_display');
    this.local_time_block = document.getElementById('local_time');
    this.location_posted = (document.getElementById('location_posted') ? document.getElementById('location_posted').value : null);
}

LocationPicker.prototype.init = function () {
    this.getData();
};
LocationPicker.prototype.run = function () {
    var self = this;
    this.buildCountrySelector();
    this.buildStateSelector();
    this.buildCitySelector();
    this.buildLocationsSelector();

    $(this.selector_country).change(function () {
        self.buildStateSelector();
        self.buildCitySelector();
        self.buildLocationsSelector();
    });

    $(this.selector_state).change(function () {
        self.buildCitySelector();
        self.buildLocationsSelector();
    });

    $(this.selector_city).change(function () {
        self.buildLocationsSelector();
    });
    $(this.selector_locations).change(function () {
        self.showLocationData(this.value);
    });
    if (this.location_posted !== null) {
        var location_posted = this.locations_data[this.location_posted];
        this.selector_country.selectedIndex = this.findIndex(this.selector_country, location_posted['country']);
        this.buildStateSelector();
        this.selector_state.selectedIndex = this.findIndex(this.selector_state, location_posted['state']);
        this.buildCitySelector();
        this.selector_city.selectedIndex = this.findIndex(this.selector_city,location_posted['city']);
        this.buildLocationsSelector();
        this.selector_locations.selectedIndex = this.findIndex(this.selector_locations, this.location_posted);
        this.showLocationData(this.location_posted);
    }

};

LocationPicker.prototype.buildCountrySelector = function () {
    this.selector_country.innerHTML = '';

    var countries = []
    for (var country in this.locations) {
        countries.push(country);
    }

    countries = this.sortArray(countries);
    for (var country in countries) {
        var option = document.createElement('option');
        option.innerText = countries[country];
        this.selector_country.appendChild(option);
    }
}

LocationPicker.prototype.buildStateSelector = function () {
    this.selector_state.innerHTML = '';

    var states = []
    for (var state in this.locations[this.selector_country.value]) {
        states.push(state);
    }

    states = this.sortArray(states);
    for (var state in states) {
        var option = document.createElement('option');
        option.innerText = states[state];
        this.selector_state.appendChild(option);
    }
}

LocationPicker.prototype.buildCitySelector = function () {
    this.selector_city.innerHTML = '';

    var cities = []
    for (var city in this.locations[this.selector_country.value][this.selector_state.value]) {
        cities.push(city);
    }

    cities = this.sortArray(cities);
    for (var city in cities) {
        var option = document.createElement('option');
        option.innerText = cities[city];
        this.selector_city.appendChild(option);
    }
}

LocationPicker.prototype.buildLocationsSelector = function () {
    this.selector_locations.innerHTML = '';
    var local = this.locations[this.selector_country.value][this.selector_state.value][this.selector_city.value];
    for (var location in local) {
        var option = document.createElement('option');
        option.value = local[location]['id'];
        option.innerText = local[location]['title'];
        this.selector_locations.appendChild(option);
    }

    this.showLocationData(this.selector_locations.value);
}

LocationPicker.prototype.showLocationData = function (id) {
    var location = this.locations_data[id];

    this.display_block.innerHTML = '';
    this.display_block.appendChild(this.createElement({
        tag: 'div',
        attributes: {
            class: 'row'
        },
        children: [
            this.createElement({
                tag: 'div',
                attributes: {
                    class: 'col-md-4 align-center',
                    style: ((location.logo == '') ? 'display:none' : '')
                },
                children: [
                    this.createElement({
                        tag: 'img',
                        attributes: {
                            class: 'img img-responsive',
                            src: location.logo,
                            style: 'width : 100px;'
                        }
                    })
                ]
            }),
            this.createElement({
                tag: 'div',
                attributes: {
                    class: 'col-md-' + ((location.logo == '') ? '12' : '8')
                },
                children: [
                    this.createElement({
                        tag: 'h3',
                        text: location.title,
                        attributes: {
                            style: 'overflow: hidden;display: block;max-height: 2em;'
                        }
                    }),
                ]
            }),
            this.createElement({
                tag: 'div',
                attributes: {
                    class: 'col-md-12'
                },
                text: '<br>'
            }),
            this.createElement({
                tag: 'div',
                attributes: {
                    class: 'col-md-12'
                },
                text: '<strong>Address</strong>' + location.address +
                        '<br><strong>Type</strong>' + location.type.title +
                        '<br><strong>Managed by</strong><a href="' + location.user.link + '" target="_blank" class="btn btn-link" style="padding:0px">' + location.user.email + '</a>'
            })
        ]
    }));
    this.getLocalTime(location.geo.lat, location.geo.lng);
}
//utility
LocationPicker.prototype.findIndex = function (selector, value) {

    for (var option in selector.options) {
        if (selector.options[option].value == value) {
            return option;
        }
    }
    return 0;
}
LocationPicker.prototype.sortArray = function (arr) {
    arr.sort(function (a, b) {
        if (a < b)
            return -1;
        if (a > b)
            return 1;
        return 0;
    });
    return arr;
};
LocationPicker.prototype.getData = function () {
    var self = this;
    var url = window.location.protocol + '//' + window.location.host + '/ajax/get_locations';
    $.getJSON(url, function (data) {
        self.locations_data = data;
        self.locations = {};
        for (var i in data) {
            var object = {
                id: data[i]['id'],
                address: data[i]['address'],
                logo: data[i]['logo'],
                title: data[i]['title'],
            };
            if (!self.locations[data[i]['country']]) {
                self.locations[data[i]['country']] = {};
            }
            if (!self.locations[data[i]['country']][data[i]['state']]) {
                self.locations[data[i]['country']][data[i]['state']] = {};
            }
            if (!self.locations[data[i]['country']][data[i]['state']][data[i]['city']]) {
                self.locations[data[i]['country']][data[i]['state']][data[i]['city']] = Array();
            }
            self.locations[data[i]['country']][data[i]['state']][data[i]['city']][data[i]['id']] = object;
        }
        ;

        self.run();
    });

};
LocationPicker.prototype.getLocalTime = function (lat, lng) {
    this.local_time_block.innerHTML = '';
    var self = this;
    var url = window.location.protocol + '//' + window.location.host + '/ajax/get_local_time?lng=' + lng + '&lat=' + lat;
    $.getJSON(url, function (data) {

        if (data.result == 'OK') {
            self.local_time_block.innerHTML = data.formatted;
        } else {
            self.local_time_block.innerHTML = data.result;
        }

    });
}
LocationPicker.prototype.createElement = function (params) {
    if (params.tag) {
        var element = document.createElement(params.tag);
        if (params.attributes) {
            for (var attribute in params.attributes) {
                element.setAttribute(attribute, params.attributes[attribute]);
            }
        }
        if (params.dataset) {
            for (var d in params.dataset) {
                element.setAttribute('data-' + d, params.dataset[d]);
            }
        }
        if (params.text) {
            element.innerHTML = params.text;
        }
        if (params.children) {
            for (var i = 0; i < params.children.length; i++) {
                element.appendChild(params.children[i]);
            }
        }
        if (params.events) {
            for (var e = 0; e < params.events.length; e++) {
                var ev = params.events[e];
                element.addEventListener(ev.event, ev.action);
            }
        }
    }
    return element;
};

$(document).ready(function () {
    var picker = new LocationPicker;
    picker.init();
});